<?php

namespace App\Http\Controllers\Apps\Product;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Subcategory;
use App\Models\Subsubcategory;
use App\Models\ProductSpecification;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\FilterOption;
use App\Models\ProductFilterValue;

class ProductEditController extends Controller
{
    //edit product
    public function edit(string $id)
    {
        // Retrieve the product with the given ID and its associated tags
        $product = Product::with('tags', 'specifications', 'filterValues')->find($id);

        // Retrieve other necessary data
        $brands = Brand::orderBy('name')->get();
        $attributes = Attribute::orderBy('attr_name')->where('status', 1)->get();
        $attribute_values = AttributeValue::orderBy('attr_value')->get();
        $categories = Category::orderBy('name')->get();
        $tagItem = $product->tags->pluck('name')->toArray();
        $tags = Tag::distinct()->pluck('name')->toArray();
        $productStocks = $product->productStock()->get();

        $filters = FilterOption::orWhereDoesntHave('categories')
            ->with('values')
            ->get();

        // Return the view with the necessary data
        return view('pages.apps.product.edit.edit', compact('brands', 'categories', 'attributes', 'attribute_values', 'tags', 'tagItem', 'product', 'productStocks', 'filters'));
    }

    public function update(Request $request, string $id)
    {
        // Find the product
        $product = Product::findOrFail($id);

        if (!empty($product)) {

            // Validate the request data
            $rules = [
                'name' => 'required|string|unique:products,name,' . $product->id,
                'brand_id' => 'nullable|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'sku_code' => 'nullable|string|max:255',
                'quantity' => 'required|integer',
                'status' => 'required|boolean',
                'base_price' => 'required|numeric',
                'thumb_image' => 'nullable|image',
                'back_image' => 'nullable|image',
                'gallery_image.*' => 'nullable|image',
                'discount_option' => 'nullable|in:1,2,3',
                'discount_percentage_or_flat_amount' => 'nullable|numeric|min:0',
                'status' => 'required|in:1,2,3,0',
                'publish_at' => 'nullable|date',
                // 'expire_date'               => 'nullable|date|after_or_equal:now',

            ];

            // Conditionally require the discount_percentage_or_flat_amount field
            if ($request->has('discount_option') && $request->discount_option != 1) {
                $rules['discount_percentage_or_flat_amount'] = 'required|numeric|min:1';
            }

            // Custom validation messages
            $messages = [
                'discount_percentage_or_flat_amount.required' => 'The discount amount is required when a discount option is selected.',
                'discount_percentage_or_flat_amount.numeric' => 'The discount amount must be a number.',
                'discount_percentage_or_flat_amount.min' => 'The discount amount must be at least 1.',
                'publish_at.required' => 'The publish date is required when scheduling the product.',
                'publish_at.date' => 'The publish date must be a valid date.',
                'publish_at.after_or_equal' => 'The publish date must be a current or future time.',
                'expire_date.after_or_equal' => 'The expiry date must be a current or future time.',
                'thumb_image.required' => 'Select a thumbnail image'
            ];

            // Validate the request data
            $validated = $request->validate($rules, $messages);

            $basePrice = $validated['base_price'];
            $discountData = $this->calculateDiscount($request, $basePrice);

            // Check if the discount amount exceeds the base price
            if ($discountData['discount_amount'] > $basePrice) {
                return response()->json([
                    'errors' => [
                        'discount_percentage_or_flat_amount' => ['Discount amount cannot exceed the base price.']
                    ]
                ], 422);
            }

            // Custom validation for variations' quantity based on attributes
            $errors = [];
            $variations = $request->input('variations', []);
            $attributesData = $request->input('attributes', []);

            foreach ($variations as $index => $variation) {
                $selectedAttributes = $attributesData[$index] ?? [];
                $optionQuantity = $variation['option_quantity'] ?? null;

                // Check if any attributes are checked (not empty) for this variation
                $hasCheckedAttributes = collect($selectedAttributes)->contains(function ($attribute) {
                    return !empty($attribute['attribute']);
                });

                // If attributes are checked, validate the quantity
                if ($hasCheckedAttributes) {
                    // Check if quantity is valid (required and greater than 0)
                    if (is_null($optionQuantity) || !is_numeric($optionQuantity) || $optionQuantity <= 0) {
                        $errors["variations.$index.option_quantity"] = ['The quantity is required and must be a positive number when attributes are selected.'];
                    }
                }
            }

            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            // update product data
            $data = $this->prepareProductData($validated, $request);

            // update product thumbnal
            $imageData = $this->handleFileUploads($request, $product);

            // update product
            $product->update(array_merge($data, $imageData));

            // Handle tags if provided
            $this->storeTags($request, $product);

            /// Update product options
            $attributes = $request->input('attributes', []);
            $option_qty = $request->input('variations', []);

            // Check if product has existing stock/variations
            if ($product->productStock()->count() > 0 && $attributes) {
                // Filter attributes: Ensure that attribute values are not null or empty
                $filteredAttributes = array_filter($attributes, function ($attributeGroup) {
                    foreach ($attributeGroup as $attribute) {
                        if (!empty($attribute['attribute_value']) && $attribute['attribute_value'] !== null) {
                            return true;
                        }
                    }
                    return false;
                });

                // Filter variations: Only variations with quantity > 0
                $filteredVariations = array_filter($option_qty, function ($variation) {
                    return isset($variation['option_quantity']) && $variation['option_quantity'] > 0;
                });

                // Handle combinations of attributes and variations
                $combinedFilteredData = [];

                foreach ($filteredVariations as $variationIndex => $variation) {
                    $quantity = $variation['option_quantity'] ?? 0;

                    $validAttributes = array_filter($filteredAttributes[$variationIndex] ?? [], function ($attribute) {
                        return isset($attribute['attribute_value']) && !empty($attribute['attribute_value']);
                    });

                    if (!empty($validAttributes)) {
                        $combinedFilteredData[] = [
                            'quantity' => $quantity,
                            'attributes' => $validAttributes,
                            'id' => $variation['id'] ?? null, // If it exists
                        ];
                    }
                }

                if (!empty($combinedFilteredData)) {
                    // Pass the product and combinedFilteredData to the update function
                    $this->updateProductOptions($combinedFilteredData, $product);
                }
            } elseif ($request->has('deleteAllOption')) {
                $this->deleteAllOption($product);
            } else {
                // Filter attributes: Ensure that attribute values are not null or empty
                $filteredAttributes = array_filter($attributes, function ($attributeGroup) {
                    foreach ($attributeGroup as $attribute) {
                        if (!empty($attribute['attribute_value']) && $attribute['attribute_value'] !== null) {
                            return true;
                        }
                    }
                    return false;
                });

                // Filter variations: Only variations with quantity > 0
                $filteredVariations = array_filter($option_qty, function ($variation) {
                    return isset($variation['option_quantity']) && $variation['option_quantity'] > 0;
                });

                // Handle combinations of attributes and variations
                $combinedFilteredData = [];

                foreach ($filteredVariations as $variationIndex => $variation) {
                    $quantity = $variation['option_quantity'] ?? 0;

                    $validAttributes = array_filter($filteredAttributes[$variationIndex] ?? [], function ($attribute) {
                        return isset($attribute['attribute_value']) && !empty($attribute['attribute_value']);
                    });

                    if (!empty($validAttributes)) {
                        $combinedFilteredData[] = [
                            'quantity' => $quantity,
                            'attributes' => $validAttributes,
                        ];
                    }
                }

                if (!empty($combinedFilteredData)) {
                    $this->storeProductOptions($combinedFilteredData, $product);
                }
            }

            // In your update controller
            $existingSpecIds = ProductSpecification::where('product_id', $product->id)->pluck('id')->toArray();

            $newSpecIds = [];

            if ($request->filled('spec_group')) {
                foreach ($request->spec_group as $gIndex => $groupName) {
                    if (empty($groupName))
                        continue;

                    if (!empty($request->spec_name[$gIndex])) {
                        foreach ($request->spec_name[$gIndex] as $i => $specName) {
                            $specValue = $request->spec_value[$gIndex][$i] ?? null;
                            $specId = $request->spec_id[$gIndex][$i] ?? null; // hidden input in form

                            if ($specName || $specValue) {
                                if ($specId) {
                                    // update existing
                                    $spec = ProductSpecification::find($specId);
                                    if ($spec) {
                                        $spec->update([
                                            'group' => $groupName,
                                            'name' => $specName,
                                            'value' => $specValue,
                                        ]);
                                        $newSpecIds[] = $spec->id;
                                    }
                                } else {
                                    // create new
                                    $spec = ProductSpecification::create([
                                        'product_id' => $product->id,
                                        'group' => $groupName,
                                        'name' => $specName,
                                        'value' => $specValue,
                                    ]);
                                    $newSpecIds[] = $spec->id;
                                }
                            }
                        }
                    }
                }
            }

            // delete removed specs
            $toDelete = array_diff($existingSpecIds, $newSpecIds);
            ProductSpecification::whereIn('id', $toDelete)->delete();

            // category filtering
            $filters = $request->input('filters', []);
            $syncData = [];

            foreach ($filters as $filterId => $values) {
                foreach ($values as $valueId) {
                    $syncData[$valueId] = ['filter_option_id' => $filterId];
                }
            }
            $product->filterValues()->sync($syncData);

            session::flash('success', 'The product updated successfully');
            return response()->json([
                'message' => 'Product updated successfully!',
                'product' => $product->id,
            ]);
        }
    }

    // Update existing product options and stock
    public function updateProductOptions(array $options, Product $product): void
    {
        // Get existing product stock IDs
        $existingStockIds = $product->productStock()->pluck('id')->toArray();

        foreach ($options as $option) {
            if (!empty($option['id'])) {
                // Update existing stock
                $productStock = $product->productStock()->find($option['id']);
                if ($productStock) {
                    $productStock->update([
                        'quantity' => $option['quantity'],
                    ]);

                    // Update attribute options for the stock
                    $this->updateOrCreateAttributeOptions($productStock, $option['attributes']);
                    // Remove updated stock from the list of existing IDs
                    $existingStockIds = array_diff($existingStockIds, [$option['id']]);
                }
            } else {
                // Create new stock if no existing stock ID
                $productStock = $product->productStock()->create([
                    'quantity' => $option['quantity'],
                ]);

                // Create attribute options for the new stock
                $this->updateOrCreateAttributeOptions($productStock, $option['attributes']);
            }
        }

        // Delete any remaining stock that was not updated
        if (!empty($existingStockIds)) {
            $product->productStock()->whereIn('id', $existingStockIds)->delete();
        }
    }

    // Method to update or create attribute options
    private function updateOrCreateAttributeOptions(ProductStock $productStock, array $attributes): void
    {
        // Get existing attribute options for this stock
        $existingOptions = $productStock->attributeOptions()
            ->select('id', 'attribute_id', 'attribute_value_id')
            ->get()
            ->toArray();

        foreach ($attributes as $attribute) {
            // Check if this attribute combination already exists
            $existingOption = collect($existingOptions)->firstWhere(function ($existingOption) use ($attribute) {
                return $existingOption['attribute_id'] == $attribute['attribute']
                    && $existingOption['attribute_value_id'] == $attribute['attribute_value'];
            });

            if ($existingOption) {
                // Update existing attribute option
                $productStock->attributeOptions()->where('id', $existingOption['id'])->update([
                    'attribute_id' => $attribute['attribute'],
                    'attribute_value_id' => $attribute['attribute_value'],
                ]);

                // Remove updated option from existing options
                $existingOptions = array_filter($existingOptions, function ($option) use ($existingOption) {
                    return $option['id'] !== $existingOption['id'];
                });
            } else {
                // Create new attribute option if it doesn't exist
                $productStock->attributeOptions()->create([
                    'attribute_id' => $attribute['attribute'],
                    'attribute_value_id' => $attribute['attribute_value'],
                ]);
            }
        }

        // Delete any attribute options that were not updated (remaining in $existingOptions)
        if (!empty($existingOptions)) {
            $remainingOptionIds = array_column($existingOptions, 'id');
            $productStock->attributeOptions()->whereIn('id', $remainingOptionIds)->delete();
        }
    }

    // create new product option and stock
    public function storeProductOptions(array $options, Product $product): void
    {
        foreach ($options as $option) {
            $productStock = $product->productStock()->create([
                'sku_code' => $product->sku_code,
                'quantity' => $option['quantity'],
            ]);

            // here sent the attribute option data
            foreach ($option['attributes'] as $attribute) {
                $productStock->attributeOptions()->create([
                    'attribute_id' => $attribute['attribute'] ?? null,
                    'attribute_value_id' => $attribute['attribute_value'] ?? null,
                ]);
            }
        }
    }


    //product attribute update and delete
    private function deleteAllOption(Product $product): void
    {
        // Delete existing options
        $product->productStock()->delete();
    }

    // Handle file uploads
    private function handleFileUploads(Request $request, Product $product): array
    {
        $data = [];

        // Handle thumb image
        if ($request->hasThumbRemove == 1) {
            // Delete old image from public folder
            if ($product->thumb_image && file_exists(public_path($product->thumb_image))) {
                unlink(public_path($product->thumb_image));
            }
            $data['thumb_image'] = null;
        } elseif ($request->hasFile('thumb_image')) {
            // Delete old image from public folder
            if ($product->thumb_image && file_exists(public_path($product->thumb_image))) {
                unlink(public_path($product->thumb_image));
            }

            $thumbImage = $request->file('thumb_image');
            $thumbImageName = time() . '_' . $thumbImage->getClientOriginalName();
            $thumbImage->move(public_path('uploads/product_images'), $thumbImageName);

            // Save the image path to the database
            $data['thumb_image'] = 'uploads/product_images/' . $thumbImageName;
        }


        // Handle back image
        if ($request->hasBackRemove == 1) {
            // Delete old back image from the public folder
            if ($product->back_image && file_exists(public_path($product->back_image))) {
                unlink(public_path($product->back_image));
            }
            $data['back_image'] = null;
        } elseif ($request->hasFile('back_image')) {
            // Delete old back image from the public folder
            if ($product->back_image && file_exists(public_path($product->back_image))) {
                unlink(public_path($product->back_image));
            }

            $backImage = $request->file('back_image');
            $backImageName = time() . '_' . $backImage->getClientOriginalName();
            $backImage->move(public_path('uploads/product_images'), $backImageName);

            // Save the image path to the database
            $data['back_image'] = 'uploads/product_images/' . $backImageName;
        }


        return $data;
    }


    private function prepareProductData(array $validated, Request $request): array
    {
        $discountDetails = $this->calculateDiscount($request, $validated['base_price']);
        return [
            'name' => $validated['name'],
            'brand_id' => $validated['brand_id'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_id' => $request->subsubcategory_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'key_features' => $request->key_features,
            'base_price' => $validated['base_price'],
            'quantity' => $validated['quantity'],
            'sku_code' => $request->sku_code,
            'video_link' => $request->video_link,
            'free_shipping' => $request->free_shipping ?? 'no',
            'is_new' => $request->is_new ?? 2,
            'is_featured' => $request->is_featured ?? 2,
            'status' => $request->status,
            'publish_at' => $request->publish_at,
            'expire_date' => $request->expire_date,
            'pre_order' => $request->preorder ?? 2,

            ...$discountDetails,
        ];
    }

    private function calculateDiscount(Request $request, float $basePrice): array
    {
        $discountPercentageOrFlatAmount = $request->discount_percentage_or_flat_amount ?? 0;
        $discountAmount = 0;

        if ($request->discount_option == 2) { // Percentage
            $discountAmount = round($basePrice * $discountPercentageOrFlatAmount / 100);
        } elseif ($request->discount_option == 3) { // Flat amount
            $discountAmount = $discountPercentageOrFlatAmount;
        }

        return [
            'discount_option' => $request->discount_option ?? 1,
            'discount_percentage_or_flat_amount' => $discountPercentageOrFlatAmount,
            'discount_amount' => $discountAmount,
            'offer_price' => $basePrice - $discountAmount,
        ];
    }

    //store tag
    private function storeTags(Request $request, Product $product): void
    {
        if ($request->has('tags')) {
            $tags = json_decode($request->tags, true);

            // Delete all existing tags for the product
            Tag::where('product_id', $product->id)->delete();

            if (!empty($tags)) {
                foreach ($tags as $tagData) {
                    if (!empty($tagData['value'])) {
                        // Create a new tag or find existing one
                        Tag::create([
                            'product_id' => $product->id,
                            'name' => $tagData['value'],
                        ]);
                    }
                }
            }
        }
    }
}

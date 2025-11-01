<div>
    @php
        $productStocks = $product->productStock ?? collect();
        $attributesList = $attributes->keyBy('id');
        $attributesValuesList = $attributesValues->keyBy('id');
        $groupedAttributes = [];

        $singleVariationStocks = $productStocks->filter(function ($productStock) {
            return $productStock->attributeOptions->count() === 1;
        });

        // Group values by attribute
        foreach ($singleVariationStocks as $productStock) {
            foreach ($productStock->attributeOptions as $option) {
                $groupedAttributes[$option->attribute_id][$option->id] =
                    $attributesValuesList[$option->attribute_value_id] ?? null;
            }
        }
    @endphp

    @if (!empty($groupedAttributes))
        @foreach ($groupedAttributes as $attribute_id => $values)
            @php
                $attribute = $attributesList[$attribute_id] ?? null;
                $attributeName = $attribute->attr_name ?? 'Option';
                $selectedValue = $selectedAttributes[$attributeName] ?? null;
            @endphp

            @if ($attribute && !empty($values))
                <div class="p-opt-wrap">
                    <div class="p-opt required">
                        <div class="p-opt-lbl">{{ $attributeName }}: <b></b></div>
                        <div class="p-opt-vals">
                            @foreach ($values as $optionId => $value)
                                @if ($value)
                                    <label>
                                        <input class="hide" type="radio" name="attribute[{{ $attribute_id }}]"
                                            value="{{ $optionId }}" title="{{ $value->attr_value }}"
                                            wire:click="$emit('selectAttribute', '{{ $attributeName }}', '{{ $value->attr_value }}')"
                                            {{ $selectedValue === $value->attr_value ? 'checked' : '' }}>
                                        <span class="{{ $selectedValue === $value->attr_value ? 'active' : '' }}">
                                            {{ $value->attr_value }}
                                        </span>
                                    </label>
                                @endif
                            @endforeach
                        </div>

                        {{-- Validation Error --}}
                        @if (!empty($attributeErrors[$attributeName]))
                            <div class="text-danger mt-1">
                                {{ $attributeErrors[$attributeName] }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach

    @endif


    <div class="cart-option">
        <label class="quantity">
            <span class="ctl minus"><i class="material-icons">remove</i></span>
            <span class="qty">
                <input class="quntity-filed form-control" type="text" wire:model="quantity" min="1"
                    data-quantity="{{ $product->quantity }}" value="1">
            </span>
            <span class="ctl plus"><i class="material-icons">add</i></span>
        </label>

        @if ($product->quantity > 0)
            <button id="button-cart" class="btn submit-btn" wire:click="addToCart">
                <span wire:loading.remove wire:target="addToCart">Buy Now</span>
                <span wire:loading wire:target="addToCart" class="formloader"></span>
            </button>
        @else
            <button class="btn submit-btn"
                style="background: #8080806b;border-color:#8080806b;box-shadow:rgba(0, 0, 0, 0.2) 0px 50px inset;"
                disabled>Out of stock!</button>
        @endif
    </div>


    @section('addcart-js')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const plusMinusWrappers = document.querySelectorAll('.quantity');

                plusMinusWrappers.forEach((wrapper) => {
                    const addButton = wrapper.querySelector('.plus');
                    const subButton = wrapper.querySelector('.minus');
                    const inputEl = wrapper.querySelector('.quntity-filed');

                    if (inputEl && inputEl.dataset.quantity) {
                        const maxQuantity = parseInt(inputEl.dataset.quantity);

                        addButton?.addEventListener('click', function() {
                            let currentValue = Number(inputEl.value);
                            if (currentValue < maxQuantity) {
                                inputEl.value = currentValue + 1;
                                inputEl.dispatchEvent(new Event('input'));
                            }

                            addButton.disabled = (inputEl.value >= maxQuantity);
                            subButton.disabled = false;
                        });

                        subButton?.addEventListener('click', function() {
                            let currentValue = Number(inputEl.value);
                            if (currentValue > 1) {
                                inputEl.value = currentValue - 1;
                                inputEl.dispatchEvent(new Event('input'));
                            }

                            subButton.disabled = (inputEl.value <= 1);
                        });

                        // Optional: Initial button state on page load
                        addButton.disabled = (inputEl.value >= maxQuantity);
                        subButton.disabled = (inputEl.value <= 1);
                    }
                });
            });
        </script>

        {{-- product qty and variaiton js --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Size swatches (new theme selector: .product-variations .size)
                var sizeItems = document.querySelectorAll('.product-variations .size');
                sizeItems.forEach(function(item) {
                    item.addEventListener('click', function() {
                        sizeItems.forEach(function(sizeItem) {
                            sizeItem.classList.remove('active');
                        });
                        this.classList.add('active');
                        var selectedSize = this.getAttribute('data-size');
                        Livewire.emit('selectSize', selectedSize);
                    });
                });

                // Color swatches (new theme selector: .product-variations .color)
                var colorItems = document.querySelectorAll('.product-variations .color');
                colorItems.forEach(function(item) {
                    item.addEventListener('click', function() {
                        colorItems.forEach(function(colorItem) {
                            colorItem.classList.remove('active');
                        });
                        this.classList.add('active');
                        var selectedColor = this.getAttribute('data-color');
                        Livewire.emit('selectColor', selectedColor);
                    });
                });

                // Clean All button (optional)
                var clearBtn = document.querySelector('.product-variation-clean');
                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        sizeItems.forEach(item => item.classList.remove('active'));
                        colorItems.forEach(item => item.classList.remove('active'));
                        Livewire.emit('clearSelections');
                    });
                }
            });
        </script>
    @endsection
</div>

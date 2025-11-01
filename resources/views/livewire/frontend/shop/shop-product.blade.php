 <div class="actions">
   @if( $product->productStock->count() > 0 )
        <a class="st-btn btn-add-cart" type="button" href="{{ route('product-details', $product->slug) }}"><i
            class="material-icons">shopping_cart</i> Buy Now</a>
   @else
        @if( $product->quantity > 0 )
            <span class="st-btn btn-add-cart" type="button" wire:click="addToCart">
                <i class="material-icons">shopping_cart</i> Add to Cart
            </span>
        @else
            <span class="st-btn btn-add add-cart" type="button">
                <i class="material-icons">error</i> Out of Stock
            </span>
        @endif
   @endif

   <span  class="st-btn btn-compare" type="button" wire:click="toggleWishlist({{ $productId }})">
        @if($isInWishlist)
            <i class="material-icons" style="color:#111;">bookmark</i> Unsave
        @else
            <i class="material-icons">bookmark_border</i> Save
        @endif
    </span>

</div>


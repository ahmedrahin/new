<div class="cards">
    @if (!$wishlistItems->isEmpty())
        @foreach ($wishlistItems as $item)
            <div class="card">
                <div class="img-n-title">
                    <div class="img-wrap">
                        <a href="{{ route('product-details', $item->product->slug) }}"><img
                                src="{{ asset($item->product->thumb_image) }}"></a>
                    </div>
                    <div class="title">
                        <h6 class="item-name"><a href="{{ route('product-details', $item->product->slug) }}">
                                {{ $item->product->name }}</a></h6>
                        @if ($item->product->quantity > 0)
                            <p>In Stock</p>
                        @elseif($item->product->quantity < 10 && $item->product->quantity > 0)
                            <p>Limited Stock</p>
                        @else
                            <p class="text-danger">Out of Stock</p>
                        @endif
                    </div>
                </div>
                <div class="amount p-item-price">
                    <span class="price-new">{{ $item->product->offer_price }}৳</span>
                    @if ($item->product->discount_option != 1)
                        <span class="price-old">{{ $item->product->base_price }}৳</span>
                    @endif
                </div>
                <div class="actions">
                    @if( $item->product->productStock->count() < 1 )
                        @if ($item->product->quantity > 0)
                            <button type="button"  class="btn ac-btn" style="width: 110px;" wire:click="addToCart({{ $item->product->id }})">
                                <span wire:loading.remove wire:target="addToCart({{ $item->product->id }})">Add Cart</span>
                                <span wire:loading wire:target="addToCart({{ $item->product->id }})" class="formloader"></span>
                            </button>
                        @else
                            <button type="button" class="btn ac-btn" style="width: 130px;" disabled>Out of stock</button>
                        @endif
                    @else
                        <a href="{{ route('product-details', $item->product->slug) }}" class="btn ac-btn" style="width: 110px;">Buy Now</a>
                    @endif
                    <span wire:click="removeFromWishlist({{ $item->id }})" style="cursor:pointer;"
                        class="ac-ico"><span class="material-icons">delete</span></span>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-content" style="padding:5px 0;">
            <span class="icon material-icons">assignment</span>
            <div class="empty-text ">
                <h5>No Product Found</h5>
            </div>
        </div>
    @endif
</div>

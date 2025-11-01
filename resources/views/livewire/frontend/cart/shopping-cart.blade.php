<div class="drawer m-cart" id="m-cart" wire:ignore.self>
    <div class="title">
        <p>YOUR CART</p>
        <span class="mc-toggler loaded close"><i class="material-icons">close</i></span>
    </div>
    <div class="content">
        @if (!empty($cart))
            @foreach ($cart as $cartKey => $item)
                <div class="item">
                    <div class="image">
                        <a href="{{ route('product-details', $item['slug']) }}">
                            <img src="{{ asset($item['image_url']) }}" width="47" height="47">
                        </a>
                    </div>
                    <div class="info">
                        <div class="name">
                            <a href="{{ route('product-details', $item['slug']) }}" style="color:#081621;">
                                {{ $item['name'] }}
                            </a>
                        </div>

                        {{-- Show attributes if available --}}
                        @if (!empty($item['attributes_info']))
                            <div class="cart-attributes" style="font-size: 13px; color: #666;">
                                @foreach ($item['attributes_info'] as $attr)
                                    <div><strong>{{ $attr['name'] }}:</strong> {{ $attr['value'] }}</div>
                                @endforeach
                            </div>
                        @endif

                        <span class="amount">{{ format_price($item['offer_price'], 0) }}৳</span>
                        <i class="material-icons">clear</i>
                        <span>{{ $item['quantity'] }}</span>
                        <span class="eq">=</span>
                        <span class="total"
                            style="color:#08b554;">{{ format_price($item['offer_price'] * $item['quantity']) }}৳</span>
                    </div>

                    <div class="remove" wire:click="removeItem('{{ $cartKey }}')" title="Remove">
                        <i class="material-icons" aria-hidden="true">delete</i>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-cart">
                <img src="{{ asset('frontend/image/no-shopping-cart.png') }}" alt="">
                <h4>Your Cart is Empty</h4>
            </div>
        @endif
    </div>

    @if (!empty($cart))
        <div class="footer">

            <div class="total ">
                <div class="title" style="text-align: start;padding-left:5px;">Total Quantity</div>
                <div class="amount">{{ array_sum(array_column($cart, 'quantity')) }}</div>
            </div>
            <div class="total" style="padding-bottom: 55px;">
                <div class="title" style="text-align: start;padding-left:5px;">Total</div>
                <div class="amount">{{ number_format($this->getTotalAmount(), 0) }}৳</div>
            </div>

            <div class="checkout-btn">
                <a href="{{ route('cart') }}">
                    <button class="btn submit" style="background:var(--s-secondary);">View Cart</button>
                </a>
                @if (config('website_settings.guest_checkout') == 1 && Auth::check())
                    <a href="{{ route('checkout') }}">
                        <button class="btn submit">Checkout</button>
                    </a>
                @elseif(config('website_settings.guest_checkout') == 0 && !Auth::check())
                    <a href="javascript:;">
                        <button class="btn submit"
                        onclick="message('warning', 'Please log in at first to checkout')">Checkout</button>
                    </a>
                @else
                    <a href="{{ route('checkout') }}">
                        <button class="btn submit">Checkout</button>
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>

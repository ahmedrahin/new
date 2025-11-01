<div>
    <section class="after-header p-tb-10">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="https://www.startech.com.bd/"><i class="material-icons" title="Home">home</i></a></li>
                <li><a href="https://www.startech.com.bd/checkout/cart">Shopping Cart</a></li>
            </ul>
        </div>
    </section>


    <section class="bg-bt-gray p-tb-15" style="padding-top: 50px;">
        <div class="container">
            <div class="content ws-box p-15">
                <h1 class="title">Shopping Cart </h1>

                <div class="table-responsive">
                    <table class="table table-bordered cart-table bg-white">
                        <thead>
                            <tr>
                                <td class="text-center">Action</td>
                                <td class="text-center rs-none">Image</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-center">Quantity</td>
                                <td class="text-right rs-none">Unit Price</td>
                                <td class="text-right">Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $cartKey => $item)
                            <tr>
                                <td class="text-center">
                                    <button type="submit" class="btn btn-danger btnremove"
                                        wire:click="removeItem('{{ $cartKey }}')">
                                        <i class="material-icons">clear</i>
                                    </button>
                                </td>
                                <td class="text-center rs-none">
                                    <a href="{{ route('product-details', $item['slug']) }}"><img
                                            src="{{ asset($item['image_url']) }}"
                                            alt="Gigasonic RB-G195S-300C 19.5&quot; HD LED Monitor"
                                            title="Gigasonic RB-G195S-300C 19.5&quot; HD LED Monitor"
                                            class="img-thumbnail" /></a>
                                </td>
                                <td class="text-left">
                                    <a href="{{ route('product-details', $item['slug']) }}">{{ $item['name'] }}</a>
                                    @if (!empty($item['attributes_info']))
                                    <br>
                                    @foreach ($item['attributes_info'] as $attr)
                                    <small>{{ $attr['name'] }}: {{ $attr['value'] }} @if(!$loop->last) -@endif</small>
                                    @endforeach
                                    @endif
                                </td>
                                <td class="text-center">
                                    <label class="quantity">
                                        <button type="button" wire:click="decrementQuantity('{{ $cartKey }}')">
                                            <i class="material-icons">remove</i>
                                        </button>
                                        <span class="qty">
                                            <input type="text" min="1" wire:model.lazy="quantities.{{ $cartKey }}"
                                                wire:change="updateQuantities('{{ $cartKey }}', $event.target.value)"
                                                value="{{ $item['quantity'] }}">
                                        </span>
                                        <button type="button" wire:click="incrementQuantity('{{ $cartKey }}')">
                                            <i class="material-icons">add</i>
                                        </button>
                                    </label>
                                </td>
                                <td class="text-right rs-none">{{ format_price($item['offer_price']) }}৳</td>
                                <td class="text-right">{{ $item['offer_price'] * $item['quantity'] }}৳</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered bg-white cart-total">
                            <tr>
                                <td class="text-right"><strong>Total Quantity:</strong></td>
                                <td class="text-right amount">{{ array_sum(array_column($cart, 'quantity')) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><strong>Total:</strong></td>
                                <td class="text-right amount">{{ number_format($this->getTotalAmount(), 0) }}৳</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="buttons">
                    <div class="pull-right"><a href="{{ url('/') }}" class="btn btn-primary">Continue
                            Shopping</a></div>

                    @if( config('website_settings.guest_checkout') == 1 && Auth::check() )
                    <div class="pull-right">
                        <a href="{{ route('checkout') }}" class="btn btn-primary checkout-btn">Continue Checkout</a>
                    </div>
                    @elseif( config('website_settings.guest_checkout') == 0 && !Auth::check() )
                    <div class="pull-right">
                        <button class="btn btn-primary checkout-btn"
                            onclick="message('warning', 'Please log in at first to checkout')">Continue
                            Checkout</button>
                    </div>
                    @else
                    <div class="pull-right">
                        <a href="{{ route('checkout') }}" class="btn btn-primary checkout-btn">Continue Checkout</a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
</div>
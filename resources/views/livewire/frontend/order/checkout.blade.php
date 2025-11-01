<div>

    <section class="checkout bg-bt-gray p-tb-15">
        <div class="container">
            <h1 class="page-title">Checkout</h1>

            <form class="checkout-content" wire:submit.prevent="order">
                <div class="row">
                    {{-- Left: Customer Info --}}
                    <div class="col-md-4 col-sm-12">
                        <div class="page-section ws-box">
                            <div class="section-head">
                                <h2><span>1</span>Customer Information</h2>
                            </div>
                            <div class="address">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control @error('name') error-border @enderror" wire:model="name" placeholder="Full Name*">
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control @error('phone') error-border @enderror" wire:model="phone" placeholder="Phone*">
                                    @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') error-border @enderror" wire:model="email" placeholder="Email*">
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control @error('shipping_address') error-border @enderror" wire:model="shipping_address"
                                        placeholder="Address*">
                                    @error('shipping_address') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="multiple-form-group">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select wire:model="district_id" class="form-control @error('district_id') error-border @enderror">
                                            <option value="">Select City</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }} - {{ $district->bn_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('district_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Order Note</label>
                                    <textarea class="form-control" rows="5" wire:model="note"
                                        placeholder="Notes about your order..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Payment, Delivery, Coupon, Summary --}}
                    <div class="col-md-8 col-sm-12">
                        <div class="row row-payment-delivery-order">

                            {{-- Payment Method --}}
                            <div class="col-md-6 col-sm-12 payment-methods">
                                <div class="page-section ws-box">
                                    <div class="section-head">
                                        <h2><span>2</span>Payment Method</h2>
                                    </div>
                                    <p>Select a payment method</p>
                                    <label class="radio-inline">
                                        <input type="radio" name="payment_type" wire:model="payment_type" value="cod"> Cash on Delivery
                                    </label>
                                    
                                </div>
                            </div>

                            {{-- Shipping Method --}}
                            <div class="col-md-6 col-sm-12 delivery-methods">
                                <div class="page-section ws-box">
                                    <div class="section-head">
                                        <h2><span>3</span>Delivery Method</h2>
                                    </div>
                                    <p>Select a delivery method</p>
                                    @foreach ($shippingMethods as $method)
                                        <label class="radio-inline" style="display: block;margin-bottom:10px;">
                                            <input type="radio" wire:model="selectedShippingMethodId"
                                                value="{{ $method->id }}">
                                            {{ $method->provider_name }} - ৳{{ $method->provider_charge }}
                                        </label>
                                    @endforeach
                                    <br>
                                    @if ($selectedShippingCharge)
                                        <div class="mt-2">
                                            <strong>Shipping (+): ৳{{ $selectedShippingCharge }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Coupon Code --}}
                            <div class="col-md-12 col-sm-12">
                                <div class="page-section ws-box voucher-coupon">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12" id="discount-coupon">
                                            @if (empty($appliedCoupon))
                                                <div class="input-group">
                                                    <input type="text" class="form-control" wire:model="couponCode"
                                                        placeholder="Promo / Coupon Code" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn st-outline btncouopn"
                                                            wire:click="applyCoupon">
                                                            <span wire:loading.remove wire:target="applyCoupon">Apply</span>
                                                            <span wire:loading wire:target="applyCoupon" class="formloader"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            @else
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="{{ $appliedCoupon['code'] }}" readonly>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn st-outline btncouopn"
                                                            wire:click="removeCoupon">
                                                            <span wire:loading.remove wire:target="removeCoupon">Cancel</span>
                                                            <span wire:loading wire:target="removeCoupon" class="formloader"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Order Overview --}}
                            <div class="col-md-12 col-sm-12 details-section-wrap">
                                <div class="page-section ws-box">
                                    <div class="section-head">
                                        <h2><span>4</span>Order Overview</h2>
                                    </div>
                                    <table class="table-bordered bg-white checkout-data">
                                        <thead>
                                            <tr>
                                                <td>Product Name</td>
                                                <td>Price</td>
                                                <td class="text-right">Total</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $item)
                                                <tr>
                                                    <td class="name">
                                                        <a href="{{ route('product-details', $item['slug']) }}">
                                                            {{ $item['name'] }}
                                                        </a>
                                                        @if (!empty($item['attributes_info']))
                                                            <br>
                                                            @foreach ($item['attributes_info'] as $attr)
                                                                <small>{{ $attr['name'] }}: {{ $attr['value'] }} @if(!$loop->last) -@endif</small>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="price">৳{{ format_price($item['offer_price'],0) }} x {{ $item['quantity'] }}</td>
                                                    <td class="price text-right">৳{{ format_price($item['offer_price'] * $item['quantity']) }}</td>
                                                </tr>
                                            @endforeach

                                            <tr class="total">
                                                <td colspan="2" class="text-right"><strong>Sub-Total:</strong></td>
                                                <td class="text-right">৳{{ format_price($this->getTotalAmount(), 0) }}</td>
                                            </tr>

                                            @if (!empty($appliedCoupon))
                                                <tr class="total">
                                                    <td colspan="2" class="text-right"><strong>Coupon Discount:</strong></td>
                                                    <td class="text-right" style="color:#ef4a23;">-৳{{ $appliedCoupon['discount'] }}</td>
                                                </tr>
                                            @endif

                                            @if ($selectedShippingCharge)
                                                <tr class="total">
                                                    <td colspan="2" class="text-right"><strong>Shipping Charge:</strong></td>
                                                    <td class="text-right">৳{{ $selectedShippingCharge }}</td>
                                                </tr>
                                            @endif

                                            <tr class="total">
                                                <td colspan="2" class="text-right"><strong>Total:</strong></td>
                                                <td class="text-right" style="color:#ef4a23;"><strong>৳{{ number_format($this->grandTotal(), 0) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Final Button & Terms --}}
                <div class="checkout-final-action mt-4">
                    <div class="agree-text mb-2">
                        I have read and agree to the
                        <a href="{{ route('terms') }}" target="_blank"><b>Terms & Conditions</b></a>,
                        <a href="{{ route('privacy.policy') }}" target="_blank"><b>Privacy Policy</b></a>,
                        and <a href="{{ route('refund.policy') }}" target="_blank"><b>Refund Policy</b></a>
                        <input type="checkbox" name="agree" checked>
                    </div>
                    <button type="submit" class="btn btn-dark pull-right btncouopn">
                        <span wire:loading.remove wire:target="order">Confirm Order</span>
                        <span wire:loading wire:target="order" class="formloader"></span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>

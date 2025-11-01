<div class="main-content p-items-wrap">
    @if (!$products->isEmpty())
        @foreach ($products as $product)
            <div class="p-item">
                <div class="p-item-inner">
                    <div class="p-item-img"><a href="{{ route('product-details', $product->slug) }}"><img src="{{ asset($product->thumb_image) }}"
                                alt="{{ $product->name }}" width="228" height="228"></a></div>
                    <div class="p-item-details">
                        <h4 class="p-item-name"> <a href="{{ route('product-details', $product->slug) }}">
                                {{ $product->name }}</a></h4>
                        @if (!is_null($product->short_description) && $product->short_description != '<p><br></p>')        
                            <div class="short-description">
                                {!! $product->short_description !!}
                            </div>
                        @endif
                        <div class="p-item-price">
                            <span class="price-new">{{ format_price($product->offer_price) }}৳</span>
                            @if ($product->discount_option != 1 )
                                <span class="price-old">{{ format_price($product->base_price) }}৳</span>
                            @endif
                        </div>

                       <livewire:frontend.shop.shop-product :productId="$product->id" />
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-content">
            <span class="icon material-icons">assignment</span>
            <div class="empty-text ">
                <h5>Sorry! No Product Founds</h5>
                <p>Please try searching for something else</p>
            </div>
        </div>
    @endif
</div>


<div class="bottom-bar">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <ul class="pagination">
                {{-- PREV Button --}}
                @if ($products->onFirstPage())
                <li><span class="disabled">PREV</span></li>
                @else
                <li>
                    <a href="{{ $products->previousPageUrl() }}" style="cursor:pointer;">PREV</a>
                </li>
                @endif

                {{-- Page Numbers --}}
                @for ($page = 1; $page <= $products->lastPage(); $page++)
                    @if ($page == $products->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                    @else
                    <li>
                        <a href="{{ $products->url($page) }}" style="cursor:pointer;">{{ $page }}</a>
                    </li>
                    @endif
                    @endfor

                    {{-- NEXT Button --}}
                    @if ($products->hasMorePages())
                    <li>
                        <a href="{{ $products->nextPageUrl() }}" style="cursor:pointer;">NEXT</a>
                    </li>
                    @else
                    <li><span class="disabled">NEXT</span></li>
                    @endif
            </ul>
        </div>

        <div class="col-md-6 rs-none text-right">
            <p>
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{
                $products->total() }} ({{ $products->lastPage() }} Pages)
            </p>
        </div>
    </div>
</div>


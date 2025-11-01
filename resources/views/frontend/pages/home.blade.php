@extends('frontend.layout.app')

@section('page-title')
Home
@endsection

@section('page-css')
<style>
    .banner .intro-wrapper {
        margin: 0 !important;
    }
</style>

@endsection

@section('body-content')

<div class="bg-gray content p-tb-30">
    <div class="container">
        <div class="row">

            <div class="col-md-12 col-lg-9">
                <div class="home-slider">
                    @foreach (App\Models\HomeSlider::get() as $banner)
                    <div class="slide" itemprop="itemListElement">
                        <a href="{{ url('/') }}" itemprop="url">
                            <img src="{{ asset($banner->image) }}" class="img-responsive" width="982" height="500"
                                itemprop="contentUrl" /></a>
                    </div>
                    @endforeach
                </div>
            </div>

            <livewire:frontend.compare.compare />

        </div>

        @if(config('website_settings.marquee_text'))
            <div class="sliding_text_wrap">
                <marquee direction="left">{{ config('website_settings.marquee_text') }}</marquee>
            </div>
        @endif

        <div class="m-home m-cat">
            <h2 class="m-header">Featured Category</h2>
            <p class="m-blurb">Get Your Desired Product from Featured Category!</p>
            <div class="cat-items-wrap">

                @foreach (App\Models\Subcategory::where('status', 1)->where('featured',1)->get() as $category)
                <div class="cat-item">
                    <a href="{{ route('subcategory.product', [$category->category->slug, $category->slug]) }}"
                        class="cat-item-inner">
                        <span class="cat-icon"><img
                                src="{{ $category->image ? asset($category->image) : asset('frontend/image/blank-image.svg') }}"
                                width="48" height="48">
                        </span>
                        <p>{{ $category->name }}</p>
                    </a>
                </div>
                @endforeach

            </div>
        </div>

        @php
            $featuredComparisons = App\Models\FullComparison::with(['firstProduct','secondProduct'])->orderBy('id','desc')->get();
        @endphp

        @if(!$featuredComparisons->isEmpty())
            <div class="m-compare m-home">
                <h3 class="m-header">Featured Comparisons</h3>
                <p class="m-blurb">Compare &amp; Choose Your Desired Product!</p>
                <div class="cmp-items-wrap p-items-wrap">
                    @foreach ($featuredComparisons as $comparison)
                        <div class="cmp-item p-item">
                            <div class="cmp-item-inner ws-box">
                                <div class="cmp-p-item-wrap">
                                    <div class="cmp-p-item">
                                        <div class="cmp-p-item-img">
                                            <a href="{{ route('product-details', $comparison->firstProduct->slug) }}">
                                                <img src="{{ asset($comparison->firstProduct->thumb_image) }}" width="228"
                                                    height="228" />
                                            </a>
                                        </div>
                                        <div class="cmp-p-item-details">
                                            <h4 class="p-item-name"> <a
                                                    href="{{ route('product-details', $comparison->firstProduct->slug) }}">{{ $comparison->firstProduct->name }}</a></h4>
                                            <div class="p-item-price">
                                                <span class="price-new">{{ format_price($comparison->firstProduct->offer_price) }}৳</span>
                                                @if ($comparison->firstProduct->discount_option != 1 )
                                                    <span class="price-old">{{ format_price($comparison->firstProduct->base_price) }}৳</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cmp-p-item">
                                        <div class="cmp-p-item-img">
                                            <a href="{{ route('product-details', $comparison->secondProduct->slug) }}">
                                                <img src="{{ asset($comparison->secondProduct->thumb_image) }}" width="228"
                                                    height="228" />
                                            </a>
                                        </div>
                                        <div class="cmp-p-item-details">
                                            <h4 class="p-item-name"> <a
                                                    href="{{ route('product-details', $comparison->secondProduct->slug) }}">{{ $comparison->secondProduct->name }}</a></h4>
                                            <div class="p-item-price">
                                                <span class="price-new">{{ format_price($comparison->secondProduct->offer_price) }}৳</span>
                                                @if ($comparison->secondProduct->discount_option != 1 )
                                                    <span class="price-old">{{ format_price($comparison->secondProduct->base_price) }}৳</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <span class="vs">VS</span>
                                </div>
                                <div class="actions">
                                   <a class="st-btn full-compare" href="{{ route('full.compare', ['ids' => $comparison->first_product_id . ',' . $comparison->second_product_id]) }}">
                                        Full Comparison
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <div class="container">
        <div class="m-product m-home" id="module-481">
            <h3 class="m-header">Featured Products</h3>
            <p class="m-blurb">Check &amp; Get Your Desired Product!</p>
            <div class="p-items-wrap">

                @foreach (App\Models\Product::activeProducts()->where('is_featured', 1)->latest()->get() as $product)
                <div class="p-item">
                    <div class="p-item-inner">
                        @php
                        $discountAmount = $product->base_price - $product->offer_price;
                        $discountPercent = round(($discountAmount / $product->base_price) * 100);
                        @endphp
                        @if ($product->discount_option != 1 )
                        <div class="marks">
                            <span class="mark">
                                Save: {{ $discountAmount }}৳ ({{ $discountPercent }}%)
                            </span>
                        </div>
                        @endif
                        <div class="p-item-img">
                            <a href="{{ route('product-details', $product->slug) }}">
                                <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}" width="228"
                                    height="228" /></a>
                        </div>
                        <div class="p-item-details">
                            <h4 class="p-item-name">
                                <a href="{{ route('product-details', $product->slug) }}">{{ $product->name }}</a>
                            </h4>

                            <div class="p-item-price">
                                <span class="price-new">{{ format_price($product->offer_price) }}৳</span>
                                @if ($product->discount_option != 1 )
                                <span class="price-old">{{ format_price($product->base_price) }}৳</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

    </div>
</div>


@endsection

@section('page-script')

@endsection

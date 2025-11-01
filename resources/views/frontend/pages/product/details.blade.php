@extends('frontend.layout.app')

@section('page-title')
    {{ $product->name }}
@endsection

@section('page-css')
    <link href="{{ asset('frontend/style/product.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .short-description p {
            margin-bottom: 4px !important;
            color: black !important;
        }

        .short-description span,
        .short-description li {
            color: black !important;
        }

        .short-description ul {
            padding: 0;
            margin: 0;
        }

        .short-description p {
            font-size: 15px;
            font-weight: 500;
        }
    </style>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1055;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal.show {
            display: block;
        }

        .product-details .review .average-rating {
            line-height: inherit;
        }

        .modal-dialog {
            position: relative;
            margin: auto;
            top: 15%;
            max-width: 600px;
            width: 100%;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .modal-header h4 {
            margin: 0;
        }

        .modal .btn-close {
            background: none;
            border: none;
            font-size: 1.2rem;
        }

        .modal-button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .modal .btn {
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .modal .btn-cancel {
            background: #8080806b;
        }

        .modal .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: .2em;
        }
    </style>

    <style>
        .reviews-product {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .reviews-product img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .reviews-product h5 {
            font-size: 20px;
            color: black;
            margin-bottom: 5px;
        }

        .reviews-product .customer-rating {
            padding: 20px 0;
        }

        .selectrating {
            border: none;
            display: inline-flex;
            flex-direction: row-reverse;
            /* Reverse the order of the stars */
        }

        .selectrating>input {
            display: none;
        }

        .customer-rating {
            padding: 10px 0 10px;
        }

        .selectrating>label:before {
            margin: 2px;
            font-size: 16px;
            font-family: FontAwesome;
            display: inline-block;
            content: "\f005";
            margin-bottom: 0;
        }


        .selectrating>label {
            color: #ddd;
            cursor: pointer;
        }

        /* Highlight stars on hover and selection */
        .selectrating>input:checked~label,
        .selectrating>label:hover,
        .selectrating>label:hover~label {
            color: #f93;
        }

        .modal label {
            font-weight: 500;
            font-size: 15px;
            color: #000000c9;
            padding-bottom: 7px;
            display: inline-block;
        }

        .selectrating label {
            color: #00000061;
        }

        .share-on a {
            padding: 0 3px;
        }

        @media (max-width: 667px) {
            .pd-q-actions .options span i {
                font-size: 16px;
                margin-right: 0px;
            }

            .add-compare {
                font-size: 13px;
            }
        }
    </style>
@endsection


@section('body-content')

    <section class="after-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="material-icons" title="Home">home</i></a></li>
                @if (isset($product->category))
                    <li>
                        <a
                            href="{{ route('category.product', $product->category->slug) }}"><span>{{ $product->category->name }}</span></a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('product-details', $product->slug) }}">
                        <span>{{ $product->name }}</span></a>
                </li>
            </ul>
        </div>
    </section>

    <div class="product-details content">
        <div class="product-details-summary">
            <div class="container">
                <div class="pd-q-actions" style="margin-top: 40px;">
                    <div class="share-on">
                        <span class="share">Share:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="javascript:void(0);" onclick="copyLink()">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>

                    <div class="options">
                        <livewire:frontend.wishlist.towishlist :productId="$product->id">
                            </livewire>
                            <livewire:frontend.wishlist.add-wishlist>
                                </livewire>

                                <livewire:frontend.compare.add-compare :productId="$product->id">
                                    </livewire>
                    </div>

                </div>

                <div class="basic row">
                    <div class="col-md-5 left">
                        <div class="images product-images">
                            <div class="product-img-holder">
                                <a href="{{ asset($product->thumb_image) }}" data-fancybox="gallery"
                                    data-caption="{{ $product->name }}">
                                    <img class="main-img" src="{{ asset($product->thumb_image) }}"
                                        alt="{{ $product->name }}" width="500" height="500" />
                                </a>
                            </div>

                            @if ($product->galleryImages->count() > 0)
                                <ul class="thumbnails">
                                    <li>
                                        <a class="thumbnail" href="{{ asset($product->thumb_image) }}"
                                            data-fancybox="gallery" data-caption="{{ $product->name }}">
                                            <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}"
                                                width="74" height="74" />
                                        </a>
                                    </li>

                                    @foreach ($product->galleryImages ?? [] as $gellary)
                                        <li>
                                            <a class="thumbnail" href="{{ asset($gellary->image) }}"
                                                data-fancybox="gallery" data-caption="{{ $product->name }}">
                                                <img src="{{ asset($gellary->image) }}" alt="{{ $product->name }}"
                                                    width="74" height="74" />
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-7 right" id="product">
                        <div class="pd-summary">
                            <div class="product-short-info">
                                <h1 itemprop="name" class="product-name">{{ $product->name }}</h1>
                                <table class="product-info-table">
                                    <tr class="product-info-group">
                                        <td class="product-info-label">Price</td>
                                        <td class="product-info-data product-price">
                                            <ins>{{ format_price($product->offer_price) }}৳</ins>
                                            @if ($product->discount_option != 1)
                                                <del
                                                    style="padding-left: 5px;color: #df1414;">{{ format_price($product->base_price) }}৳</del>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr class="product-info-group">
                                        <td class="product-info-label">Status</td>
                                        @if ($product->quantity > 0)
                                            <td class="product-info-data product-status">In Stock</td>
                                        @else
                                            <td class="product-info-data product-status" style="color:#ff0000a8;">Out of
                                                Stock!</td>
                                        @endif
                                    </tr>

                                    @if ($product->sku_code)
                                        <tr class="product-info-group">
                                            <td class="product-info-label">Product Code</td>
                                            <td class="product-info-data product-code">{{ $product->sku_code }}</td>
                                        </tr>
                                    @endif
                                    @if ($product->brand && !is_null($product->brand_id))
                                        <tr class="product-info-group">
                                            <td class="product-info-label">Brand</td>
                                            <td class="product-info-data product-brand">{{ $product->brand->name }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            @if (!is_null($product->key_features) && $product->key_features != '<p><br></p>')
                                <div class="short-description">
                                    <h2>Key Features</h2>
                                    {!! $product->key_features !!}
                                </div>
                            @endif

                            <livewire:frontend.cart.add-cart :productId="$product->id" />


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="pd-full">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <div class="navs">
                            <ul class="nav">
                                <li data-area="specification">Specification</li>
                                <li data-area="description">Description</li>
                                <li class="hidden-xs" data-area="ask-question">Questions
                                    ({{ $product->QuesionAnswer->count() }})</li>
                                <li data-area="write-review">Reviews ({{ $product->reviews->count() }})</li>
                            </ul>
                        </div>
                        <section class="specification-tab m-tb-10" id="specification">
                            <div class="section-head">
                                <h2>Specification</h2>
                            </div>
                            @if ($product->specifications->count() == 0)
                                <div class="empty-content" style="padding: 20px 0;">
                                    <span class="icon material-icons">table_chart</span>
                                    <div class="empty-text">There are no product specifications.</div>
                                </div>
                            @else
                                @foreach ($product->specifications->groupBy('group') as $groupName => $items)
                                    <table class="data-table flex-table" cellpadding="0" cellspacing="0">
                                        <colgroup>
                                            <col class="name" />
                                            <col class="value" />
                                        </colgroup>

                                        <thead>
                                            <tr>
                                                <td class="heading-row" colspan="3">{{ $groupName }}</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td class="name">{{ $item->name }}</td>
                                                    <td class="value">{{ $item->value }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            @endif
                        </section>

                        <section class="description bg-white m-tb-15" id="description">
                            <div class="section-head">
                                <h2>Description</h2>
                            </div>

                            @if (!is_null($product->long_description) && $product->long_description != '<p><br></p>')
                                <div class="full-description" itemprop="description">
                                    {!! $product->long_description !!}
                                </div>
                            @else
                                <div class="empty-content" style="padding: 20px 0;">
                                    <span class="icon material-icons">description</span>
                                    <div class="empty-text">There are no product description.</div>
                                </div>
                            @endif

                        </section>

                        <livewire:frontend.product.product-question :productId="$product->id" />

                        <livewire:frontend.product.product-review :productId="$product->id" />

                    </div>

                    <div class="col-lg-3 col-md-12 c-left">
                        @include('frontend.pages.product.related-product')
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script>
        function setRating(value) {
            Livewire.emit('updatedRating', value);
        }

        let modals = document.querySelectorAll('#Reviews-modal, #question-modal');
        modals.forEach((modal) => {
            modal.addEventListener('show.bs.modal', (e) => {
                Livewire.emit('open_add_modal');
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('success', function() {
                const cancelButtons = document.querySelectorAll('.cancel-modal-review');
                cancelButtons.forEach(button => {
                    button.click();
                });
            });
        });
    </script>
    <script>
        function copyLink() {
            const url = "{{ url()->current() }}";
            navigator.clipboard.writeText(url).then(() => {
                message('success', 'Link copied to clipboard ✅')
            }).catch(err => {
                console.error("Failed to copy: ", err);
            });
        }
    </script>
@endsection

@section('page-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.css" />
@endsection


<column id="column-left" class="col-sm-3">
    <span class="lc-close"><i class="material-icons" aria-hidden="true">close</i></span>
    <div class="filters">
        <div class="price-filter ws-box">
            <div class="label">
                <span>Price Range</span>
            </div>
            <div id="rang-slider" class="noUi-horizontal" data-from="{{ $from ?? 0 }}" data-to="{{ $to ?? 500000 }}"
                data-min="0" data-max="{{ 500000 }}">
            </div>

            <div class="range-label from">
                <input type="text" id="range-from" name="from" value="{{ $from ?? 0 }}">
            </div>

            <div class="range-label to">
                <input type="text" id="range-to" name="to" value="{{ $to ?? 500000 }}">
            </div>
        </div>

        <!-- Availability -->
        {{-- <div class="filter-group ws-box show">
            <div class="label"><span>Availability</span></div>
            <div class="items">
                <label class="filter">
                    <input type="checkbox" name="filter[]" value="status:7" />
                    <span>In Stock</span>
                </label>
                <label class="filter">
                    <input type="checkbox" name="filter[]" value="status:6" />
                    <span>Pre Order</span>
                </label>
            </div>
        </div> --}}

        @php
            $brandsQuery = App\Models\Brand::where('category_id', $category->id)->where('status', 1);

            if (isset($parentCategory)) {
                $brandsQuery->orWhere('category_id', $parentCategory->id);
            }

            $brands = $brandsQuery->get();
        @endphp

        {{-- Brand Filter --}}
        @if ($brands->count() > 0)
            <div class="filter-group ws-box show">
                <div class="label"><span>Brand</span></div>
                <div class="items">
                    @foreach ($brands as $brand)
                        @php
                            $isChecked =
                                request()->filled('filter') && in_array("brand:$brand->id", request()->filter ?? []);
                        @endphp
                        <label class="filter">
                            <input type="checkbox" name="filter[]" value="brand:{{ $brand->id }}"
                                {{ $isChecked ? 'checked' : '' }} />
                            <span>{{ $brand->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Dynamic Filters --}}
        @foreach ($filters as $filter)
            <div class="filter-group ws-box show">
                <div class="label"><span>{{ $filter->option_name }}</span></div>
                <div class="items">
                    @foreach ($filter->values as $value)
                        @php
                            $filterKey = $filter->id . ':' . $value->id;
                            $isChecked = request()->filled('filter') && in_array($filterKey, request()->filter ?? []);
                        @endphp
                        <label class="filter">
                            <input type="checkbox" name="filter[]" value="{{ $filterKey }}"
                                {{ $isChecked ? 'checked' : '' }} />
                            <span>{{ $value->option_value }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach


    </div>
</column>


@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.1/nouislider.min.js"></script>

    <script>
        jQuery(function($) {

            // Build query params
            function getFilters() {
                let params = new URLSearchParams();

                // Limit
                if ($('#input-limit').length) {
                    params.set('limit', $('#input-limit').val());
                }

                // Sort
                if ($('#input-sort').length) {
                    let sortVal = $('#input-sort').val();
                    if (sortVal === '') {
                        params.delete('sort');
                        params.delete('order');
                    } else if (sortVal.endsWith('_desc')) {
                        params.set('sort', sortVal.replace('_desc', ''));
                        params.set('order', 'DESC');
                    } else {
                        params.set('sort', sortVal);
                        params.set('order', 'ASC');
                    }
                }

                // Collect checked filters
                $('input[name="filter[]"]:checked').each(function() {
                    params.append('filter[]', $(this).val());
                });

                return params.toString();
            }

            // Load products
            function loadProducts(customUrl = null) {
                let url = customUrl || (window.location.pathname + '?' + getFilters());

                console.log("AJAX URL => ", url); // Debugging

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function() {
                        $('#product-list').addClass('loading');
                        $('#ajax-loader').show();
                    },
                    success: function(data) {
                        $('#product-list').html(data);
                        if (typeof Livewire !== "undefined") {
                            Livewire.rescan();
                        }
                        history.pushState(null, '', url);
                    },
                    complete: function() {
                        $('#product-list').removeClass('loading');
                        $('#ajax-loader').hide();
                    },
                    error: function(xhr) {
                        console.error("AJAX ERROR:", xhr.responseText);
                        alert('Failed to load products');
                    }
                });
            }

            // Events
            $(document).on('change', 'input[name="filter[]"]', function() {
                loadProducts();
            });

            $('#input-limit, #input-sort').on('change', function() {
                loadProducts();
            });

            $(document).on('click', '#product-list .pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                loadProducts(url);
            });

            window.onpopstate = function() {
                $.ajax({
                    url: location.href,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        $('#product-list').html(data);
                        if (typeof Livewire !== "undefined") {
                            Livewire.rescan();
                        }
                    }
                });
            };

        });
    </script>



    <script>
        jQuery(function($) {
            let slider = document.getElementById('rang-slider');

            let min = parseInt(slider.dataset.min);
            let max = parseInt(slider.dataset.max);
            let from = parseInt(slider.dataset.from);
            let to = parseInt(slider.dataset.to);

            let inputFrom = document.getElementById('range-from');
            let inputTo = document.getElementById('range-to');

            // Create slider
            noUiSlider.create(slider, {
                start: [slider.dataset.from, slider.dataset.to],
                connect: true,
                range: {
                    'min': parseInt(slider.dataset.min),
                    'max': parseInt(slider.dataset.max)
                }
            });

            slider.noUiSlider.on('update', function(values) {
                document.getElementById('range-from').value = Math.round(values[0]);
                document.getElementById('range-to').value = Math.round(values[1]);
            });

            // User types in FROM input
            inputFrom.addEventListener('change', function() {
                let valFrom = parseInt(this.value) || min;
                let valTo = parseInt(inputTo.value) || max;
                slider.noUiSlider.set([valFrom, valTo]);
                triggerAjax(valFrom, valTo);
            });

            // User types in TO input
            inputTo.addEventListener('change', function() {
                let valFrom = parseInt(inputFrom.value) || min;
                let valTo = parseInt(this.value) || max;
                slider.noUiSlider.set([valFrom, valTo]);
                triggerAjax(valFrom, valTo);
            });

            // When user stops sliding, trigger AJAX
            slider.noUiSlider.on('change', function(values) {
                triggerAjax(Math.round(values[0]), Math.round(values[1]));
            });

            // AJAX request (same as your sorting code)
            function triggerAjax(fromVal, toVal) {
                let params = new URLSearchParams(window.location.search);
                params.set('filter_price', `${fromVal}-${toVal}`);

                // Preserve limit & sort
                let limitVal = $('#input-limit').val();
                if (limitVal) params.set('limit', limitVal);

                let sortVal = $('#input-sort').val();
                if (sortVal) {
                    if (sortVal.endsWith('_desc')) {
                        params.set('sort', sortVal.replace('_desc', ''));
                        params.set('order', 'DESC');
                    } else {
                        params.set('sort', sortVal);
                        params.set('order', 'ASC');
                    }
                }

                let url = window.location.pathname + '?' + params.toString();

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function() {
                        $('#product-list').addClass('loading');
                        $('#ajax-loader').show();
                    },
                    success: function(data) {
                        $('#product-list').html(data);
                        Livewire.rescan();
                        history.pushState(null, '', url);
                    },
                    complete: function() {
                        $('#product-list').removeClass('loading');
                        $('#ajax-loader').hide();
                    },
                    error: function() {
                        alert('Failed to load products');
                    }
                });
            }
        });
    </script>

    <script>
        jQuery(function($) {
            $(document).on('click', '.filter-group .label', function() {
                $(this).closest('.filter-group').toggleClass('show');
            });
        });
    </script>
@endsection

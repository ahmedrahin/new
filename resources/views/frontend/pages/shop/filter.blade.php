
<div class="canvas-sidebar sidebar-filter canvas-filter left">
    <div class="canvas-wrapper">
        <div class="canvas-header d-xl-none">
            <span class="title h3 fw-medium">Filter</span>
            <span class="icon-close link icon-close-popup fs-24 close-filter"></span>
        </div>
        <div class="canvas-body">
            <div class="widget-facet">
                <div class="facet-title" data-bs-target="#category" role="button" data-bs-toggle="collapse"
                    aria-expanded="true" aria-controls="category">
                    <span class="h4 fw-semibold">Category</span>
                    <span class="icon icon-caret-down fs-20"></span>
                </div>
                <div id="category" class="collapse show">
                    <ul class="collapse-body filter-group-check group-category">
                        <li class="list-item">
                            <a href="shop-default.html" class="link h6">T-shirts<span class="count">23</span></a>
                        </li>
                        <li class="list-item">
                            <a href="shop-default.html" class="link h6">Footwear<span class="count">44</span></a>
                        </li>
                        <li class="list-item">
                            <a href="shop-default.html" class="link h6">Shirts<span class="count">75</span></a>
                        </li>
                        <li class="list-item">
                            <a href="shop-default.html" class="link h6">Dresses<span class="count">33</span></a>
                        </li>
                        <li class="list-item">
                            <a href="shop-default.html" class="link h6">Underwear<span class="count">45</span></a>
                        </li>
                        <li class="list-item">
                            <a href="shop-default.html" class="link h6">Accessories<span class="count">32</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="widget-facet">
                <div class="facet-title" data-bs-target="#price" role="button" data-bs-toggle="collapse" aria-expanded="true"
                    aria-controls="price">
                    <span class="h4 fw-semibold">Price</span>
                    <span class="icon icon-caret-down fs-20"></span>
                </div>
                <div id="price" class="collapse show">
                    <div class="collapse-body widget-price filter-price">
                        <div class="price-val-range" id="price-value-range" data-min="0" data-max="5000"></div>
                        <div class="box-value-price">
                            <span class="h6 text-main">Price:</span>
                            <div class="price-box">
                                <div class="price-val" id="price-min-value" data-currency="$"></div>
                                <span>-</span>
                                <div class="price-val" id="price-max-value" data-currency="$"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-facet">
                <div class="facet-title" data-bs-target="#brand" role="button" data-bs-toggle="collapse" aria-expanded="true"
                    aria-controls="brand">
                    <span class="h4 fw-semibold">Brand</span>
                    <span class="icon icon-caret-down fs-20"></span>
                </div>
                <div id="brand" class="collapse show">
                    <ul class="collapse-body filter-group-check current-scrollbar">
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="automet">
                            <label for="automet" class="label">AUTOMET</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="trendy-queen">
                            <label for="trendy-queen" class="label">Trendy Queen</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="wiholl">
                            <label for="wiholl" class="label">WIHOLL</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="real-essentials">
                            <label for="real-essentials" class="label">Real Essentials</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="dokotoo">
                            <label for="dokotoo" class="label">Dokotoo</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="hanes">
                            <label for="hanes" class="label">Hanes</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="zeagoo">
                            <label for="zeagoo" class="label">Zeagoo</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="shewin">
                            <label for="shewin" class="label">SHEWIN</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="blooming-jelly">
                            <label for="blooming-jelly" class="label">Blooming Jelly</label>
                        </li>
                        <li class="list-item">
                            <input type="checkbox" name="brand" class="tf-check" id="fisoew">
                            <label for="fisoew" class="label">Fisoew</label>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="canvas-bottom d-xl-none">
            <button id="reset-filter" class="tf-btn btn-reset">Reset Filters</button>
        </div>
    </div>
</div>

@push('scripts')

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

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function() {
                        $('#gridLayout').addClass('loading');
                        $('#ajax-loader').show();
                    },
                    success: function(data) {
                        $('#gridLayout').html(data);
                        if (typeof Livewire !== "undefined") {
                            Livewire.rescan();
                        }
                        history.pushState(null, '', url);
                    },
                    complete: function() {
                        $('#gridLayout').removeClass('loading');
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

            $(document).on('click', '#gridLayout .wg-pagination a', function(e) {
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
                        $('#gridLayout').html(data);
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
                        $('#gridLayout').addClass('loading');
                        $('#ajax-loader').show();
                    },
                    success: function(data) {
                        $('#gridLayout').html(data);
                        Livewire.rescan();
                        history.pushState(null, '', url);
                    },
                    complete: function() {
                        $('#gridLayout').removeClass('loading');
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
    
@endpush

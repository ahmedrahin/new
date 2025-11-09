<div class="tf-control-filter d-xl-none">
    <button type="button" id="filterShop" class="tf-btn-filter">
        <span class="icon icon-filter"></span><span class="text">Filter</span>
    </button>
</div>

<div class="meta-filter-shop active" style="">
    <div id="product-count-grid" class="count-text"><span class="count">{{ $products->total() }}</span> Products found</div>
    <div id="applied-filters"><span class="filter-tag remove-tag"><span class="icon icon-close"></span>Price: $0 -
            $458</span></div>
    <button id="remove-all" class="remove-all-filters" style="">
        <i class="icon icon-close"></i>
        Clear all</button>
</div>


@push('scripts')
<script>
    jQuery(function($) {
        // Build query params - Moved to top level
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

            // Add price filter if present
            let from = $('#range-from').val();
            let to = $('#range-to').val();
            let min = $('#rang-slider').data('min');
            let max = $('#rang-slider').data('max');
            
            // Only add price filter if it's not the default range
            if (from != min || to != max) {
                params.set('filter_price', `${from}-${to}`);
            }

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
                    
                    // Update filter tags after successful load
                    updateFilterTags();
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

        // Update filter tags
        function updateFilterTags() {
            let url = window.location.pathname + '?' + getFilters();
            
            // Just update the URL in history, the tags will be updated on next page load
            history.replaceState(null, '', url);
            
            // For a more dynamic update, you could make a separate endpoint
            // that returns just the filter tags HTML, but for simplicity
            // we'll rely on the full page reload behavior
        }

        // Remove individual filter tag
        $(document).on('click', '.filter-tag', function(e) {
            e.preventDefault();
            
            const $tag = $(this);
            const filterType = $tag.data('type');
            const filterValue = $tag.data('value');
            
            switch(filterType) {
                case 'price':
                    // Reset price range
                    resetPriceFilter();
                    break;
                    
                case 'brand':
                case 'filter':
                    // Uncheck the corresponding checkbox
                    $(`input[name="filter[]"][value="${filterValue}"]`).prop('checked', false);
                    break;
            }
            
            // Trigger product reload
            loadProducts();
        });
        
        // Remove all filters
        $(document).on('click', '#remove-all', function(e) {
            e.preventDefault();
            resetAllFilters();
            loadProducts();
        });
        
        // Reset price filter
        function resetPriceFilter() {
            const slider = document.getElementById('rang-slider');
            const min = parseInt(slider.dataset.min);
            const max = parseInt(slider.dataset.max);
            
            if (slider.noUiSlider) {
                slider.noUiSlider.set([min, max]);
            }
            
            $('#range-from').val(min);
            $('#range-to').val(max);
            
            if ($('#price-min-value').length) {
                $('#price-min-value').text(min);
            }
            if ($('#price-max-value').length) {
                $('#price-max-value').text(max);
            }
        }
        
        // Reset all filters
        function resetAllFilters() {
            // Uncheck all filter checkboxes
            $('input[name="filter[]"]').prop('checked', false);
            
            // Reset price filter
            resetPriceFilter();
            
            // Reset sort and limit if needed
            if ($('#input-sort').length) {
                $('#input-sort').val('');
            }
            if ($('#input-limit').length) {
                $('#input-limit').val('{{ config('website_settings.product_per_page', 12) }}');
            }
        }

        // Events for existing filters
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

        // Range slider code (keep your existing range slider code)
        let slider = document.getElementById('rang-slider');
        if (slider) {
            let min = parseInt(slider.dataset.min);
            let max = parseInt(slider.dataset.max);
            let from = parseInt(slider.dataset.from);
            let to = parseInt(slider.dataset.to);

            let inputFrom = document.getElementById('range-from');
            let inputTo = document.getElementById('range-to');

            let skipValues = [
                document.getElementById("price-min-value"),
                document.getElementById("price-max-value")
            ];

            if (!slider.noUiSlider) {
                noUiSlider.create(slider, {
                    start: [from, to],
                    connect: true,
                    step: 1,
                    range: {
                        min: min,
                        max: max
                    }
                });
            }

            slider.noUiSlider.on('update', function(values) {
                let val0 = Math.round(values[0]);
                let val1 = Math.round(values[1]);

                if (skipValues[0]) skipValues[0].innerText = val0;
                if (skipValues[1]) skipValues[1].innerText = val1;

                if (inputFrom) inputFrom.value = val0;
                if (inputTo) inputTo.value = val1;
            });

            // When user stops sliding, trigger AJAX
            slider.noUiSlider.on('change', function(values) {
                loadProducts();
            });
        }

        $(document).on('click', '.filter-group .label', function() {
            $(this).closest('.filter-group').toggleClass('show');
        });
    });
</script>
@endpush
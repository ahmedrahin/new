<a id="scroll-top" class="scroll-top" href="#top" title="Top" role="button"> <i class="w-icon-angle-up"></i> <svg
        version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
        <circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35" cy="35"
            r="34" style="stroke-dasharray: 16.4198, 400;"></circle>
    </svg> </a>

<!-- Start of Newsletter popup -->
<div class="newsletter-popup mfp-hide">
    <div class="newsletter-content">
        <h4 class="text-uppercase font-weight-normal ls-25">Get Up to<span class="text-primary">25% Off</span></h4>
        <h2 class="ls-25">Sign up to Wolmart</h2>
        <p class="text-light ls-10">Subscribe to the Wolmart market newsletter to
            receive updates on special offers.</p>
        <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
            <input type="email" class="form-control email font-size-md" name="email" id="email2"
                placeholder="Your email address" required="">
            <button class="btn btn-dark" type="submit">SUBMIT</button>
        </form>
        <div class="form-checkbox d-flex align-items-center">
            <input type="checkbox" class="custom-checkbox" id="hide-newsletter-popup" name="hide-newsletter-popup"
                required="">
            <label for="hide-newsletter-popup" class="font-size-sm text-light">Don't show this popup again.</label>
        </div>
    </div>
</div>
<!-- End of Newsletter popup -->


<!-- Start of Mobile Menu -->
<div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay"></div>
    <!-- End of .mobile-menu-overlay -->

    <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
    <!-- End of .mobile-menu-close -->

    <div class="mobile-menu-container scrollable">
        <form action="{{ url('/shop') }}" method="get" class="input-wrapper">
            <input type="text" class="form-control" name="query" autocomplete="off" placeholder="Search" required />
            <button class="btn btn-search" type="submit">
                <i class="w-icon-search"></i>
            </button>
        </form>
        <!-- End of Search Form -->
        <div class="tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#main-menu" class="nav-link active">Main Menu</a>
                </li>
                <li class="nav-item">
                    <a href="#categories" class="nav-link">Categories</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="main-menu">
                <ul class="mobile-menu">
                    <li><a href="{{ url('/') }}" {{ request()->is('/') ? 'active' : '' }}>Home</a></li>
                    <li>
                        <a href="{{ route('shop') }}" class="{{ request()->is('shop*') ? 'active' : '' }}">Shop</a>
                    </li>
                    <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                        <a href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
            </div>
            <div class="tab-pane" id="categories">
                <ul class="mobile-menu">
                    @foreach( App\Models\Category::with('subcategories')->OrderBy('name', 'asc')->where('status',1)->latest()->get() as $category)
                        <li>
                            <a href="{{ url('/shop') }}?categories[0]={{ $category->id }}">
                                <i class="w-icon-{{ Str::lower($category->name) }}"></i>{{ $category->name }}
                            </a>
                            @if($category->subcategories->count() > 0)
                                <ul class="mobile-submenu">
                                     @foreach($category->subcategories as $subcategory)
                                        <li>
                                            <a href="{{ url('/shop') }}?subcategories[0]={{ $subcategory->id }}" style="{{ $loop->last ? 'padding-bottom: 15px !important' : '' }}">{{ $subcategory->name }}</a>
                                            @if($subcategory->subsubcategories->count() > 0)
                                                @foreach($subcategory->subsubcategories as $subsubcategory)
                                                    <ul>
                                                        <li><a href="{{ url('/shop') }}?subsubcategories[0]={{ $subsubcategory->id }}">{{ $subsubcategory->name }}</a></li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End of Mobile Menu -->



<!-- Start of Sticky Footer -->
<div class="sticky-footer sticky-content fix-bottom">
    <a href="{{ url('/') }}" class="sticky-link active">
        <i class="w-icon-home"></i>
        <p>Home</p>
    </a>
    <a href="{{ route('shop') }}" class="sticky-link">
        <i class="w-icon-category"></i>
        <p>Shop</p>
    </a>
    <a href="{{ auth()->check() ? route('user.dashboard') : route('user.login') }}" class="sticky-link">
        <i class="w-icon-account"></i>
        <p>Account</p>
    </a>
    <div class="cart-dropdown dir-up">
        <a href="{{ route('cart') }}" class="sticky-link">
            <i class="w-icon-cart"></i>
            <p>Cart</p>
        </a>
    </div>

    <div class="header-search hs-toggle dir-up">
        <a href="{{ route('contact') }}" class="search-toggle sticky-link">
            <i class="w-icon-call"></i>
            <p>Contact</p>
        </a>
    </div>
</div>
<!-- End of Sticky Footer -->
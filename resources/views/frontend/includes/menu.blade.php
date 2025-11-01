<header id="header">
    <div class="top">
        <div class="container">
            <div class="ht-item logo">
                <div class="mbl-nav-top h-desk">
                    <div id="nav-toggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <a class="brand" href="{{ url('/') }}"><img src="{{ asset(config('app.logo')) }}"
                        title="Sr Laptop " width="144" height="164" alt=" "></a>
                <div class="mbl-right h-desk">
                    <div class="ac search-toggler"><i class="material-icons">search</i></div>
                    <div class="ac mc-toggler" style="margin-right: 4px;">
                        <i class="material-icons">shopping_basket</i>
                        <livewire:frontend.cart.btn-cart />
                    </div>
                </div>
            </div>

            <livewire:frontend.shop.search-box />

            <div class="ht-item q-actions">

                {{-- <div class="ac h-desk">
                    <div class="ic">
                        <a href="{{ url('/') }}">
                            <i class="material-icons" title="Home">home</i>
                        </a>
                    </div>
                    <div class="ac-content">
                        <h5 class="text">Home</h5>
                    </div>
                </div> --}}

                <a href="{{ route('wishlist') }}" class="ac h-desk">
                    <div class="ic"><i class="material-icons">favorite_border</i></div>
                    <div class="ac-content">
                        <livewire:frontend.wishlist.count-wishlist />
                    </div>
                </a>
                
                <div class="ac cmpr-toggler h-desk">
                    <div class="ic"><i class="material-icons">library_add</i></div>
                    <div class="ac-content">
                        <livewire:frontend.compare.compare-count />
                    </div>
                </div>

                <a href="{{ route('offers') }}" class="ac h-offer-icon">
                    <div class="ic"><i class="material-icons">card_giftcard</i></div>
                    <div class="ac-content">
                        <h5>Offers</h5>
                        <p>Latest Offers</p>
                    </div>
                </a>

                <a href="{{ route('pc.builder') }}" class="ac h-desk build-pc">
                    <div class="ic"><i class="material-icons">important_devices</i></div>
                    <div class="ac-content">
                        <h5 class="text">PC Builder</h5>
                    </div>
                </a>

                @if (!auth()->check())
                    <div class="ac">
                        <a class="ic" href="{{ route('user.login') }}"><i class="material-icons">person</i></a>
                        <div class="ac-content">
                            <a href="{{ route('user.login') }}">
                                <h5>Account</h5>
                            </a>
                            <p><a href="{{ route('register') }}">Register</a> or <a
                                    href="{{ route('user.login') }}">Login</a></span></p>
                        </div>
                    </div>
                @else
                    @php
                        $route =
                            Auth::user()->isAdmin == 1
                                ? route('admin-management.admin-list.show', auth()->user()->id)
                                : route('user.dashboard');
                    @endphp
                    <div class="ac">
                        <a class="ic" href="{{ $route }}"><i class="material-icons">person</i></a>
                        <div class="ac-content">
                            <a href="{{ $route }}">
                                <h5>Account</h5>
                            </a>
                            <p>
                                <a href="{{ $route }}">Profile</a> or
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></span>
                            </p>
                        </div>
                    </div>
                @endif

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <div class="ac build-pc" style="margin-left: 50px;">
                    <a class="btn" href="{{ route('pc.builder') }}">PC Builder</a>
                </div>

            </div>
        </div>
    </div>

    @include('frontend.includes.menu-category')

</header>


<div class="f-btn mc-toggler" id="cart">
    <i class="material-icons">shopping_basket</i>
    <div class="label">Cart</div>
    <livewire:frontend.cart.btn-cart />
</div>

<a href="{{ route('wishlist') }}" class="f-btn mc-wishlist" style="bottom: 164px;">
    <i class="material-icons">favorite_border</i>
    <div class="label">Wishlist</div>
    <livewire:frontend.wishlist.count-wishlist />
</a>

<livewire:frontend.compare.compare-box />

<livewire:frontend.cart.shopping-cart />

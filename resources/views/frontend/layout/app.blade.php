
<!DOCTYPE html>
<html lang="en">


<head>
    @include('frontend.includes.header')
    @include('frontend.includes.css')
    @livewireStyles
</head>

<body class="common-home">
    {{-- cart btn --}}
    @if( !request()->routeIs('cart') && !request()->routeIs('checkout') )
        {{-- <livewire:frontend.cart.btnshopping /> --}}
    @endif

    <div class="">
         @include('frontend.includes.menu')

        <!-- body content -->
        @yield('body-content')

        @include('frontend.includes.footer')
        @include('frontend.includes.cart-sidebar')
    </div>

    @include('frontend.includes.script')

    @livewireScripts
</body>

</html>

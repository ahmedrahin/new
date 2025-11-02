<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.includes.header')
    @include('frontend.includes.css')
    @livewireStyles
</head>

<body>
    @include('frontend.includes.menu')

    <!-- body content -->
    @yield('body-content')

    @include('frontend.includes.footer')
    @include('frontend.includes.cart-sidebar')


    @include('frontend.includes.script')

    @livewireScripts
</body>

</html>

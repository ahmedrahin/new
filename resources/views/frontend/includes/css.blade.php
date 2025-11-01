<link href="{{ asset('frontend/style/home.min.12.css') }}" type="text/css" rel="stylesheet" media="screen" />
<link rel="stylesheet" href="{{ asset('frontend/style/custom.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</noscript>

<script>
function loadMaterialIcons() {
    if (!document.querySelector('link[href*="Material+Icons"][rel="stylesheet"]')) {
        let link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
        document.head.appendChild(link);
    }
}

// Run on initial load
loadMaterialIcons();

// Run on Livewire DOM updates
document.addEventListener('livewire:load', () => {
    Livewire.hook('message.processed', () => {
        loadMaterialIcons();
    });
});
</script>


  <link rel="stylesheet" type="text/css" href="{{asset('frontend/style/toastify.css')}}"/>
  {{-- <link rel="stylesheet" type="text/css" id="rtl-link" href="{{asset('frontend/style/bootstrap.css')}}"/> --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
@yield('page-css')

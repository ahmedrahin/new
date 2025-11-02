<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>
{{-- <script src="{{ asset('frontend/js/carousel.js') }}"></script> --}}
<script src="{{ asset('frontend/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/lazysize.min.js') }}"></script>
<script src="{{ asset('frontend/js/wow.min.js') }}"></script>
<script src="{{ asset('frontend/js/infinityslide.js') }}"></script>
<script src="{{ asset('frontend/js/parallaxie.js') }}"></script>
<script src="{{ asset('frontend/js/count-down.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
{{-- <script src="{{ asset('frontend/js/sibforms.js') }}" defer></script> --}}


{{-- messages --}}
{{-- @if (session('success') || session('error') || session('info') || session('warning'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let message =
                "{{ session('success') ?? (session('error') ?? (session('info') ?? session('warning'))) }}";
            let type =
                "{{ session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning')) }}";

            let iconHtml = "";
            switch (type) {
                case "success":
                    iconHtml = '<i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 18px;"></i>';
                    break;
                case "error":
                    iconHtml = '<i class="bi bi-x-circle-fill" style="color: #e74c3c; font-size: 18px;"></i>';
                    break;
                case "info":
                    iconHtml = '<i class="bi bi-info-circle-fill" style="color: #3498db; font-size: 18px;"></i>';
                    break;
                case "warning":
                    iconHtml =
                        '<i class="bi bi-exclamation-circle-fill" style="color: #f39c12; font-size: 18px;"></i>';
                    break;
                default:
                    iconHtml = "";
            }

            Toastify({
                text: `<span>
                     <span style="margin-right: 6px; font-size: 18px;">${iconHtml}</span>
                     <span>${message}</span>
                    </span>`,
                duration: 3000,
                gravity: "bottom",
                position: "center",
                close: true,
                escapeMarkup: false,
                style: {
                    background: "#fff",
                    color: "#000",
                    boxShadow: "0px 4px 10px rgba(0,0,0,0.1)",
                    borderRadius: "8px",
                    padding: "10px 15px",
                    fontSize: "16px",
                    fontWeight: '600',
                    border: "2px solid #ddd",
                    marginBottom: "5px",
                    bottom: "100px",
                    marginBottom: "30px",
                }
            }).showToast();
        });
    </script>
@endif

<script>
    document.addEventListener('livewire:load', () => {
        Livewire.on('success', (message) => showToast(message, "success"));
        Livewire.on('info', (message) => showToast(message, "info"));
        Livewire.on('warning', (message) => showToast(message, "warning"));
        Livewire.on('error', (message) => showToast(message, "error"));
    });

    function showToast(message, type = "default") {
        let iconHtml = "";
        let borderColor = "#ddd";

        // Icons for different message types
        switch (type) {
            case "success":
                iconHtml = '<i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 18px;"></i>';
                break;
            case "error":
                iconHtml = '<i class="bi bi-x-circle-fill" style="color: #e74c3c; font-size: 18px;"></i>';
                break;
            case "info":
                iconHtml = '<i class="bi bi-info-circle-fill" style="color: #3498db; font-size: 18px;"></i>';
                break;
            case "warning":
                iconHtml = '<i class="bi bi-exclamation-circle-fill" style="color: #f39c12; font-size: 18px;"></i>';
                break;
            default:
                iconHtml = "";
        }

        Toastify({
            text: `<span>
                    <span style="margin-right: 6px; font-size: 18px;">${iconHtml}</span>
                    <span>${message}</span>
                   </span>`,
            duration: 3000,
            gravity: "bottom",
            position: "center",
            close: true,
            escapeMarkup: false,
            style: {
                background: "#fff",
                color: "#000",
                boxShadow: "0px 4px 10px rgba(0,0,0,0.1)",
                borderRadius: "8px",
                padding: "10px 15px",
                fontSize: "16px",
                fontWeight: '600',
                border: `2px solid ${borderColor}`,
                marginBottom: "5px",
                bottom: "100px",
            }
        }).showToast();
    }

    function error(message) {
        showToast(message, "error");
    }
</script>

<script>
    function message(type, message) {
        let iconHtml = "";
        switch (type) {
            case "success":
                iconHtml = '<i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 18px;"></i>';
                break;
            case "error":
                iconHtml = '<i class="bi bi-x-circle-fill" style="color: #e74c3c; font-size: 18px;"></i>';
                break;
            case "info":
                iconHtml = '<i class="bi bi-info-circle-fill" style="color: #3498db; font-size: 18px;"></i>';
                break;
            case "warning":
                iconHtml = '<i class="bi bi-exclamation-circle-fill" style="color: #f39c12; font-size: 18px;"></i>';
                break;
            default:
                iconHtml = "";
        }

        Toastify({
            text: `<span>
                     <span style="margin-right: 6px; font-size: 18px;">${iconHtml}</span>
                     <span>${message}</span>
                    </span>`,
            duration: 3000,
            gravity: "bottom",
            position: "center",
            close: true,
            escapeMarkup: false,
            style: {
                background: "#fff",
                color: "#000",
                boxShadow: "0px 4px 10px rgba(0,0,0,0.1)",
                borderRadius: "8px",
                padding: "10px 15px",
                fontSize: "16px",
                fontWeight: '600',
                border: "2px solid #ddd",
                marginBottom: "5px",
                bottom: "100px",
                marginBottom: "30px",
            }
        }).showToast();
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBox = document.getElementById('search');
        const input = searchBox.querySelector('input[type="text"]');

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('searchDropdown');
            if (dropdown && !searchBox.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Show dropdown on input focus (if it has value)
        input.addEventListener('focus', function() {
            const dropdown = document.getElementById('searchDropdown');
            if (dropdown && input.value.trim() !== '') {
                dropdown.style.display = 'block';
            }
        });

        // Show/hide dropdown on typing
        input.addEventListener('input', function() {
            const dropdown = document.getElementById('searchDropdown');
            if (!dropdown) return;

            if (input.value.trim() !== '') {
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        });
    });
</script> --}}

@yield('page-script')
@yield('addcart-js')
@stack('scripts')

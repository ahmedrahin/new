<footer>
    <div class="container">
        <div class="main-footer">

            {{-- Contact / Support --}}
            <div class="footer-block contact-us">
                @if (config('app.footer_logo'))
                    <a href="{{ url('/') }}" class="logo-footer">
                        <img src="{{ asset(config('app.footer_logo')) }}" class="footer-logo" style="max-width:150px;display:block;margin-bottom:30px;" />
                    </a>
                @endif
                <h4>Support</h4>

                <a href="tel:{{ config('app.phone') }}" class="helpline-btn footer-big-btn">
                    <div class="ic"><i class="material-icons">phone</i></div>
                    <p>9 AM - 8 PM </p>
                    <h5>{{ config('app.phone') }}</h5>
                </a>


            </div>

            <div class="footer-block about-us">
                <h4>Information</h4>
                <ul>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    <li><a href="{{ route('refund.policy') }}">Refund & Return Policy</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>

            {{-- Organization Info / Stay Connected --}}
            <div class="footer-block org-info">
                <h4>Stay Connected</h4>
                <p><b class="store-name">{{ config('app.name') }}</b><br />
                    {{ config('app.address') }}</p>
                <p><b>Email:</b><br /><a href="mailto:{{ config('app.email') }}">{{ config('app.email') }}</a></p>
                <div class="social-links" style="text-align: left;">
                    @if (!empty(config('app.whatsapp')))
                        <a href="{{ config('app.whatsapp') }}" target="_blank" rel="noopener" title="Whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif

                    @if (!empty(config('app.facebook')))
                        <a href="{{ config('app.facebook') }}" target="_blank" rel="noopener" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif

                    @if (!empty(config('app.youtube')))
                        <a href="{{ config('app.youtube') }}" target="_blank" rel="noopener" title="Youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif

                    @if (!empty(config('app.instra')))
                        <a href="{{ config('app.instra') }}" target="_blank" rel="noopener" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif

                </div>
            </div>


        </div>


        {{-- Sub-footer --}}
        <div class="row sub-footer">
            <div class="col-md-6 copyright-info">
                <p>© {{ date('Y') }} {{ config('app.name') }} | All rights reserved</p>
            </div>
            <div class="col-md-6 powered-by">
                <p>Powered By: {{ config('app.name') }}</p>
            </div>
        </div>
    </div>
</footer>
<div class="overlay"></div>

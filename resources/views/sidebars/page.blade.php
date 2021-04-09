<div class="sb-title">
    <h1>{{ _('Customer Service') }}</h1>
    <small>{{ _('Do you need help?') }}</small>
</div>
<div class="sb-desc">
    <ul class="menu-page list-unstyled">
        <li @if(Route::currentRouteName() == 'faqs') class="active" @endif><a href="{{ route('faqs') }}">{{ _('FAQs') }}</a></li>
        <li @if(Route::currentRouteName()  == 'contact') class="active" @endif><a href="{{  route('contact') }}">{{ _('Contact') }}</a></li>
        <li @if(Request::is('terms-of-use')) class="active" @endif><a href="{{ route('postType','terms-of-use') }}">{{ _('Terms Of Use') }}</a></li>
        <li @if(Request::is('privacy-policy')) class="active" @endif><a href="{{ route('postType','privacy-policy') }}">{{ _('Privacy Policy') }}</a></li>
    </ul>
</div>
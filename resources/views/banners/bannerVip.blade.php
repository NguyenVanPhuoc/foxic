@if (Auth::check())
    @php $bannerVip = getBannerBuyPackageVip();@endphp
    <section id="vip-banner">
        <div class="container">
            <figure class="image"><a href="{{ route('vipPackages') }}">{!! imageAuto($bannerVip, 'Toomics') !!}</a></figure>
        </div>
    </section>
@endif

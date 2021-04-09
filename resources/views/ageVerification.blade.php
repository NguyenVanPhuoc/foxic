@extends('templates.master')
@section('title', $page->title)
	@if($seo)
		@section('description', $seo->value)
		@section('keywords', $seo->key)
	@endif
@section('content')
    <div id="ageVerification-page" class="pages">
        <section class="page-content" style="background-image:url('{{ getImgUrl($bgOut) }}')">
            <div class="container" style="background-image:url('{{ getImgUrl($bgIn) }}')">
                <div class="sec-title">
                    <h3>{{ $page->title }}</h3>
                </div>
                <div class="sec-content flex flex-col item-start content-start">
                    <div class="text">
                        {!! $page->content !!}
                    </div>
                    <div class="group-btn">
                        {{ csrf_field() }}
                        <input type="hidden" name="check_age" value="{{ route('checkAgeVerification') }}">
                        <input type="hidden" name="comic" value="{{ (isset($_GET['comic']) && $_GET['comic'] != '') ? $_GET['comic'] : '' }}">
                        <button class="btn btn-no" data-value="no">{{ _('No') }}</button>
                        <button class="btn btn-yes" data-value="yes">{{ _('Yes') }}</button>
                    </div>
                </div>
            </div>
       </section>
    </div>
@endsection
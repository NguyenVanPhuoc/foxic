@extends('templates.master')
@section('title','Deactivate Account')
@section('content')
	<div id="deactivate-account" class="static-pages profile-pages">
		<div class="container">
			<div class="wrap clearfix">
				<div id="content" class="col-md-9">
					<div class="sec-title">
						@include('members.profile_header')
                        <h1>{{ _('Deactivate Account') }}</h1>
                        <small>{{ _('Thank you for using Toomics!') }}<br>{{ _('We would be very grateful if you can provide us your reason for leaving, so that we can strive to improve and offer a better service.') }}</small>
					</div>
					<div class="sec-content">
						<form id="form-deactiaveAccount" action="{{ route('postDeactivateAccount') }}" method="post" name="deactiaveAccount" class="dev-form">
							{{ csrf_field() }}
							<table class="table table-condensed">
								<tbody>
									<tr id="frm-reason" class="frm-inline">
										<th>{{ _('Category') }}</th>
										<td>
                                            <select name="reason" id="reason" class="form-control" title="Please select your reason">
                                                <option value="">{{ _('Please Select') }}</option>
                                                <option value="1">{{ _('I found a similar service.') }}</option>
                                                <option value="2">{{ ("I'm dissatisfied with the content.") }}</option>
                                                <option value="3">{{ _("I'm too addicted to the content!") }}</option>
                                                <option value="4">{{ _('There are too many technical issues!') }}</option>
                                                <option value="5">{{ _("I'm not using the service anymore.") }}</option>
                                                <option value="6">{{ _("I'm worried about my privacy.") }}</option>
                                                <option value="7">{{ _('Other') }}</option>
                                            </select>
                                        </td>
									</tr>
									<tr id="frm-message">
										<th>{{ _('Comment') }}</th>
                                        <td><textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Toomics would like to hear your thoughts." title="Comment"></textarea></td>
									</tr>
                                </tbody>
                            </table>
                            <div id="frm-submit" class="form-group text-center">
                                <button type="submit" name="submit" class="btn btn-red-rounded">{{ _('Deactivate') }}<i class="fal fa-angle-right"></i></button>
                            </div>
						</form>
					</div>
				</div>
				<div id="sidebar" class="col-md-3">@include('sidebars.member')</div>
			</div>
		</div>
    </div>
    @if(session('success'))
        <script type="text/javascript">
            $(document ).ready(function(){
                new PNotify({
                    title: 'Thành công',
                    text: '{{ session("success") }}',
                    type: 'success',
                    hide: true,
                    delay: 2000,
                });
            })
        </script>
    @endif
    @if(session('error'))
        <script type="text/javascript">
            $(document ).ready(function(){
                new PNotify({
                    title: 'Lỗi',
                    text: '{{ session("error") }}}',
                    type: 'error',
                    hide: true,
                    delay: 2000,
                });
            })
        </script>
    @endif
    @if(count($errors)>0)
        <div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @section('script')
            <script type="text/javascript">
                $(document ).ready(function(){
                    new PNotify({
                        title: 'Lỗi',
                        text: $('.alert-danger').html(),
                        type: 'error',
                        hide: true,
                        delay: 2000,
                    });
                })
            </script>
        @endsection
    @endif
@endsection
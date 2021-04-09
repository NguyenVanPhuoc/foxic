@if(!Auth::user())
    <div id="notify-op" class="modal single login-op" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ _('Sign up') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('loginCurrent') }}" name="login" method="POST">
                        {{ csrf_field() }}
                        <div id="frm-email" class="form-group"><input type="email" placeholder="Email" name="email" class="form-control"/></div>
                        <div id="frm-pass" class="form-group"><input type="password" placeholder="Password" name="password" class="form-control"></div>
                        <div class="modal-footer group-action">
                            <button type="submit" class="btn btn-primary">{{ _('Sign up') }}</button>
                        </div>
                    </form>
                    <ul class="login-social">
                        <li><a href="#" class="fbook"><i class="fab fa-facebook-square"></i>Facebook</a></li>
                        <li><a href="#" class="google"><i class="fab fa-google-plus-square"></i>Google+</a></li>
                    </ul>
                    <p class="regis-txt">{{ _('Do not have an account?') }} <a href="{{ route('register') }}">{{ _('Register now') }}</a></p>
                </div>
            </div>
        </div>
    </div>
@endif
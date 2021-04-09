<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="key" content="@yield('key')">    
    <meta name="author" content="Vietsmiler">
    <title>Admin - @yield('title')</title>
    <link rel="shortcut icon" href="{{ favicon() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
     @yield('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/select2.min.css') }}"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/checkbox_radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/pnotify.custom.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/sticker.css') }}">
    
    <script type="text/javascript" src="{{ asset('public/js/jquery.min.js') }}"></script>
    @yield('js')
    <script type="text/javascript" src="{{ asset('public/js/select2.full.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/js/dropzone.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('public/admin/js/sortable.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('public/js/validator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/validator.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jquery.scrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/cleave.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/sortable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/pnotify.custom.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/js/form-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/js/sticker.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.7/jquery.jscroll.js"></script>
    <!--flatpickr-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
    <script type="text/javascript" src="{{ asset('public/js/flatpickr.js') }}"></script>
    <!--//flatpickr-->
    @handheld
        <link rel="stylesheet" href="{{ asset('public/admin/css/responsive.css') }}">
        <script type="text/javascript" src="{{ asset('public/admin/js/responsive.js') }}"></script>
    @endhandheld
    <script>
        function ckeditor(name){
            CKEDITOR.replace(name, {
                filebrowserBrowseUrl: "{{ asset('public/admin/ckfinder/ckfinder.html') }}",
                filebrowserImageBrowseUrl: "{{ asset('public/admin/ckfinder/ckfinder.html') }}",
                filebrowserFlashBrowseUrl: "{{ asset('public/admin/ckfinder/ckfinder.html?type=Flash') }}",
                filebrowserUploadUrl: "{{ asset('public/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
                filebrowserImageUploadUrl: "{{ asset('public/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}",
                filebrowserFlashUploadUrl: "{{ asset('public/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}"
            } );
        }
        //preview image
        function filePreview(input, id){
            if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#'+id+' .image img').attr('src',e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function(){
            $(".img-upload .image input").change(function(){
                var id = $(this).parents(".img-upload").attr("id");
                $(this).parents(".img-upload").find(".thumb-media").val("");
                filePreview(this, id);
            });
        })
    </script>
</head>
<body>
    <div id="wrapper">
        <div id="sidebar">
            <h1 id="logo"><a href="{{ route('home') }}">{!! getLogo() !!}</a><a href="{{ route('home') }}" target="_blank" class="front-end"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></h1>
            <div id="menu-scroll" class="scrollbar-inner">
                <nav id="menu" role="navigation">
                    <ul>
                        <li class="has-children{{ Request::is('admin/roles','admin/roles/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-cogs" aria-hidden="true"></i>{{ __('Roles') }}</a>
                            <ul class="sub-menu">
                                    <li {{ (Route::currentRouteName() == 'rolesAdmin') ? ' class=active' : '' }}><a href="{{ route('rolesAdmin') }}">{{ __('Tất cả') }}</a></li>
                                    <li {{ (Route::currentRouteName() == 'createRolesAdmin') ? ' class=active' : '' }}><a href="{{ route('createRolesAdmin') }}">{{ __('Thêm mới') }}</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/pages','admin/pages/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-home" aria-hidden="true"></i>{{ __('Trang') }}</a>
                            <ul class="sub-menu">
                                <li {{ (Route::currentRouteName() == 'pagesAdmin') ? ' class=active' : '' }}><a href="{{ route('pagesAdmin') }}">{{ __('Tất cả') }}</a></li>
                                <li {{ (Route::currentRouteName() == 'createPageAdmin') ? ' class=active' : '' }}><a href="{{ route('createPageAdmin') }}">{{ __('Thêm mới') }}</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin', 'admin/comics','admin/comics/*', 'admin/categories-comic','admin/categories-comic/*', 'admin/types-comic','admin/types-comic/*', 'admin/writers','admin/writers/*', 'admin/artists','admin/artists/*')? ' active': '' }}">
                             <a href="#"><i class="fal fa-book-open"></i>{{ __('Truyện') }}</a>
                             <ul class="sub-menu">
                                 <li {{ (Route::currentRouteName() == 'comicsAdmin') ? ' class=active' : '' }}><a href="{{ route('comicsAdmin') }}">{{ __('Tất cả') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'createComicAdmin') ? ' class=active' : '' }}><a href="{{ route('createComicAdmin') }}">{{ __('Thêm mới') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'catComicsAdmin') ? ' class=active' : '' }}><a href="{{ route('catComicsAdmin') }}">{{ __('Danh mục truyện') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'typeComicsAdmin') ? ' class=active' : '' }}><a href="{{ route('typeComicsAdmin') }}">{{ __('Thể loại truyện') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'writersAdmin')? ' class=active' : '' }}><a href="{{ route('writersAdmin') }}">{{ __('Tác giả') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'artistsAdmin')? ' class=active' : '' }}><a href="{{ route('artistsAdmin') }}">{{ __('Họa sĩ') }}</a></li>
                             </ul>
                        </li>
                        {{-- <li class="has-children{{ Request::is('admin/articles','admin/articles/*', 'admin/categories','admin/categories/*')? ' active': '' }}">
                             <a href="#"><i class="far fa-newspaper"></i>{{ __('Tin tức - Review') }}</a>
                             <ul class="sub-menu">
                                 <li {{ (Route::currentRouteName() == 'articlesAdmin') ? ' class=active' : '' }}><a href="{{ route('articlesAdmin') }}">{{ __('Tất cả') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'createArticleAdmin') ? ' class=active' : '' }}><a href="{{ route('createArticleAdmin') }}">{{ __('Thêm mới') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'categoriesAdmin') ? ' class=active' : '' }}><a href="{{ route('categoriesAdmin') }}">{{ __('Danh mục') }}</a></li>                                
                             </ul>
                        </li> --}}
                        <li class="has-children{{ Request::is('admin/notices','admin/notices/*')? ' active': '' }}">
                             <a href="#"><i class="far fa-bell"></i>{{ __('Thông báo') }}</a>
                             <ul class="sub-menu">
                                 <li {{ (Route::currentRouteName() == 'noticesAdmin') ? ' class=active' : '' }}><a href="{{ route('noticesAdmin') }}">{{ __('Tất cả') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'createNoticeAdmin') ? ' class=active' : '' }}><a href="{{ route('createNoticeAdmin') }}">{{ __('Thêm mới') }}</a></li>                                
                             </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/statistical','admin/statistical/*')? ' active': '' }}">
                             <a href="{{ route('statisticalAdmin') }}"><i class="fas fa-chart-bar"></i>{{ __('Thống kê') }}</a>
                        </li>
                        <li class="has-children{{ Request::is('admin/withdrawals','admin/withdrawals/*')? ' active': '' }}">
                             <a href="#"><i class="fas fa-chart-bar"></i>{{ __('Yêu cầu rút tiền') }}</a>
                            <ul class="sub-menu">
                                <li {{ (Route::currentRouteName() == 'withdrawalsAdmin') ? ' class=active' : '' }}><a href="{{ route('withdrawalsAdmin') }}">{{ __('Tất cả') }}</a></li>
                                <li {{ (Route::currentRouteName() == 'createWithdrawalAdmin') ? ' class=active' : '' }}><a href="{{ route('createWithdrawalAdmin') }}">{{ __('Thêm mới') }}</a></li>                             
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/change-votes','admin/change-votes/*')? ' active': '' }}">
                             <a href="#"><i class="fas fa-vote-yea"></i>{{ __('Đổi phiếu') }}</a>
                             <ul class="sub-menu">
                                 <li {{ (Route::currentRouteName() == 'votesAdmin') ? ' class=active' : '' }}><a href="{{ route('votesAdmin') }}">{{ __('Tất cả') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'createVoteAdmin') ? ' class=active' : '' }}><a href="{{ route('createVoteAdmin') }}">{{ __('Thêm mới') }}</a></li>
                                                               
                             </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/payments','admin/payments/*', 'admin/categories-payment','admin/categories-payment/*')? ' active': '' }}">
                             <a href="#"><i class="fas fa-money-bill-alt"></i>{{ __('Thanh toán') }}</a>
                             <ul class="sub-menu">
                                 <li {{ (Route::currentRouteName() == 'paymentsAdmin') ? ' class=active' : '' }}><a href="{{ route('paymentsAdmin') }}">{{ __('Tất cả') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'createPaymentAdmin') ? ' class=active' : '' }}><a href="{{ route('createPaymentAdmin') }}">{{ __('Thêm mới') }}</a></li>
                                 <li {{ (Route::currentRouteName() == 'catPaymentsAdmin') ? ' class=active' : '' }}><a href="{{ route('catPaymentsAdmin') }}">{{ __('Loại thanh toán') }}</a></li>                                
                             </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/media','admin/media/*','admin/media-cat','admin/media-cat/*')? ' active': '' }}">
                            <a href="#"><i class="fal fa-images"></i>{{ __('Ảnh') }}</a>
                            <ul class="sub-menu">
                                <li {{ (Route::currentRouteName() == 'media') ? ' class=active' : '' }}><a href="{{ route('media') }}">{{ __('Tất cả') }}</a></li>
                                <li {{ (Route::currentRouteName() == 'createMedia') ? ' class=active' : '' }}><a href="{{ route('createMedia') }}">{{ __('Thêm mới') }}</a></li>
                                <li {{ (Route::currentRouteName() == 'mediaCat') ? ' class=active' : '' }}><a href="{{ route('mediaCat') }}">{{ __('Danh mục ảnh') }}</a></li>
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/stickers','admin/stickers/*','admin/sticker-cates','admin/sticker-cates/*')? ' active': '' }}">
                            <a href="#"><i class="fal fa-images"></i>{{ __('Stickers') }}</a>
                            <ul class="sub-menu">
                                <li {{ in_array(Route::currentRouteName(),['admin.stickers', 'admin.sticker_create', 'admin.sticker_edit']) ? ' class=active' : '' }}><a href="{{ route('admin.stickers') }}">{{ __('Tất cả') }}</a></li>
                                <li {{ in_array(Route::currentRouteName(), ['admin.sticker_cates', 'admin.sticker_cate_create', 'admin.sticker_cate_edit']) ? ' class=active' : '' }}><a href="{{ route('admin.sticker_cates') }}">{{ __('Sticker Packages') }}</a></li>
                            </ul>
                        </li>
                        @hasrole('BQT')
                        <li class="has-children{{ Request::is('admin/users','admin/users/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-users" aria-hidden="true"></i>{{ __('Thành viên') }}</a>
                            <ul class="sub-menu">
                                <li {{ (Route::currentRouteName() == 'users') ? ' class=active' : '' }}><a href="{{ route('users') }}">{{ __('Tất cả') }}</a></li>
                                <li {{ (Route::currentRouteName() == 'createAdmin') ? ' class=active' : '' }}><a href="{{ route('createAdmin') }}">{{ __('Thêm mới') }}</a></li>
                            </ul>
                        </li>
                        @else
                            <li class="has-children{{ Request::is('admin/users','admin/users/*')? ' active': '' }}">
                                <a href="{{ route('user') }}"><i class="fa fa-users" aria-hidden="true"></i>{{ __('User') }}</a> 
                            </li>
                        @endhasrole
                        <li class="has-children{{ Request::is('admin/group-meta','admin/group-meta/*')? ' active': '' }}">
                            <a href="{{ route('metas') }}"><i class="fa fa-th-large"></i>Meta field</a>
                            <ul class="sub-menu">
                                <li {{ (Route::currentRouteName() == 'metas') ? ' class=active' : '' }}><a href="{{ route('metas') }}">{{ __('Tất cả') }}</a></li>
                                <li {{ (Route::currentRouteName() == 'createMeta') ? ' class=active' : '' }}><a href="{{ route('createMeta') }}">{{ __('Thêm mới') }}</a></li>
                            </ul>
                        </li>                        
                        <li class="has-children{{ Request::is('admin/setting','admin/setting/*','admin/menu','admin/menu/*')? ' active': '' }}">
                            <a href="#"><i class="fa fa-cog"></i>Cài đặt</a>
                            <ul class="sub-menu">
                                <li {{ Request::is('admin/menu','admin/menu/*') ? ' class=active' : '' }}><a href="{{ route('menu') }}">Menu</a></li>
                                <li {{ Request::is('admin/setting/option') ? ' class=active' : '' }}><a href="{{ route('setting') }}">Hệ thống</a></li>                                
                            </ul>
                        </li>
                        <li class="has-children{{ Request::is('admin/slide','admin/slide/*','admin/menu','admin/menu/*')? ' active': '' }}">
                            <a href="{{route('slidesAdmin')}}" class="nav-link{{ Request::is('admin/slide','admin/slide/*')? ' active': '' }}">
                              <i class="nav-icon fas fa-sliders-h"></i>
                              <p>{{__('Slide')}}<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="sub-menu">
                              <li {{ Request::is('admin/slide','admin/slide/*') ? ' class=active' : '' }}>
                                <a href="{{route('slidesAdmin')}}" class="nav-link{{ Request::is('admin/slide')? ' active': '' }}">
                                  <p>{{__('Tất cả')}}</p>
                                </a>
                              </li>
                              <li class="nav-item">
                                <a href="{{route('storeSlideAdmin')}}" class="nav-link{{ Request::is('admin/slide/create')? ' active': '' }}">
                                  <p>{{__('Thêm mới')}}</p>
                                </a>
                              </li> 
                            </ul>
                        </li>
                    </ul>
                </nav>  
            </div>
        </div>
        <div id="content">
            <header>@include('backend.layout.header')</header>
            <main>
                @yield('content')
            </main>
            <footer>{!! copyright() !!}</footer>
        </div>
    </div>
    <div id="overlay"></div>
    <div class="loading"><img src="{{ asset('/public/images/loading_red.gif') }}" alt="loading..."></div>
</body>
</html>
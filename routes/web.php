<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 

// Password reset link request routes...
Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');
Route::get('/tesss', function() {
    Artisan::call('optimize');
    return "optimize file removed";
});
// Route::get('/updateapp', function() {
//     system('composer dump-autoload');
//     echo 'dump-autoload complete';
// });
Route::get('/clear-config-cache', function() {
    Artisan::call('config:clear');
   	echo "Configuration cache file removed";
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Application cache flushed";
});
Route::get('/clear-route-cache', function() {
    Artisan::call('route:clear');
    return "Route cache file removed";
});

Route::get('ajax_regen_captcha', function(){
    return captcha_src();
});
//resize image
Route::get('image/{scr}/{w}/{h}', function($src, $w=100, $h=100){
	$caheimage = Image::cache(function($image) use ($src, $w, $h){ return $image->make('public/uploads/'.$src)->fit($w, $h);}, 10, true);
	$extention = explode(".", $src);
	return $caheimage->response($extention[1]);
});

Route::get('social/redirect/{social}', ['as' => 'login.social', 'uses' => 'SocialController@redirect']);
Route::get('social/callback/{social}', ['as' => 'callback.social', 'uses' => 'SocialController@callback']);
Route::get('social/delete-app/{social}', ['as' => 'delete-app.social', 'uses' => 'SocialController@deleteAppData']);

Route::get('/test', ['as' => 'test', 'uses' => 'ComicController@test']);
Route::get('403', ['as' => '403', 'uses' => 'ErrorController@forbiddenResponse']);
Route::get('404', ['as' => '404', 'uses' => 'ErrorController@notfound']);
Route::get('500', ['as' => '500', 'uses' => 'ErrorController@fatal']);
Route::get('chap-403', ['as' => 'chap403', 'uses' => 'ErrorController@chap403']);
Route::get('/', ['as'=>'home','uses'=>'PagesController@index']);
Route::get('cus-login',['as'=>'storeLoginCustomer','uses'=>'user\UserController@getLogin']);
Route::post('cus-login',['as'=>'postLoginCustomer','uses'=>'user\UserController@postLogin']);
Route::get('cus-register',['as'=>'storeRegisterCustomer','uses'=>'user\UserController@getRegister']);
Route::post('cus-register',['as'=>'postRegisterCustomer','uses'=>'user\UserController@postRegister']);
Route::get('p/{slug}', ['as'=>'page','uses'=>'PagesController@getPage']);
Route::get('ongoing',['as'=>'ongoing', 'uses'=>'PagesController@ongoing']);
Route::get('ranking',['as'=>'ranking', 'uses'=>'PagesController@ranking']);
Route::get('faqs', ['as'=>'faqs','uses'=>'PagesController@faqs']);
Route::get('contact', ['as'=>'contact','uses'=>'PagesController@contact']);
Route::post('contact', ['as'=>'updateContact','uses'=>'PagesController@updateContact']);
Route::post('load-type-hot',['as'=>'loadTypeHot','uses'=>'PagesController@loadTypeHot']);
Route::post('load-type-new',['as'=>'loadTypeNew','uses'=>'PagesController@loadTypeNew']);
Route::post('save-star-rate',['as'=>'saveStarRate','uses'=>'ComicController@saveStarRate']);
Route::get('tim-kiem',['as'=>'searchComic', 'uses'=>'ComicController@searchComic']);
Route::post('load-ajax-tim-kiem',['as'=>'searchAjaxComic', 'uses'=>'ComicController@searchAjaxComic']);
Route::post('save-setting-chap',['as'=>'saveSettingChap', 'uses'=>'ComicController@saveSettingChap']);
Route::get('login', ['as'=>'login','uses'=>'AuthController@login']);
Route::post('login', ['as'=>'postLogin','uses'=>'AuthController@postLogin']);
Route::get('logout', ['as'=>'logout','uses'=>'AuthController@logout']);
Route::get('register', ['as'=>'register','uses'=>'AuthController@register']);
Route::post('register', ['as'=>'postRegister','uses'=>'AuthController@postRegister']);
Route::get('forgot-password', ['as'=>'forgotPassword','uses'=>'AuthController@forgotPassword']);
Route::post('forgot-password', ['as'=>'postForgotPassword','uses'=>'AuthController@postForgotPassword']);
Route::get('retake-password', ['as'=>'retakePassword','uses'=>'AuthController@retakePassword']);
Route::post('retake-password', ['as'=>'postRetakePassword','uses'=>'AuthController@postRetakePassword']);
Route::group(['prefix'=>'danh-sach'], function(){
	Route::get('/truyen-moi-cap-nhat',['as'=>'comicNewChap','uses'=>'ComicController@comicNewChap']);
	Route::get('/{slug}',['as'=>'catChap','uses'=>'ComicController@comicCat']);
	Route::get('/{slug}/hoan-thanh',['as'=>'catChapFull','uses'=>'ComicController@comicCatFull']);
});
Route::group(['prefix'=>'the-loai'], function(){
	Route::get('/{slug}',['as'=>'typeChap','uses'=>'ComicController@comicType']);
	Route::get('/{slug}/hoan-thanh',['as'=>'typeChapFull','uses'=>'ComicController@comicTypeFull']);
});
Route::group(['prefix'=>'tac-gia'], function(){
	Route::get('/{slug}',['as'=>'comicWriter','uses'=>'ComicController@comicWriter']);
});
Route::group(['prefix'=>'article'], function(){
	Route::get('/{slug}',['as'=>'detailArticle','uses'=>'PagesController@detailArticle']);
	Route::get('/cat/{slug}',['as'=>'cateArticle','uses'=>'PagesController@cateArticle']);
});
Route::group(['prefix'=>'notices'], function(){
	Route::get('/',['as'=>'indexNotice','uses'=>'PagesController@indexNotice']);
	Route::get('/{slug}',['as'=>'detailNotice','uses'=>'PagesController@detailNotice']);
});
//Comment
Route::post('/load/{comic_id}',['as'=>'comment.load_more','uses'=>'CommentController@loadMore']);
Route::group(['prefix'=>'comment','middleware'=>'memberLogin'], function(){
	Route::post('/create/{comic_id}',['as'=>'comment.store','uses'=>'CommentController@store']);
	Route::post('/reply/{comment_id}',['as'=>'comment.reply','uses'=>'CommentController@reply']);
	Route::post('/edit/{comment_id}',['as'=>'comment.edit','uses'=>'CommentController@edit']);
	Route::post('/update/{comment_id}',['as'=>'comment.update','uses'=>'CommentController@update']);
	Route::post('/delete/{comment_id}',['as'=>'comment.delete','uses'=>'CommentController@delete']);
});

Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function(){
	Route::get('/',['as'=>'indexAdmin','uses'=>'ComicAdminController@index']);
	//Role
	Route::group(['prefix'=>'roles'],function(){
		Route::get('/',['as'=>'rolesAdmin','uses'=>'RolesAdminController@index'])->middleware('permission:roles.read');
		Route::get('/create',['as'=>'createRolesAdmin','uses'=>'RolesAdminController@create'])->middleware('permission:roles.create');
		Route::post('/create',['as'=>'storeRolesAdmin','uses'=>'RolesAdminController@store'])->middleware('permission:roles.create');
		Route::get('/edit/{id}',['as'=>'editRolesAdmin','uses'=>'RolesAdminController@edit'])->middleware('permission:roles.read');
		Route::post('/edit/{id}',['as'=>'updateRolesAdmin','uses'=>'RolesAdminController@update'])->middleware('permission:roles.update');
		Route::get('/delete/{id}',['as'=>'deleteRoleAdmin','uses'=>'RolesAdminController@delete'])->middleware('permission:roles.delete');
		Route::post('delete-all',['as'=>'deleteRolesAdmin','uses'=>'RolesAdminController@deleteAll'])->middleware('permission:roles.delete');
	});
	//pages
	Route::group(['prefix'=>'pages'],function(){
		Route::get('/',['as'=>'pagesAdmin','uses'=>'PageAdminController@index'])->middleware('permission:pages.read');
		Route::get('/create',['as'=>'createPageAdmin','uses'=>'PageAdminController@create'])->middleware('permission:pages.create');
		Route::post('/create',['as'=>'storePageAdmin','uses'=>'PageAdminController@store'])->middleware('permission:pages.create');
		Route::get('/edit/{id}',['as'=>'editPageAdmin','uses'=>'PageAdminController@edit'])->middleware('permission:pages.read');
		Route::post('/edit/{id}',['as'=>'updatePageAdmin','uses'=>'PageAdminController@update'])->middleware('permission:pages.update');
		Route::get('/delete/{id}',['as'=>'deletePageAdmin','uses'=>'PageAdminController@delete'])->middleware('permission:pages.delete');
		Route::post('delete-all',['as'=>'deletePagesAdmin','uses'=>'PageAdminController@deleteAll'])->middleware('permission:pages.delete');
	});
	//System
	Route::group(['prefix'=>'setting'],function(){
		Route::get('/option',['as'=>'setting','uses'=>'OptionsAdminController@index'])->middleware('permission:setting.system');		
		Route::post('/edit-system',['as'=>'editSytem','uses'=>'OptionsAdminController@updateSystem']);
		Route::post('/media',['as'=>'systemMedia','uses'=>'OptionsAdminController@media']);
	});	
	//menus
	Route::group(['prefix'=>'menu'],function(){
		Route::get('/',['as'=>'menu','uses'=>'MenuController@index'])->middleware('permission:setting.menu');
		Route::get('/create',['as'=>'storeMenu','uses'=>'MenuController@store']);
		Route::post('/create',['as'=>'creatMenu','uses'=>'MenuController@create']);
		Route::get('/edit/{id}',['as'=>'editMenu','uses'=>'MenuController@edit']);
		Route::post('/edit/{id}',['as'=>'updateMenu','uses'=>'MenuController@update']);
		Route::get('/sub/{id}',['as'=>'storeSubMenu','uses'=>'MenuController@storeSubMenu']);
		Route::post('/sub/{id}',['as'=>'createSubMenu','uses'=>'MenuController@createSubMenu']);
		Route::get('/delete/{id}',['as'=>'deleteMenu','uses'=>'MenuController@delete']);
		Route::post('/loadType',['as'=>'loadType','uses'=>'MenuController@loadType']);
		Route::post('/search',['as'=>'searchMenu','uses'=>'MenuController@search']);
	});
	//slides
	Route::group(['prefix'=>'slide'],function(){
        Route::get('/',['as'=>'slidesAdmin','uses'=>'SlideAdminController@index'])->middleware('permission:slide.read');
        Route::get('create',['as'=>'storeSlideAdmin','uses'=>'SlideAdminController@store'])->middleware('permission:slide.create');
        Route::post('create',['as'=>'createSlideAdmin','uses'=>'SlideAdminController@create'])->middleware('permission:slide.create');
        Route::get('edit/{id}',['as'=>'editSlideAdmin','uses'=>'SlideAdminController@edit'])->middleware('permission:slide.read');
        Route::post('edit/{id}',['as'=>'updateSlideAdmin','uses'=>'SlideAdminController@update'])->middleware('permission:slide.update');
        Route::post('slug/{id}',['as'=>'slugSlideAdmin','uses'=>'SlideAdminController@changeSlug'])->middleware('permission:slide.update');
        Route::post('delete/{id}',['as'=>'deleteSlideAdmin','uses'=>'SlideAdminController@delete'])->middleware('permission:slide.delete');
        Route::post('delete-choose',['as'=>'deleteChooseSlideAdmin','uses'=>'SlideAdminController@deleteChoose'])->middleware('permission:slide.delete');
	});	
	/*
	* Category
	*/
	Route::group(['prefix'=>'categories'],function() {
		Route::get('/',['as'=>'categoriesAdmin','uses'=>'CategoryAdminController@index']);
		Route::get('create',['as'=>'createCategoryAdmin','uses'=>'CategoryAdminController@create']);
		Route::post('create',['as'=>'storeCategoryAdmin','uses'=>'CategoryAdminController@store']);
		Route::get('edit/{id}',['as'=>'editCategoryAdmin','uses'=>'CategoryAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateCategoryAdmin','uses'=>'CategoryAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCategoryAdmin','uses'=>'CategoryAdminController@delete']);
		Route::post('delete-all',['as'=>'deleteAllCategoryAdmin','uses'=>'CategoryAdminController@deleteAll']);
	});
	/*
	* articles
	*/
	Route::group(['prefix'=>'articles'],function() {
		Route::get('/',['as'=>'articlesAdmin','uses'=>'ArticleAdminController@index'])->middleware('permission:articles.read');
		Route::get('create',['as'=>'createArticleAdmin','uses'=>'ArticleAdminController@create'])->middleware('permission:articles.create');
		Route::post('create',['as'=>'storeArticleAdmin','uses'=>'ArticleAdminController@store'])->middleware('permission:articles.create');
		Route::get('edit/{id}',['as'=>'editArticleAdmin','uses'=>'ArticleAdminController@edit'])->middleware('permission:articles.read');
		Route::post('edit/{id}',['as'=>'updateArticleAdmin','uses'=>'ArticleAdminController@update'])->middleware('permission:articles.update');
		Route::get('delete/{id}',['as'=>'deleteArticleAdmin','uses'=>'ArticleAdminController@delete'])->middleware('permission:articles.delete');
		Route::post('delete-all',['as'=>'deleteAllArticleAdmin','uses'=>'ArticleAdminController@deleteAll'])->middleware('permission:articles.delete');
	});

	/*
	* Category payment
	*/
	Route::group(['prefix'=>'categories-payment'],function() {
		Route::get('/',['as'=>'catPaymentsAdmin','uses'=>'CategoryPaymentAdminController@index'])->middleware('permission:payments.read');
		Route::get('create',['as'=>'createCatPaymentAdmin','uses'=>'CategoryPaymentAdminController@create']);
		Route::post('create',['as'=>'storeCatPaymentAdmin','uses'=>'CategoryPaymentAdminController@store']);
		Route::get('edit/{id}',['as'=>'editCatPaymentAdmin','uses'=>'CategoryPaymentAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateCatPaymentAdmin','uses'=>'CategoryPaymentAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteCatPaymentAdmin','uses'=>'CategoryPaymentAdminController@delete']);
		Route::post('delete-all',['as'=>'deleteAllCatPaymentAdmin','uses'=>'CategoryPaymentAdminController@deleteAll']);
	});
	/*
	* Payment
	*/
	Route::group(['prefix'=>'payments'],function() {
		Route::get('/',['as'=>'paymentsAdmin','uses'=>'PaymentAdminController@index'])->middleware('permission:payments.read');
		Route::get('create',['as'=>'createPaymentAdmin','uses'=>'PaymentAdminController@create'])->middleware('permission:payments.create');
		Route::post('create',['as'=>'storePaymentAdmin','uses'=>'PaymentAdminController@store'])->middleware('permission:payments.create');
		Route::get('edit/{id}',['as'=>'editPaymentAdmin','uses'=>'PaymentAdminController@edit'])->middleware('permission:payments.read');
		Route::post('edit/{id}',['as'=>'updatePaymentAdmin','uses'=>'PaymentAdminController@update'])->middleware('permission:payments.update');
		Route::get('delete/{id}',['as'=>'deletePaymentAdmin','uses'=>'PaymentAdminController@delete'])->middleware('permission:payments.delete');
		Route::post('delete-all',['as'=>'deleteAllPaymentAdmin','uses'=>'PaymentAdminController@deleteAll'])->middleware('permission:payments.delete');
	});

	/*
	* Notice
	*/
	Route::group(['prefix'=>'notices'],function() {
		Route::get('/',['as'=>'noticesAdmin','uses'=>'NoticeAdminController@index'])->middleware('permission:notices.read');
		Route::get('create',['as'=>'createNoticeAdmin','uses'=>'NoticeAdminController@create'])->middleware('permission:notices.create');
		Route::post('create',['as'=>'storeNoticeAdmin','uses'=>'NoticeAdminController@store'])->middleware('permission:notices.create');
		Route::get('edit/{id}',['as'=>'editNoticeAdmin','uses'=>'NoticeAdminController@edit'])->middleware('permission:notices.read');
		Route::post('edit/{id}',['as'=>'updateNoticeAdmin','uses'=>'NoticeAdminController@update'])->middleware('permission:notices.update');
		Route::get('delete/{id}',['as'=>'deleteNoticeAdmin','uses'=>'NoticeAdminController@delete'])->middleware('permission:notices.delete');
		Route::post('delete-all',['as'=>'deleteAllNoticeAdmin','uses'=>'NoticeAdminController@deleteAll'])->middleware('permission:notices.delete');
	});
	/*
	* Change Votes
	*/
	Route::group(['prefix'=>'change-votes'],function() {
		Route::get('/',['as'=>'votesAdmin','uses'=>'VoteAdminController@index'])->middleware('permission:votes.read');
		Route::get('create',['as'=>'createVoteAdmin','uses'=>'VoteAdminController@create'])->middleware('permission:votes.create');
		Route::post('create',['as'=>'storeVoteAdmin','uses'=>'VoteAdminController@store'])->middleware('permission:votes.create');
		Route::get('edit/{id}',['as'=>'editVoteAdmin','uses'=>'VoteAdminController@edit'])->middleware('permission:votes.read');
		Route::post('edit/{id}',['as'=>'updateVoteAdmin','uses'=>'VoteAdminController@update'])->middleware('permission:votes.update');
		Route::get('delete/{id}',['as'=>'deleteVoteAdmin','uses'=>'VoteAdminController@delete'])->middleware('permission:votes.delete');
		Route::post('delete-all',['as'=>'deleteAllVoteAdmin','uses'=>'VoteAdminController@deleteAll'])->middleware('permission:votes.delete');
	});
	
	/**
	 * Media
	 */
	Route::group(['prefix'=>'media'],function(){
		Route::get('/',['as'=>'media','uses'=>'MediaAdminController@index'])->middleware('permission:media.read');
		Route::get('create',['as'=>'createMedia', 'uses'=>'MediaAdminController@create'])->middleware('permission:media.create');
		Route::post('create',['as'=>'storeMedia', 'uses'=>'MediaAdminController@store']);
		Route::get('edit/{id}',['as'=>'editMedia', 'uses'=>'MediaAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateMedia', 'uses'=>'MediaAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteMedia','uses'=>'MediaAdminController@delete']);
		Route::post('delete-all',['as'=>'deleteAllMedia','uses'=>'MediaAdminController@deleteAll']);
		Route::post('load-by-cat',['as'=>'loadByCatMedia', 'uses'=>'MediaAdminController@loadByCat']);
		Route::post('load-more',['as'=>'loadMoreMedia', 'uses'=>'MediaAdminController@loadMore']);
	});
	Route::group(['prefix'=>'media-cat'],function(){
		Route::get('/',['as'=>'mediaCat','uses'=>'MediaCatAdminController@index'])->middleware('permission:media.read');
		Route::get('create',['as'=>'createMediaCat', 'uses'=>'MediaCatAdminController@create']);
		Route::post('create',['as'=>'storeMediaCat', 'uses'=>'MediaCatAdminController@store']);
		Route::get('edit/{id}',['as'=>'editMediaCat', 'uses'=>'MediaCatAdminController@edit']);
		Route::post('edit/{id}',['as'=>'updateMediaCat', 'uses'=>'MediaCatAdminController@update']);
		Route::get('delete/{id}',['as'=>'deleteMediaCat','uses'=>'MediaCatAdminController@delete']);
		Route::post('delete-all',['as'=>'deleteAllMediaCat','uses'=>'MediaCatAdminController@deleteAll']);
		Route::post('position',['as'=>'positionAllMediaCat','uses'=>'MediaCatAdminController@position']);
	});
	//delete media with ajax
	Route::post('delete-media',['as'=>'deleteMediaSingle','uses'=>'MediaAdminController@deleteMediaSingle']);
	Route::post('loadMedia',['as'=>'loadMedia','uses'=>'MediaAdminController@loadMedia']);		
	Route::post('load-more-page',['as'=>'loadMorePage','uses'=>'MediaAdminController@loadMorePage']);
	Route::post('filter-media',['as'=>'filterMedia','uses'=>'MediaAdminController@searchMedia']);
	Route::post('search-cat-media',['as'=>'searchCatMedia','uses'=>'MediaAdminController@loadMediaByCat']);
	//group metas
	Route::group(['prefix'=>'group-meta'],function(){
		Route::get('/',['as'=>'metas','uses'=>'GroupMetaController@index'])->middleware('permission:metas.read');
		Route::get('create',['as'=>'createMeta','uses'=>'GroupMetaController@create'])->middleware('permission:metas.create');
		Route::post('/create',['as'=>'storeMeta','uses'=>'GroupMetaController@store'])->middleware('permission:metas.create');
		Route::get('/edit/{id}',['as'=>'editMeta','uses'=>'GroupMetaController@edit'])->middleware('permission:metas.read');
		Route::post('/edit/{id}',['as'=>'updateMeta','uses'=>'GroupMetaController@update'])->middleware('permission:metas.update');
		Route::get('/delete/{id}',['as'=>'deleteGroupMeta','uses'=>'GroupMetaController@delete'])->middleware('permission:metas.update');
	});
	//users
	Route::group(['prefix'=>'users'],function(){
		Route::get('/',['as'=>'users','uses'=>'UserController@index'])->middleware('permission:users.read');
		Route::get('role/{level}',['as'=>'levelAdmin','uses'=>'UserController@getUserByLevel'])->middleware('permission:users.read');
		Route::get('create',['as'=>'createAdmin','uses'=>'UserController@create'])->middleware('permission:users.create');
		Route::post('create',['as'=>'storeAdmin','uses'=>'UserController@store'])->middleware('permission:users.create');
		Route::get('edit/{id}',['as'=>'editAdmin','uses'=>'UserController@edit'])->middleware('permission:users.read');
		Route::post('edit/{id}',['as'=>'updateAdmin','uses'=>'UserController@update'])->middleware('permission:users.update');
		Route::get('delete/{id}',['as'=>'deleteAdmin','uses'=>'UserController@delete'])->middleware('permission:users.delete');
		Route::post('delete-all',['as'=>'deleteUsersAdmin','uses'=>'UserController@deleteAll'])->middleware('permission:users.delete');
	});
	//users
	Route::group(['prefix'=>'user'],function(){
		Route::get('/',['as'=>'user','uses'=>'UserController@editUser']);
		Route::post('edit/{id}',['as'=>'updateUser','uses'=>'UserController@updateUser']);
	});
	/*
	* Category comic
	*/
	Route::group(['prefix'=>'categories-comic'],function() {
		Route::get('/',['as'=>'catComicsAdmin','uses'=>'CategoryComicAdminController@index'])->middleware('permission:cateComic.read');
		Route::get('create',['as'=>'createCatComicAdmin','uses'=>'CategoryComicAdminController@create'])->middleware('permission:cateComic.create');
		Route::post('create',['as'=>'storeCatComicAdmin','uses'=>'CategoryComicAdminController@store'])->middleware('permission:cateComic.create');
		Route::get('edit/{id}',['as'=>'editCatComicAdmin','uses'=>'CategoryComicAdminController@edit'])->middleware('permission:cateComic.read');
		Route::post('edit/{id}',['as'=>'updateCatComicAdmin','uses'=>'CategoryComicAdminController@update'])->middleware('permission:cateComic.update');
		Route::get('delete/{id}',['as'=>'deleteCatComicAdmin','uses'=>'CategoryComicAdminController@delete'])->middleware('permission:cateComic.delete');
		Route::post('delete-all',['as'=>'deleteAllCatComicAdmin','uses'=>'CategoryComicAdminController@deleteAll'])->middleware('permission:cateComic.deleteAll');
	});

	/*
	* Type comic
	*/
	Route::group(['prefix'=>'types-comic'],function() {
		Route::get('/',['as'=>'typeComicsAdmin','uses'=>'TypeComicAdminController@index'])->middleware('permission:typeComic.read');
		Route::get('create',['as'=>'createTypeComicAdmin','uses'=>'TypeComicAdminController@create'])->middleware('permission:typeComic.create');
		Route::post('create',['as'=>'storeTypeComicAdmin','uses'=>'TypeComicAdminController@store'])->middleware('permission:typeComic.create');
		Route::get('edit/{id}',['as'=>'editTypeComicAdmin','uses'=>'TypeComicAdminController@edit'])->middleware('permission:typeComic.read');
		Route::post('edit/{id}',['as'=>'updateTypeComicAdmin','uses'=>'TypeComicAdminController@update'])->middleware('permission:typeComic.update');
		Route::get('delete/{id}',['as'=>'deleteTypeComicAdmin','uses'=>'TypeComicAdminController@delete'])->middleware('permission:typeComic.delete');
		Route::post('position-type-comic',['as'=>'positionTypeComicAdmin','uses'=>'TypeComicAdminController@position']);
	});

	/*
	* Writer
	*/
	Route::group(['prefix'=>'writers'],function() {
		Route::get('/',['as'=>'writersAdmin','uses'=>'WriterAdminController@index'])->middleware('permission:writers.read');
		Route::get('/create',['as'=>'createWriterAdmin','uses'=>'WriterAdminController@create'])->middleware('permission:writers.create');
		Route::post('/create',['as'=>'storeWriterAdmin','uses'=>'WriterAdminController@store'])->middleware('permission:writers.create');
		Route::get('/edit/{id}',['as'=>'editWriterAdmin','uses'=>'WriterAdminController@edit'])->middleware('permission:writers.read');
		Route::post('/edit/{id}',['as'=>'updateWriterAdmin','uses'=>'WriterAdminController@update'])->middleware('permission:writers.update');
		Route::get('delete/{id}',['as'=>'deleteWriterAdmin','uses'=>'WriterAdminController@delete'])->middleware('permission:writers.delete');
		Route::post('delete-all',['as'=>'deleteAllWriterAdmin','uses'=>'WriterAdminController@deleteAll'])->middleware('permission:writers.delete');
	});
	/*
	* Artist
	*/
	Route::group(['prefix'=>'artists'],function() {
		Route::get('/',['as'=>'artistsAdmin','uses'=>'ArtistAdminController@index'])->middleware('permission:artists.read');
		Route::get('/create',['as'=>'createArtistAdmin','uses'=>'ArtistAdminController@create'])->middleware('permission:artists.create');
		Route::post('/create',['as'=>'storeArtistAdmin','uses'=>'ArtistAdminController@store'])->middleware('permission:artists.create');
		Route::get('/edit/{id}',['as'=>'editArtistAdmin','uses'=>'ArtistAdminController@edit'])->middleware('permission:artists.read');
		Route::post('/edit/{id}',['as'=>'updateArtistAdmin','uses'=>'ArtistAdminController@update'])->middleware('permission:artists.update');
		Route::get('delete/{id}',['as'=>'deleteArtistAdmin','uses'=>'ArtistAdminController@delete'])->middleware('permission:artists.delete');
		Route::post('delete-all',['as'=>'deleteAllArtistAdmin','uses'=>'ArtistAdminController@deleteAll'])->middleware('permission:artists.delete');
	});
	/*
	* Withdrawal request
	*/
	Route::group(['prefix'=>'withdrawals'],function() {
		Route::get('/',['as'=>'withdrawalsAdmin','uses'=>'WithdrawalAdminController@index'])->middleware('permission:withdrawals.read');
		Route::get('/create',['as'=>'createWithdrawalAdmin','uses'=>'WithdrawalAdminController@create'])->middleware('permission:withdrawals.create');
		Route::post('/create',['as'=>'storeWithdrawalAdmin','uses'=>'WithdrawalAdminController@store'])->middleware('permission:withdrawals.create');
		Route::get('/edit/{id}',['as'=>'editWithdrawalAdmin','uses'=>'WithdrawalAdminController@edit'])->middleware('permission:withdrawals.read');
		Route::post('/edit/{id}',['as'=>'updateWithdrawalAdmin','uses'=>'WithdrawalAdminController@update'])->middleware('permission:withdrawals.update');
		Route::get('delete/{id}',['as'=>'deleteWithdrawalAdmin','uses'=>'WithdrawalAdminController@delete'])->middleware('permission:withdrawals.delete');
		Route::post('delete-all',['as'=>'deleteAllWithdrawalAdmin','uses'=>'WithdrawalAdminController@deleteAll'])->middleware('permission:withdrawals.delete');
	});

	/*
	* Sticker categories
	*/
	Route::group(['prefix'=>'sticker-cates'],function() {
		Route::get('/',['as'=>'admin.sticker_cates','uses'=>'StickerCateAdminController@index'])->middleware('permission:sticker_cate.read');
		Route::get('/create',['as'=>'admin.sticker_cate_create','uses'=>'StickerCateAdminController@create'])->middleware('permission:sticker_cate.create');
		Route::post('/create',['as'=>'admin.sticker_cate_store','uses'=>'StickerCateAdminController@store'])->middleware('permission:sticker_cate.create');
		Route::get('/edit/{id}',['as'=>'admin.sticker_cate_edit','uses'=>'StickerCateAdminController@edit'])->middleware('permission:sticker_cate.read');
		Route::post('/edit/{id}',['as'=>'admin.sticker_cate_update','uses'=>'StickerCateAdminController@update'])->middleware('permission:sticker_cate.update');
		Route::get('delete/{id}',['as'=>'admin.sticker_cate_delete','uses'=>'StickerCateAdminController@delete'])->middleware('permission:sticker_cate.delete');
		Route::post('delete-all',['as'=>'admin.sticker_cate_delete_choose','uses'=>'StickerCateAdminController@deleteAll'])->middleware('permission:sticker_cate.delete');
	});

	Route::group(['prefix'=>'stickers'],function() {
		Route::get('/',['as'=>'admin.stickers','uses'=>'StickerAdminController@index'])->middleware('permission:sticker.read');
		Route::get('/create',['as'=>'admin.sticker_create','uses'=>'StickerAdminController@create'])->middleware('permission:sticker.create');
		Route::post('/create',['as'=>'admin.sticker_store','uses'=>'StickerAdminController@store'])->middleware('permission:sticker.create');
		Route::get('/edit/{id}',['as'=>'admin.sticker_edit','uses'=>'StickerAdminController@edit'])->middleware('permission:sticker.read');
		Route::post('/edit/{id}',['as'=>'admin.sticker_update','uses'=>'StickerAdminController@update'])->middleware('permission:sticker.update');
		Route::get('delete/{id}',['as'=>'admin.sticker_delete','uses'=>'StickerAdminController@delete'])->middleware('permission:sticker.delete');
		Route::post('delete-all',['as'=>'admin.sticker_delete_choose','uses'=>'StickerAdminController@deleteAll'])->middleware('permission:sticker.delete');
	});

	/*
	* Comic
	*/
	Route::group(['prefix'=>'comics'],function() {
		Route::get('/',['as'=>'comicsAdmin','uses'=>'ComicAdminController@index'])->middleware('permission:comics.read');
		Route::get('create',['as'=>'createComicAdmin','uses'=>'ComicAdminController@create'])->middleware('permission:comics.create');
		Route::post('create',['as'=>'storeComicAdmin','uses'=>'ComicAdminController@store'])->middleware('permission:comics.create');
		Route::get('edit/{id}',['as'=>'editComicAdmin','uses'=>'ComicAdminController@edit'])->middleware('permission:comics.read');
		Route::post('edit/{id}',['as'=>'updateComicAdmin','uses'=>'ComicAdminController@update'])->middleware('permission:comics.update');
		Route::get('delete/{id}',['as'=>'deleteComicAdmin','uses'=>'ComicAdminController@delete'])->middleware('permission:comics.delete');
		Route::post('delete-all',['as'=>'deleteAllComicAdmin','uses'=>'ComicAdminController@deleteAll'])->middleware('permission:comics.delete');
		Route::get('/create-permission/{permission}',['as'=>'createPermission','uses'=>'ComicAdminController@createPermission']);
		/*
		* Book (of comic)
		*/
		Route::group(['prefix'=>'books/{comic_id}'],function() {
			Route::get('/',['as'=>'booksAdmin','uses'=>'BookAdminController@index']);
			Route::get('create',['as'=>'createBookAdmin','uses'=>'BookAdminController@create']);
			Route::post('create',['as'=>'storeBookAdmin','uses'=>'BookAdminController@store']);
			Route::get('edit/{id}',['as'=>'editBookAdmin','uses'=>'BookAdminController@edit']);
			Route::post('edit/{id}',['as'=>'updateBookAdmin','uses'=>'BookAdminController@update']);
			Route::get('load-title',['as'=>'loadTitleBookAdmin','uses'=>'BookAdminController@loadTitle']);
			Route::post('postion',['as'=>'postionBookAdmin','uses'=>'BookAdminController@postion']);
			Route::get('delete/{id}',['as'=>'deleteBookAdmin','uses'=>'BookAdminController@delete']); //delete chap admin
			/*
			* Chap (of book)
			*/
			Route::group(['prefix'=>'chaps/{book_id}'],function() {
				Route::get('/',['as'=>'chapsAdmin','uses'=>'ChapAdminController@index']);
				Route::get('create',['as'=>'createChapAdmin','uses'=>'ChapAdminController@create']);
				Route::post('create',['as'=>'storeChapAdmin','uses'=>'ChapAdminController@store']);
				Route::get('edit/{id}',['as'=>'editChapAdmin','uses'=>'ChapAdminController@edit']);
				Route::post('edit/{id}',['as'=>'updateChapAdmin','uses'=>'ChapAdminController@update']);
				Route::get('load-title',['as'=>'loadTitleChapAdmin','uses'=>'ChapAdminController@loadTitle']);
				Route::post('postion',['as'=>'postionChapAdmin','uses'=>'ChapAdminController@postion']);
				Route::get('delete/{id}',['as'=>'deleteChapAdmin','uses'=>'ChapAdminController@delete']); //delete chap admin
			});
		});
	});

	/*
	* Comments
	*/
	Route::group(['prefix'=>'comments'],function() {
		Route::get('/',['as'=>'admin.comments','uses'=>'CommentAdminController@index'])->middleware('permission:comment.read');
		// Route::get('create',['as'=>'admin.comment_create','uses'=>'CommentAdminController@create']);
		// Route::post('create',['as'=>'admin.comment_store','uses'=>'CommentAdminController@store']);
		Route::get('edit/{id}',['as'=>'admin.comment_edit','uses'=>'CommentAdminController@edit'])->middleware('permission:comment.read');
		Route::post('edit/{id}',['as'=>'admin.comment_update','uses'=>'CommentAdminController@update'])->middleware('permission:comment.update');
		Route::get('delete/{id}',['as'=>'admin.comment_delete','uses'=>'CommentAdminController@delete'])->middleware('permission:comment.delete');
		Route::post('delete-all',['as'=>'admin.comments_delete_choose','uses'=>'CommentAdminController@deleteAll'])->middleware('permission:comment.delete');
	});

	/*
	* Thống kê
	*/
	Route::group(['prefix'=>'statistical'],function() {
		Route::get('/',['as'=>'statisticalAdmin','uses'=>'PageAdminController@statisticalAdmin'])->middleware('permission:statistic.read');
		Route::get('moved-point/{user_id}/{fromMonth}/{toMonth}',['as'=>'movedPointAdmin','uses'=>'PageAdminController@movedPointAdmin']);
	});
	/*
	* Media comic
	*/
	Route::post('load-media-comic',['as'=>'loadMediaComic','uses'=>'MediaComicAdminController@loadMedia']);
	Route::group(['prefix'=>'media-comics'],function() {
		Route::post('create',['as'=>'createMediaComic', 'uses'=>'MediaComicAdminController@create']);
	});

});
Route::group(['prefix'=>'tai-khoan','middleware'=>'memberLogin'],function(){
	Route::get('/',['as'=>'profile', 'uses'=>'AuthController@profile']);	
	Route::get('sua',['as'=>'editProfile', 'uses'=>'AuthController@editAccount']);
	Route::post('sua',['as'=>'updateProfile', 'uses'=>'AuthController@updateAccount']);
	Route::get('mat-khau',['as'=>'editPassword', 'uses'=>'AuthController@editPassword']);
	Route::post('mat-khau',['as'=>'updatePassword', 'uses'=>'AuthController@updatePassword']);
	Route::get('media',['as'=>'mediaProfile', 'uses'=>'MediaController@index']);
	Route::get('media/them',['as'=>'createMediaProfile', 'uses'=>'MediaController@create']);
	Route::post('media/them',['as'=>'storeMediaProfile', 'uses'=>'MediaController@store']);
	Route::get('media/sua/{id}',['as'=>'editMediaProfile', 'uses'=>'MediaController@edit']);
	Route::post('media/sua/{id}',['as'=>'updateMediaProfile', 'uses'=>'MediaController@update']);
	// Route::get('media/xoa/{id}',['as'=>'deleteMediaProfile', 'uses'=>'MediaController@delete']);
	// Route::post('media/xoa',['as'=>'deleteMediasProfile', 'uses'=>'MediaController@deleteAll']);
	// Route::post('delete-library',['as'=>'deleteLibraryProfile', 'uses'=>'MediaController@deleteMediaSingle']);
	Route::post('change-avatar',['as'=>'avatarProfile', 'uses'=>'MediaController@changeAvatar']);
	Route::post('load-more-media',['as'=>'loadMoreMediaProfile', 'uses'=>'MediaController@loadMoreMedia']);
	Route::post('filter-media',['as'=>'filterMediaProfile','uses'=>'MediaController@searchMedia']);	
	Route::get('coin/add',['as'=>'addCoin','uses'=>'AuthController@addCoin']);	
	Route::get('coin/history',['as'=>'historyCoin','uses'=>'AuthController@historyCoin']);	
	Route::get('poin/history',['as'=>'historyPoint','uses'=>'AuthController@historyPoint']);	
	Route::get('bookshelf/history',['as'=>'historyChap','uses'=>'AuthController@historyChap']);	
	Route::get('bookshelf/buy',['as'=>'buyChaps','uses'=>'AuthController@buyChaps']);	
	Route::get('bookshelf/rental',['as'=>'rentalChaps','uses'=>'AuthController@rentalChaps']);	
	Route::get('change-votes',['as'=>'changeVotes','uses'=>'AuthController@changeVotes']);	
	Route::post('changeVoteXu',['as'=>'changeVoteXu', 'uses'=>'AuthController@changeVoteXu']);
	Route::post('changeVotePoint',['as'=>'changeVotePoint', 'uses'=>'AuthController@changeVotePoint']);
});

Route::get('list-stickers',['as'=>'sticker.packages','uses'=>'StickerController@listPackages']);
Route::get('buy-stickers/{package_id}',['middleware'=>'memberLogin', 'as'=>'sticker.buy_package','uses'=>'StickerController@buyPackage']);

Route::group(['prefix'=>'{slugComic}'],function(){
	Route::get('/',['as'=>'listChap', 'uses'=>'ComicController@listChap']);
	Route::get('/{slugChap}',['as'=>'detailChap', 'uses'=>'ComicController@detailChap']);
});
Route::post('rent-chap',['as'=>'rentChap', 'uses'=>'ComicController@rentChap']);
Route::post('buy-chap',['as'=>'buyChap', 'uses'=>'ComicController@buyChap']);
Route::post('donate',['as'=>'donateAuthor', 'uses'=>'ComicController@donateAuthor']);
Route::post('localStorage',['as'=>'localStorage', 'uses'=>'ComicController@localStorage']);
Route::post('muster',['as'=>'musterUser', 'uses'=>'user\UserController@musterUser']);
Route::get('/{slug}', ['as'=>'postType','uses'=>'PagesController@type']);
Route::post('online-payment',['as'=>'onlinePayment', 'uses'=>'PagesController@onlinePayment']);

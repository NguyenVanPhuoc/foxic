<?php 
// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Truyện', route('home').'/');
});
// Home > page
Breadcrumbs::register('page', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($page->title,$page->slug);
});
// Home > contact
Breadcrumbs::register('contact', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($page->title,$page->slug);
});
//Home > blog
Breadcrumbs::register('blog', function ($breadcrumbs) {
    $breadcrumbs->parent('home');        
    $breadcrumbs->push('Tin tức');
});
// Home > category
Breadcrumbs::register('category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('home');    
    $breadcrumbs->push($category->title,$category->slug);    
});
// Home > category > blog detail
Breadcrumbs::register('blogDetail', function ($breadcrumbs,$category,$blogDetail) {
    $breadcrumbs->parent('home');    
    $breadcrumbs->push($category->title,$category->slug);  
    $breadcrumbs->push($blogDetail->title,$blogDetail->slug);
});
// Home > key
Breadcrumbs::register('search', function ($breadcrumbs, $s) {
    $breadcrumbs->parent('home');    
    $breadcrumbs->push($s);
});
//Category product
Breadcrumbs::register('categoryProduct', function ($breadcrumbs, $cat_title) {
    $breadcrumbs->parent('home');        
    $breadcrumbs->push('Sản phẩm',route('products','san-pham'));
    $breadcrumbs->push($cat_title);
});
//detail product
Breadcrumbs::register('product', function ($breadcrumbs, $pro) {
    $cat = getCatProduct($pro->cat_id);
    $breadcrumbs->parent('home');        
    $breadcrumbs->push('Sản phẩm');
    if($cat)
        $breadcrumbs->push($cat->title, route('categoryProducts', ['slug'=>$cat->slug]).'/');
    $breadcrumbs->push($pro->title);
});
//cart
Breadcrumbs::register('cart', function ($breadcrumbs) {
    $breadcrumbs->parent('home');        
    $breadcrumbs->push('Giỏ hàng');
});
//products
Breadcrumbs::register('products', function ($breadcrumbs) {
    $breadcrumbs->parent('home');        
    $breadcrumbs->push('Sản phẩm');
});
//cart
Breadcrumbs::register('pay', function ($breadcrumbs) {
    $breadcrumbs->parent('home');        
    $breadcrumbs->push('Thanh toán');
});

/*
* New breabcrumbs
*/
Breadcrumbs::register('catComic', function ($breadcrumbs, $cat_title) {
    $breadcrumbs->parent('home');        
    $breadcrumbs->push($cat_title);
});
// Chap breadcrumbs
Breadcrumbs::register('chapComic', function ($breadcrumbs, $comic, $chap_title) {
    $breadcrumbs->parent('home');       
    $breadcrumbs->push($comic->title,route('listChap',['slugComic'=>$comic->slug]).'/'); 
    $breadcrumbs->push($chap_title);
});
Breadcrumbs::register('catArticle', function ($breadcrumbs, $cat_title) {
    $breadcrumbs->parent('home');        
    $breadcrumbs->push($cat_title);
});
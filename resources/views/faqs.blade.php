@extends('templates.master')
@section('title',$page->title)
@section('content')
    <div id="faq-page" class="static-pages">
        <div class="container">
            <div class="wrap clearfix">
                <div id="content" class="col-md-9">
                    <div class="inner">
                        <div class="sec-title"><h3>{{ $page->title }}</h3></div>
                        <div class="sec-content">
                            <ul class="nav nav-pills flex item-centet content-between text-center">
                                <li class="active"><a data-toggle="pill" href="#service-problems">Service problems</a></li>
                                <li><a data-toggle="pill" href="#payment-refunds">Payment/refunds</a></li>
                                <li><a data-toggle="pill" href="#content">Content</a></li>
                                <li><a data-toggle="pill" href="#app-pc">APP/PC</a></li>
                                <li><a data-toggle="pill" href="#membership">Membership</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="service-problems" class="tab-pane fade in active">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#sv1">I can't reset my password! What do I do?</a>
                                                </h4>
                                            </div>
                                            <div id="sv1" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    One case of a password reset not working could be if a special character was used.<br>
                                                    <br> ! @ # $ % ^ &amp; * ( )<br>
                                                    <br> If any of the above special characters were used when changing or resetting a password, there is a high chance of the password not changing or getting reset.<br>
                                                    <br> We recommend checking or changing your password to the standards found on Toomics.<br>
                                                    <br> If this does not work, please contact us at the 1:1 Customer Service Center.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#sv2">Is Toomics a legal site?</a>
                                                </h4>
                                            </div>
                                            <div id="sv2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Yes, we are a legal site.<br>
                                                    <br> All of the content put up on our site is copyrighted and we have<br> been given permission to publish the work(s) by the artists.<br>
                                                    <br> All of the profits made on Toomics are shared with the artists with <br> whom we have direct contracts to publish the comic on our platform.<br>
                                                    <br> In other words, by using Toomics, you are thanking the artists and <br> allowing them to continue making great stories!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#sv3">Does my VIP work for other languages too?</a>
                                                </h4>
                                            </div>
                                            <div id="sv3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Our Toomics services for Korean, Chinese, Taiwanese, and English are all different.<br>
                                                    <br> The content we publish is the same, however, the services we provide are different.<br> Therefore, a VIP membership bought on the English Toomics site will not work on the other language sites.<br>
                                                    <br> If you wish to read Toomics' English comics, you must make the purchase on the English site.<br> If you wish to read Toomics' Chinese or Taiwanese comic, you must make the purchase on the respective sites.
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="payment-refunds" class="tab-pane fade">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#pr1">I do not have a credit card. How can I purchase a VIP Membership?</a>
                                                </h4>
                                            </div>
                                            <div id="pr1" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Please note that our VIP Memberships can only accept credit cards. However, if you do not have a credit card, other payment methods that we have available can be found on the VIP Payments page.<br> Please click on any VIP Membership and then click on
                                                    "Click here for another payment method" and that will take you to a page where we have other payment methods.<br>
                                                    <br> If the payment methods on our site are not suitable, we recommend that you try to purchase a VIP Membership through our English Toomics app that is available on the Google Play Store and the Apple App Store as they offer a wider variety of payment
                                                    methods than us currently.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#pr2">Is Toomics a legal site?</a>
                                                </h4>
                                            </div>
                                            <div id="pr2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Yes, we are a legal site.<br>
                                                    <br> All of the content put up on our site is copyrighted and we have<br> been given permission to publish the work(s) by the artists.<br>
                                                    <br> All of the profits made on Toomics are shared with the artists with <br> whom we have direct contracts to publish the comic on our platform.<br>
                                                    <br> In other words, by using Toomics, you are thanking the artists and <br> allowing them to continue making great stories!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#pr3">I want to get a refund.</a>
                                                </h4>
                                            </div>
                                            <div id="pr3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    In our Terms of Use, it is stated that if you do not use<br> a purchase within the 7 days of your payment, you may<br> request a refund.<br>
                                                    <br> If you have used your purchase within 7 days, a request for a refund<br> may be difficult.<br>
                                                    <br> You may, however always ask for your VIP Membership to be canceled.<br> With the cancelation of your VIP, you will still have access to our VIP content<br> for the remaining period that was already purchased.
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="content" class="tab-pane fade">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#ct1">I do not have a credit card. How can I purchase a VIP Membership? </a>
                                                </h4>
                                            </div>
                                            <div id="ct1" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Please note that our VIP Memberships can only accept credit cards. However, if you do not have a credit card, other payment methods that we have available can be found on the VIP Payments page.<br> Please click on any VIP Membership and then click on
                                                    "Click here for another payment method" and that will take you to a page where we have other payment methods.<br>
                                                    <br> If the payment methods on our site are not suitable, we recommend that you try to purchase a VIP Membership through our English Toomics app that is available on the Google Play Store and the Apple App Store as they offer a wider variety of payment
                                                    methods than us currently.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#pr2">Is Toomics a legal site?</a>
                                                </h4>
                                            </div>
                                            <div id="ct2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Yes, we are a legal site.<br>
                                                    <br> All of the content put up on our site is copyrighted and we have<br> been given permission to publish the work(s) by the artists.<br>
                                                    <br> All of the profits made on Toomics are shared with the artists with <br> whom we have direct contracts to publish the comic on our platform.<br>
                                                    <br> In other words, by using Toomics, you are thanking the artists and <br> allowing them to continue making great stories!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#ct3">I want to get a refund.</a>
                                                </h4>
                                            </div>
                                            <div id="ct3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    In our Terms of Use, it is stated that if you do not use<br> a purchase within the 7 days of your payment, you may<br> request a refund.<br>
                                                    <br> If you have used your purchase within 7 days, a request for a refund<br> may be difficult.<br>
                                                    <br> You may, however always ask for your VIP Membership to be canceled.<br> With the cancelation of your VIP, you will still have access to our VIP content<br> for the remaining period that was already purchased.
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="app-pc" class="tab-pane fade">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#ap1">I do not have a credit card. How can I purchase a VIP Membership? </a>
                                                </h4>
                                            </div>
                                            <div id="ap1" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Please note that our VIP Memberships can only accept credit cards. However, if you do not have a credit card, other payment methods that we have available can be found on the VIP Payments page.<br> Please click on any VIP Membership and then click on
                                                    "Click here for another payment method" and that will take you to a page where we have other payment methods.<br>
                                                    <br> If the payment methods on our site are not suitable, we recommend that you try to purchase a VIP Membership through our English Toomics app that is available on the Google Play Store and the Apple App Store as they offer a wider variety of payment
                                                    methods than us currently.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#ap2">Is Toomics a legal site?</a>
                                                </h4>
                                            </div>
                                            <div id="ap2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Yes, we are a legal site.<br>
                                                    <br> All of the content put up on our site is copyrighted and we have<br> been given permission to publish the work(s) by the artists.<br>
                                                    <br> All of the profits made on Toomics are shared with the artists with <br> whom we have direct contracts to publish the comic on our platform.<br>
                                                    <br> In other words, by using Toomics, you are thanking the artists and <br> allowing them to continue making great stories!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#ap3">I want to get a refund.</a>
                                                </h4>
                                            </div>
                                            <div id="ap3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    In our Terms of Use, it is stated that if you do not use<br> a purchase within the 7 days of your payment, you may<br> request a refund.<br>
                                                    <br> If you have used your purchase within 7 days, a request for a refund<br> may be difficult.<br>
                                                    <br> You may, however always ask for your VIP Membership to be canceled.<br> With the cancelation of your VIP, you will still have access to our VIP content<br> for the remaining period that was already purchased.
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div id="membership" class="tab-pane fade">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#mb1">I do not have a credit card. How can I purchase a VIP Membership? </a>
                                                </h4>
                                            </div>
                                            <div id="mb1" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Please note that our VIP Memberships can only accept credit cards. However, if you do not have a credit card, other payment methods that we have available can be found on the VIP Payments page.<br> Please click on any VIP Membership and then click on
                                                    "Click here for another payment method" and that will take you to a page where we have other payment methods.<br>
                                                    <br> If the payment methods on our site are not suitable, we recommend that you try to purchase a VIP Membership through our English Toomics app that is available on the Google Play Store and the Apple App Store as they offer a wider variety of payment
                                                    methods than us currently.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#mb2">Is Toomics a legal site?</a>
                                                </h4>
                                            </div>
                                            <div id="mb2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    Yes, we are a legal site.<br>
                                                    <br> All of the content put up on our site is copyrighted and we have<br> been given permission to publish the work(s) by the artists.<br>
                                                    <br> All of the profits made on Toomics are shared with the artists with <br> whom we have direct contracts to publish the comic on our platform.<br>
                                                    <br> In other words, by using Toomics, you are thanking the artists and <br> allowing them to continue making great stories!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#mb3">I want to get a refund.</a>
                                                </h4>
                                            </div>
                                            <div id="mb3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    In our Terms of Use, it is stated that if you do not use<br> a purchase within the 7 days of your payment, you may<br> request a refund.<br>
                                                    <br> If you have used your purchase within 7 days, a request for a refund<br> may be difficult.<br>
                                                    <br> You may, however always ask for your VIP Membership to be canceled.<br> With the cancelation of your VIP, you will still have access to our VIP content<br> for the remaining period that was already purchased.
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sidebar" class="col-md-3">@include('sidebars.page')</div>
            </div>
        </div>
    </div>
@endsection
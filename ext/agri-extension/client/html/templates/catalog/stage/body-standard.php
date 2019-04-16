<?php

$listTarget = $this->config( 'client/html/catalog/lists/url/target' );
$listController = $this->config( 'client/html/catalog/lists/url/controller', 'catalog' );
$listAction = $this->config( 'client/html/catalog/lists/url/action', 'list' );
$listConfig = $this->config( 'client/html/catalog/lists/url/config', [] );

$optTarget = $this->config( 'client/jsonapi/url/target' );
$optCntl = $this->config( 'client/jsonapi/url/controller', 'jsonapi' );
$optAction = $this->config( 'client/jsonapi/url/action', 'options' );
$optConfig = $this->config( 'client/jsonapi/url/config', [] );

$enc = $this->encoder();
$orderItems = $this->get( 'listsOrderItems', [] );
$accountTarget = $this->config( 'client/html/account/history/url/target' );

?>
<div class="mainmenu pull-left">
    <ul class="nav navbar-nav collapse navbar-collapse">
        <li><a href="/list" class="active">Marché</a></li>
        <li class="dropdown"><a href="#">Agriculture<i class="fa fa-angle-down"></i></a>
            <ul role="menu" class="sub-menu">
                <li><a href="shop.html">Products</a></li>
                <li><a href="product-details.html">Product Details</a></li>
                <li><a href="checkout.html">Checkout</a></li>
                <li><a href="/basket">Cart</a></li>
                <li><a href="/login">Login</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#">Elevage<i class="fa fa-angle-down"></i></a>
            <ul role="menu" class="sub-menu">
                <li><a href="blog.html"></a></li>
                <li><a href="blog-single.html">Blog Single</a></li>
            </ul>
        </li>
        <li><a href="404.html">
                A propos</a></li>
        <li><a href="contact-us.html">Contacts</a></li>
    </ul>
</div>

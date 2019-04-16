<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	@yield('aimeos_header')
    <title>Agri - business</title>
    <!--<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    !-->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
	@yield('aimeos_styles')
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +237 691 77 95 46</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> agri.business@nh-it.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-4 clearfix">
						<div class="logo pull-left">
							<a href="/"><img src="{{ asset('packages/aimeos/shop/themes/elegance/media/home/logo.jpg') }}" alt="" /></a>
						</div>

					</div>
					<div class="col-md-8 clearfix">
						<div class="shop-menu clearfix pull-right">
							<ul class="nav navbar-nav">
								<li><a href="/"><i class="fa fa-home"></i> Accueil</a></li>
								<li><a href=""><i class="fa fa-crosshairs"></i> Services</a></li>
								<li><a href="/basket"><i class="fa fa-truck"></i> Ma cargaison</a></li>
								<?php if(session('status')) :  ?>
                                <li><a href="/login"><i class="fa fa-lock"></i> Connexion </a></li>
                                <li><a href="/register"><i class="fa fa-user"></i> Inscription </a></li>

                                <?php else : ?>
                                <li><a href="/myaccount"><i class="fa fa-lock"></i> Mon Compte </a></li>
                            <?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

							@yield('aimeos_stage')

					</div>

						@yield('aimeos_nav')

				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
    @yield('aimeos_slide')
	<section >
        <div class="container">
            <div class="row">
           <div class="col-sm-3">
            @yield('aimeos_left_side')
           </div>
        @yield('aimeos_body')
	@yield('aimeos_aside')
	@yield('content')
        </div></div>
	</section>

	<footer id="footer"><!--Footer-->
		<div class="footer-top"></div >
		<div class="footer-widget"></div >
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2019 ITS Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.its.com">ITS</a></span></p>
				</div>
			</div>
		</div>

	</footer><!--/Footer-->




	@yield('aimeos_scripts')
</body>
</html>

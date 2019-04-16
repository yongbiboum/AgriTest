@extends('app')

@section('aimeos_styles')
	<link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/bootstrap.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/font-awesome.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/prettyPhoto.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/price-range.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/animate.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/main.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('packages/aimeos/shop/themes/elegance/responsive.css') }}" />

@stop

@section('aimeos_scripts')

    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/jquery.scrollUp.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/price-range.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/jquery.prettyPhoto.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/aimeos/shop/themes/main.js') }}"></script>
@stop

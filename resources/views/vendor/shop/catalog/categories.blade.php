@extends('shop::base')

@section('aimeos_header')

    <?= $aiheader['catalog/filter'] ?>
    <?= $aiheader['catalog/stage'] ?>

@stop


@section('aimeos_nav')
    <?= $aibody['catalog/filter'] ?>
@stop

@section('aimeos_stage')
    <?= $aibody['catalog/stage'] ?>
@stop
@section('aimeos_slide')
    <?= $aibody['catalog/slide'] ?>
@stop
@section('aimeos_left_side')
    <?= $aibody['catalog/categories'] ?>
@stop
@section('aimeos_body')
     <?= $aibody['catalog/catlist'] ?>
@stop

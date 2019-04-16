@extends('shop::base')



@section('aimeos_header')
    <?= $aiheader['catalog/stage'] ?>
    <?= $aiheader['catalog/detail'] ?>

@stop


@section('aimeos_stage')
    <?= $aibody['catalog/stage'] ?>
@stop
@section('aimeos_left_side')
    <?= $aibody['catalog/categories'] ?>
@stop
@section('aimeos_body')
    <?= $aibody['catalog/detail'] ?>
@stop



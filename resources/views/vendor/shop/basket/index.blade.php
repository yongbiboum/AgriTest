@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/standard'] ?>
    <?= $aiheader['basket/related'] ?>
@stop
@section('aimeos_stage')
    <?= $aibody['catalog/stage'] ?>
@stop
@section('aimeos_body')
    <?= $aibody['basket/standard'] ?>
    <?= $aibody['basket/related'] ?>
@stop

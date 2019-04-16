@extends('shop::base')

@section('aimeos_header')
    <?= $aiheader['basket/mini'] ?>

@stop

@section('aimeos_head')
    <?= $aibody['basket/mini'] ?>
@stop

@section('aimeos_body')
    <?= $aibody['account/profile'] ?>
    <?= $aibody['account/subscription'] ?>
    <?= $aibody['account/history'] ?>
    <?= $aibody['account/favorite'] ?>
    <?= $aibody['account/watch'] ?>
@stop

@section('aimeos_aside')
    <?= $aibody['catalog/session'] ?>
@stop

@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
    <section class="content-header">
        <h1>
            Scraps
            <small>Gaategory</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/show/228">Home</a></li>
            <li><a href="/scraps">Scraps</a></li>
            <li><a href="/modal">Homepage</a></li>
            <li class="active">Category</li>
        </ol>
    </section>

@endsection
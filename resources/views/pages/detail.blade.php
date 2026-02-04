@extends('layouts.detail')

@section('hero')
    @include('detail.hero2')
@endsection

@section('content')
    @include('detail.detail-content', ['project' => $project, 'mainImage' => $mainImage])
@endsection

@section('footer')
    @include('portfolio.modals')
    @include('detail.quotes')
    @include('portfolio.contacts')
@endsection
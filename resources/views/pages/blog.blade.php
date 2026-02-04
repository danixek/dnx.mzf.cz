@extends('layouts.blog')

@section('hero')
    @include('detail.blog-hero')
@endsection

@section('content')
    @include('detail.blog-content')
@endsection

@section('footer')
    @include('portfolio.modals')
    @include('detail.quotes')
    @include('portfolio.contacts')
@endsection
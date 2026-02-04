@extends('layouts.app')

@section('hero')
    @include('portfolio.hero')
@endsection

@section('content')
    @include('portfolio.about')
    @include('portfolio.portfolio')

@endsection

@section('footer')
    @include('portfolio.blog')
    @include('portfolio.contacts')
@endsection
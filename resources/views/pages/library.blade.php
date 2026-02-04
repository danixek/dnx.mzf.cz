@extends('layouts.detail')

@section('hero')
    @include('detail.hero2')
@endsection

@section('content')
    @include('detail.library-content')
@endsection

@section('footer')

    @include('detail.quotes')
    @include('portfolio.contacts')
@endsection
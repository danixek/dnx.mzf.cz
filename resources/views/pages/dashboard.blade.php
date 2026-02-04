@extends('layouts.dashboard')

@section('content')

@if($tab === 'rss')
    @include('dashboard.rss')

@elseif($tab === 'set')
    @include('dashboard.set')

@else
    @include('dashboard.dash')
@endif

@endsection

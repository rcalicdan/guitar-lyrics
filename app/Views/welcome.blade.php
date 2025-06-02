@extends('layouts.homepage')

@section('title', 'Home - Guitar Lyrics & Chords')

@section('content')
    @include('contents.homepage.hero-landing')
    
    @include('contents.homepage.hero')

    @include('contents.homepage.featured-songs')

    {{-- @include('contents.homepage.categories') --}}

    @include('contents.homepage.cta')
@endsection
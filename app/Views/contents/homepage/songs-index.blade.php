@extends('layouts.homepage')

@section('title', 'Browse Songs - Guitar Lyrics & Chords')

@push('styles')
@include('stacks.songs-styles')
@endpush

@section('content')
<div x-data="songsFilter()" x-init="init()">
    @include('partials.header')
    @include('songs-filter')
    @include('songs-grid')
</div>
@endsection

@push('scripts')
@include('stacks.songs-scripts')
@endpush
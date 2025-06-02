@extends('layouts.homepage')

@section('title', 'Browse Songs - Guitar Lyrics & Chords')

@push('styles')
@include('stacks.songs-styles')
@endpush

@section('content')
<div x-data="songsFilter()" x-init="init()">
    @include('partials.header')
    @include('contents.homepage.songs-filter')
    @include('contents.homepage.songs-grid')
</div>
@endsection

@push('scripts')
@include('stacks.songs-script')
@endpush
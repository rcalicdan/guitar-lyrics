@extends('layouts.homepage')

@section('title', $song->title . ' - ' . $song->artist_name . ' | Guitar Lyrics & Chords')

@push('styles')
@include('songs-show-styles')
@endpush

@section('content')
<div x-data="songShow()" x-init="init()">
    @include('contents.homepage.songs-show-header')
    @include('contents.homepage.songs-show-content')
    @include('contents.homepage.songs-show-actions')
</div>
@endsection

@push('scripts')
@include('songs-show-script')
@endpush
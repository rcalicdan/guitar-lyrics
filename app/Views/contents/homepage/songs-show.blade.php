@extends('layouts.homepage')

@section('title', $song->title . ' - ' . $song->artist_name . ' | Guitar Lyrics & Chords')

@push('styles')
@include('stacks.songs-show-styles')
@endpush

@section('content')
<div x-data="songShow({{ $song->id }}, '{{ $song->slug }}')" x-init="init()">
    @include('contents.homepage.songs-show-header')
    @include('contents.homepage.songs-show-content')
    @include('contents.homepage.songs-show-comments')
    @include('contents.homepage.songs-show-actions')
</div>
@endsection

@push('scripts')
@include('stacks.songs-show-script')
@include('stacks.songs-show-comment')
@endpush
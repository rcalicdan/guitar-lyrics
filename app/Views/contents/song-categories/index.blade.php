@extends('layouts.app')

@section('content-title', 'Song Categories')

@section('content')
    @if ($isCreating ?? false)
        @include('contents.song-categories.create')
    @elseif ($isEditing ?? false)
        @include('contents.song-categories.edit')
    @else
        @include('contents.song-categories.table')
    @endif
@endsection

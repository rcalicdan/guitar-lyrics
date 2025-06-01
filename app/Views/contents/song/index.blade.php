@extends('layouts.app')

@section('content-title', 'Song List')

@section('content')
    @if ($isCreating ?? false)
        @include('contents.song.create')
    @elseif ($isEditing ?? false)
        @include('contents.song.edit')
    @elseif($isShowing ?? false)
        @include('contents.song.show')
    @else
        @include('contents.song.table')
    @endif
@endsection

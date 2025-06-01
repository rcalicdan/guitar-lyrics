@extends('layouts.app')

@section('content-title', 'Artists')

@section('content')
    @if ($isCreating ?? false)
        @include('contents.artist.create')
    @elseif ($isEditing ?? false)
        @include('contents.artist.edit')
    @elseif ($isShowing ?? false)
        @include('contents.artist.show')
    @elseif($isShowing ?? false)
        @include('contents.artist.show')
    @else
        @include('contents.artist.table')
    @endif
@endsection

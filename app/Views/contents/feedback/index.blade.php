@extends('layouts.app')

@section('content-title', 'Feedback Management')

@section('content')
    @if($isShowing ?? false)
        @include('contents.feedback.show')
    @else
        @include('contents.feedback.table')
    @endif
@endsection
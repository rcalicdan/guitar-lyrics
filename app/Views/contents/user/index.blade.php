@extends('layouts.app')

@section('content-title', 'User Management')

@section('content')
@if ($addingUser ?? false)
    @include('contents.user.create-user')
@elseif($user ?? false)
    @include('contents.user.edit-user')
@else
    @include('contents.user.user-table')
@endif  
@endsection
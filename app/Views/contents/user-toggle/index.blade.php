@extends('layouts.app')

@section('content-title', $contentTitle)

@section('content')
@if ($isUpdatingProfile ?? false)
    @include('contents.user-toggle.update-personal-information')
@elseif($isUpdatingPassword ?? false)
    @include('contents.user-toggle.update-password')
@elseif($isUpdatingImage ?? false)
    @include('contents.user-toggle.update-profile-image')
@elseif($isShowingProfilePage ?? false)
    @include('contents.user-toggle.user-profile')
@endif
@endsection
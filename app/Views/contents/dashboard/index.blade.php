@extends('layouts.app')

@section('content-title', 'Dashboard')

@include('stacks.dashboard.styles')

@section('content')
<div class="dashboard-container">
    <div class="container-fluid">
        <!-- Dashboard Statistics Cards -->
        <div class="dashboard-section">
            @include('contents.dashboard.dashboard-card')
        </div>

        <!-- Charts and Analytics -->
        <div class="dashboard-section">
            <div class="section-header mt-4">
                <h2 class="section-title">Analytics & Insights</h2>
                <p class="section-subtitle">Visual representation of your platform's data</p>
            </div>
            @include('contents.dashboard.charts-and-tables')
        </div>

        <!-- Recent Activity -->
        <div class="dashboard-section">
            <div class="section-header mt-4">
                <h2 class="section-title">Recent Activity</h2>
                <p class="section-subtitle">Latest comments and user engagement</p>
            </div>
            <div class="row">
                @include('contents.dashboard.recent-comments')
            </div>
        </div>
    </div>
</div>
@endsection

@include('stacks.dashboard.scripts')
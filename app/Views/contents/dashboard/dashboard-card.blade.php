<!-- app/Views/contents/dashboard/dashboard-card.blade.php -->
<div class="row">
    <!-- Total Songs Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ number_format($totalSongs) }}</h3>
                <p>Total Songs</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path
                    d="M19.952 1.651a.75.75 0 01.298.599V16.303a3 3 0 01-2.176 2.884l-1.32.377a2.553 2.553 0 11-1.403-4.909l2.311-.66a1.5 1.5 0 001.088-1.442V6.994l-9 2.572v9.737a3 3 0 01-2.176 2.884l-1.32.377a2.553 2.553 0 11-1.402-4.909l2.31-.66a1.5 1.5 0 001.088-1.442V9.017 5.25a.75.75 0 01.544-.721l10.5-3a.75.75 0 01.658.122z">
                </path>
            </svg>
            <a href="{{ route_to('songs.index') }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View Songs <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <!-- Total Artists Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ number_format($totalArtists) }}</h3>
                <p>Total Artists</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path
                    d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM12.75 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122z">
                </path>
            </svg>
            <a href="{{ route_to('artists.index') }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View Artists <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <!-- Total Users Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ number_format($totalUsers) }}</h3>
                <p>Total Users</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z">
                </path>
            </svg>
            <a href="{{ route_to('users.index') }}"
                class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                View Users <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <!-- Total Categories Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3>{{ number_format($totalCategories) }}</h3>
                <p>Total Categories</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path
                    d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155">
                </path>
            </svg>
            <a href="{{ route_to('songs.categories.index') }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                View Categories <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>
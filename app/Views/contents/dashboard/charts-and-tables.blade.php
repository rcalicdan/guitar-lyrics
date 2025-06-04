@use('Illuminate\Support\Str')
<div class="row">
    <!-- Songs by Category Chart -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="chart-container">
            <div class="chart-title">
                <i class="fas fa-chart-pie" style="color: var(--primary-color);"></i>
                Songs by Category
            </div>
            <div id="categoryChart">
            </div>
        </div>
    </div>

    <!-- Monthly Song Creation Chart -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="chart-container">
            <div class="chart-title">
                <i class="fas fa-chart-line" style="color: var(--secondary-color);"></i>
                Monthly Song Creation
            </div>
            <div id="monthlyChart">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Artists Chart -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="chart-container">
            <div class="chart-title">
                <i class="fas fa-chart-bar" style="color: var(--success-color);"></i>
                Top Artists by Song Count
            </div>
            <div id="artistChart">
            </div>
        </div>
    </div>

    <!-- Popular Songs Table - Simplified and Fixed -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="stats-card">
            <div class="chart-title">
                <i class="fas fa-star" style="color: #f59e0b;"></i>
                Most Popular Songs
            </div>
            <div class="songs-table-container">
                <table class="songs-table">
                    <thead>
                        <tr>
                            <th style="color: #111827; font-weight: 600;">
                                <i class="fas fa-music" style="color: #4f46e5; margin-right: 8px;"></i>Song
                            </th>
                            <th style="color: #111827; font-weight: 600;">
                                <i class="fas fa-user" style="color: #4f46e5; margin-right: 8px;"></i>Artist
                            </th>
                            <th style="color: #111827; font-weight: 600;">
                                <i class="fas fa-tag" style="color: #4f46e5; margin-right: 8px;"></i>Category
                            </th>
                            <th style="color: #111827; font-weight: 600;">
                                <i class="fas fa-eye" style="color: #4f46e5; margin-right: 8px;"></i>Views
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularSongs as $index => $song)
                        <tr class="song-row">
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span class="rank-number">{{ $index + 1 }}</span>
                                    <span style="color: #111827; font-weight: 600; font-size: 14px;">
                                        {{ Str::limit($song->title, 25) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span style="color: #6b7280; font-weight: 500; font-size: 13px;">
                                    {{ $song->artist_name }}
                                </span>
                            </td>
                            <td>
                                <span class="category-pill">{{ $song->category_name }}</span>
                            </td>
                            <td>
                                <span class="views-pill">
                                    <i class="fas fa-eye" style="margin-right: 4px;"></i>{{ $song->formatted_views }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #6b7280;">
                                <i class="fas fa-music" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                                <p style="margin: 0;">No songs found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.songs-table-container {
    max-height: 450px;
    overflow-y: auto;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.songs-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
    font-size: 14px;
    background: white;
}

.songs-table thead th {
    background: linear-gradient(135deg, #f8fafc, #ffffff);
    border-bottom: 2px solid #4f46e5;
    padding: 16px 12px;
    position: sticky;
    top: 0;
    z-index: 10;
    font-size: 14px;
}

.songs-table tbody .song-row {
    transition: all 0.2s ease;
    border-bottom: 1px solid #e5e7eb;
}

.songs-table tbody .song-row:hover {
    background-color: rgba(79, 70, 229, 0.08);
    transform: translateX(2px);
}

.songs-table tbody td {
    padding: 14px 12px;
    vertical-align: middle;
    border-bottom: 1px solid #e5e7eb;
}

.rank-number {
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    color: white;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    box-shadow: 0 2px 4px rgba(79, 70, 229, 0.3);
}

.category-pill {
    background: linear-gradient(135deg, #10b981, #34d399);
    color: white;
    font-size: 11px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 12px;
    text-transform: capitalize;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
    display: inline-block;
}

.views-pill {
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    color: white;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 15px;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 4px rgba(79, 70, 229, 0.3);
    display: inline-flex;
    align-items: center;
}

.views-pill i {
    color: white;
    font-size: 10px;
}

/* Custom scrollbar */
.songs-table-container::-webkit-scrollbar {
    width: 6px;
}

.songs-table-container::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 3px;
}

.songs-table-container::-webkit-scrollbar-thumb {
    background: #4f46e5;
    border-radius: 3px;
}

.songs-table-container::-webkit-scrollbar-thumb:hover {
    background: #06b6d4;
}
</style>
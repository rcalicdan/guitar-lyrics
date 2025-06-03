@use('Illuminate\Support\Str')
<div class="row mt-4">
    <!-- Songs by Category Pie Chart -->
    <div class="col-md-6">
        <div class="chart-container">
            <div class="chart-title">Songs by Category</div>
            <div id="categoryChart"></div>
        </div>
    </div>

    <!-- Monthly Song Creation Line Chart -->
    <div class="col-md-6">
        <div class="chart-container">
            <div class="chart-title">Monthly Song Creation</div>
            <div id="monthlyChart"></div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Artists Bar Chart -->
    <div class="col-md-6">
        <div class="chart-container">
            <div class="chart-title">Top Artists by Song Count</div>
            <div id="artistChart"></div>
        </div>
    </div>

    <!-- Popular Songs Table -->
    <div class="col-md-6">
        <div class="stats-card">
            <div class="chart-title">Most Popular Songs</div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Song</th>
                            <th>Artist</th>
                            <th>Category</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popularSongs as $song)
                        <tr>
                            <td>{{ Str::limit($song->title, 30) }}</td>
                            <td>{{ $song->artist_name }}</td>
                            <td>{{ $song->category_name }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $song->formatted_views }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No songs found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@extends('layouts.cms')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <h2 class="card-text">1,234</h2>
                            <p class="card-text"><small>Active users in the system</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Posts</h5>
                            <h2 class="card-text">567</h2>
                            <p class="card-text"><small>Published posts</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <h2 class="card-text">12</h2>
                            <p class="card-text"><small>Available categories</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Comments</h5>
                            <h2 class="card-text">890</h2>
                            <p class="card-text"><small>Total comments</small></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">User Registration Trend</h5>
                            <canvas id="userChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Posts by Category</h5>
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts Table -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Posts</h5>
                    <div class="table-responsive">
                        <table class="table table-striped" id="recentPostsTable">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Getting Started with Laravel</td>
                                    <td>Programming</td>
                                    <td>John Doe</td>
                                    <td>15 Mar 2024</td>
                                    <td><span class="badge bg-success">published</span></td>
                                </tr>
                                <tr>
                                    <td>Web Development Tips</td>
                                    <td>Development</td>
                                    <td>Jane Smith</td>
                                    <td>14 Mar 2024</td>
                                    <td><span class="badge bg-success">published</span></td>
                                </tr>
                                <tr>
                                    <td>Database Optimization</td>
                                    <td>Database</td>
                                    <td>Mike Johnson</td>
                                    <td>13 Mar 2024</td>
                                    <td><span class="badge bg-warning">draft</span></td>
                                </tr>
                                <tr>
                                    <td>UI/UX Best Practices</td>
                                    <td>Design</td>
                                    <td>Sarah Wilson</td>
                                    <td>12 Mar 2024</td>
                                    <td><span class="badge bg-success">published</span></td>
                                </tr>
                                <tr>
                                    <td>API Development Guide</td>
                                    <td>Programming</td>
                                    <td>Alex Brown</td>
                                    <td>11 Mar 2024</td>
                                    <td><span class="badge bg-success">published</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // User Registration Chart
        const userCtx = document.getElementById('userChart').getContext('2d');
        new Chart(userCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Users',
                    data: [150, 230, 180, 290, 200, 250],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Programming', 'Development', 'Database', 'Design', 'Security'],
                datasets: [{
                    data: [30, 25, 15, 20, 10],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Initialize DataTable
        $(document).ready(function() {
            $('#recentPostsTable').DataTable({
                responsive: true,
                pageLength: 5,
                lengthChange: false,
                searching: false,
                ordering: false
            });
        });
    </script>
    @endpush
@endsection
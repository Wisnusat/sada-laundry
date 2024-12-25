<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SADA Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid white;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1rem 1rem;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .table-container {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }

        .status-badge {
            padding: 0.5em 1em;
            border-radius: 50px;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .modal-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
            color: white;
        }

        .detail-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }

        .alert-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('image/logo_laundry.jpg') }}" alt="SADA Laundry Logo">
                SADA Laundry
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/admin/order-list">Order List</a></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert-float">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="h2 mb-3">Order Management Dashboard</h1>
            <p class="lead mb-0">Monitor and manage all customer orders</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-shopping-basket stats-icon"></i>
                    <h3 class="h5">Total Orders</h3>
                    <p class="h3 mb-0">{{ $orders->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-spinner stats-icon"></i>
                    <h3 class="h5">Processing</h3>
                    <p class="h3 mb-0">{{ $orders->where('status', 'processing')->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-box stats-icon"></i>
                    <h3 class="h5">Ready to Pickup</h3>
                    <p class="h3 mb-0">{{ $orders->where('status', 'ready_to_pickup')->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-check-circle stats-icon"></i>
                    <h3 class="h5">Completed</h3>
                    <p class="h3 mb-0">{{ $orders->where('status', 'completed')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->service }}</td>
                                <td>{{ $order->weight }} kg</td>
                                <td>Rp. {{ number_format($order->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge rounded-pill
                                        @if($order->status === 'processing') bg-info
                                        @elseif($order->status === 'ready to pickup') bg-primary
                                        @elseif($order->status === 'completed') bg-success
                                        @elseif($order->status === 'pending') bg-warning
                                        @elseif($order->status === 'canceled') bg-danger
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline-primary"
                                                onclick="showOrderDetails({{ $order }})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#orderModal">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <select name="status" class="form-select form-select-sm" required>
                                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="ready_to_pickup" {{ $order->status === 'ready_to_pickup' ? 'selected' : '' }}>Ready to Pickup</option>
                                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-item">
                        <span class="detail-label">Order ID:</span>
                        <span id="orderIdDetail"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Service Type:</span>
                        <span id="serviceDetail"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Weight:</span>
                        <span id="weight"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Price:</span>
                        <span id="priceDetail"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status:</span>
                        <span id="statusDetail"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Order Date:</span>
                        <span id="dateDetail"></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Address:</span>
                        <span id="address"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <p class="mb-2">&copy; 2024 SADA Laundry. All Rights Reserved.</p>
        <p class="mb-0">
            <i class="fas fa-envelope me-2"></i> SADA@laundry.com |
            <i class="fas fa-phone ms-2 me-2"></i> 123-456-7890
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-float .alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }, 3000);
            });
        });

        function showOrderDetails(order) {
            const orderDetails = {
                id: order.id,
                service: order.service,
                weight: order.weight,
                price: order.price,
                status: order.status,
                date: order.created_at.split('T')[0],
                address: order.address
            };

            // Update modal content
            document.getElementById('orderIdDetail').textContent = orderDetails.id;
            document.getElementById('serviceDetail').textContent = orderDetails.service;
            document.getElementById('weight').textContent = orderDetails.weight;
            document.getElementById('priceDetail').textContent = `Rp. ${orderDetails.price}`;
            document.getElementById('statusDetail').textContent = orderDetails.status;
            document.getElementById('dateDetail').textContent = orderDetails.date;
            document.getElementById('address').textContent = orderDetails.address;
        }
    </script>
</body>
</html>

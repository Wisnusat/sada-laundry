<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order History - SADA Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
        .page-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1rem 1rem;
        }
        .table {
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead {
            background-color: #f8f9fa;
        }
        .table th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .table td {
            vertical-align: middle;
        }
        .order-row {
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .order-row:hover {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 0.5em 1em;
            font-weight: 500;
        }
        .modal-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
            color: white;
        }
        .modal-body {
            padding: 2rem;
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
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 20px 0;
            margin-top: 3rem;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .stats-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #0d6efd;
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
                    @guest
                        <li class="nav-item"><a class="nav-link text-white" href="/login">Login</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/register">Register</a></li>
                    @else
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link text-white" href="/admin/order-list">Order List</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link text-white" href="/order">Order Now</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="/order-history">History</a></li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="display-5 mb-3">Your Order History</h1>
            <p class="lead mb-0">Track and manage all your laundry orders in one place</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5 min-vh-100">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            {{-- <div class="col-md-2">
                <div class="stats-card text-center">
                    <i class="fas fa-shopping-basket stats-icon"></i>
                    <h3 class="h5">Total Orders</h3>
                    <p class="h3 mb-0">{{ $orders->count() }}</p>
                </div>
            </div> --}}
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-spinner stats-icon"></i>
                    <h3 class="h5">In Progress</h3>
                    <p class="h3 mb-0">{{ $orders->where('status', 'processing')->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-check-circle stats-icon"></i>
                    <h3 class="h5">Completed</h3>
                    <p class="h3 mb-0">{{ $orders->where('status', 'completed')->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-box stats-icon"></i>
                    <h3 class="h5">Ready to Pickup</h3>
                    <p class="h3 mb-0">{{ $orders->where('status', 'ready to pickup')->count() }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-clock stats-icon"></i>
                    <h3 class="h5">Pending</h3>
                    <p class="h3 mb-0">{{ $orders->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Order History Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="order-row">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->service }}</td>
                            <td>Rp. {{ number_format($order->price, 0, ',', '.') }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge rounded-pill
                                    @if($order->status == 'pending') bg-warning
                                    @elseif($order->status == 'processing') bg-info
                                    @elseif($order->status == 'ready to pickup') bg-primary
                                    @elseif($order->status == 'completed') bg-success
                                    @elseif($order->status == 'canceled') bg-danger
                                    @endif">
                                    <i class="fas
                                        @if($order->status == 'pending') fa-clock
                                        @elseif($order->status == 'processing') fa-spinner fa-spin
                                        @elseif($order->status == 'ready to pickup') fa-box
                                        @elseif($order->status == 'completed') fa-check-circle
                                        @elseif($order->status == 'canceled') fa-times-circle
                                        @endif me-1"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#orderModal"
                                        data-order-id="{{ $order->id }}"
                                        onclick="showOrderDetails({{ $order }})">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                                @if($order->status != 'canceled' && $order->status != 'completed')
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="cancelOrder({{ $order->id }})">
                                        <i class="fas fa-times-circle me-1"></i> Cancel
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                                <p class="h5 text-muted">No orders found</p>
                                <a href="/order" class="btn btn-primary mt-2">Place Your First Order</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

        function cancelOrder(orderId) {
        if (!confirm("Are you sure you want to cancel this order?")) {
            return;
        }

        fetch(`/orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to cancel the order');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            location.reload(); // Reload the page to reflect the changes
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
    </script>
</body>
</html>

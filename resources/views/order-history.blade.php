<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Laundry - Laundry SADA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 15px 0;
        }
        @media (max-width: 768px) {
            .navbar-brand img {
                height: 40px;
            }
        }
    </style>
</head>
<body>
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
                                <button type="submit" class="btn btn-link nav-link text-white">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container min-vh-100 my-5">
        <div class="text-center">
            <h1 class="display-5">Your Order History</h1>
            <p class="lead text-primary">View the status and details of your previous laundry orders.</p>
        </div>

        <!-- Order History Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->service }}</td>
                            <td>Rp. {{ $order->price }}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge
                                @if($order->status == 'pending') bg-warning
                                @elseif($order->status == 'processing') bg-info
                                @elseif($order->status == 'ready to pickup') bg-primary
                                @elseif($order->status == 'completed') bg-success
                                @endif">
                                {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No orders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <footer class="text-center">
        <p>&copy; 2024 SADA Laundry. All Rights Reserved.</p>
        <p>Email: SADA@laundry.com | Phone: 123-456-7890</p>
    </footer>
</body>
</html>

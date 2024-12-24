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
                        <li class="nav-item"><a class="nav-link text-white" href="/order">Order Now</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/order-history">History</a></li>
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
    <div class="container my-5">
        <h1 class="mb-4">Order List</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
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
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->service }}</td>
                        <td>{{ $order->weight }} kg</td>
                        <td>Rp. {{ $order->price }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                <select name="status" class="form-select mb-2" required>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="ready_to_pickup" {{ $order->status === 'ready_to_pickup' ? 'selected' : '' }}>Ready to Pickup</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer class="text-center">
        <p>&copy; 2024 SADA Laundry. All Rights Reserved.</p>
        <p>Email: SADA@laundry.com | Phone: 123-456-7890</p>
    </footer>
</body>
</html>

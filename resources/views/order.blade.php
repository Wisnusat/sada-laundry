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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .banner-section {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .service-image {
            width: 100%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.1);
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
            <h1 class="display-5">Place Your Laundry Order</h1>
            <p class="lead text-primary">Fill in the details below to order your laundry service.</p>
        </div>
        <div class="card shadow-lg mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <!-- Display success or error messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Order Form -->
                <form action="{{ route('orders.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                        <div class="invalid-feedback">
                            Please provide your name.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter your phone number" required>
                        <div class="invalid-feedback">
                            Please provide a valid phone number.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="service" class="form-label">Service</label>
                        <select name="service" id="service" class="form-select" required>
                            <option value="" disabled selected>Choose a service...</option>
                            <option value="Washing">Washing</option>
                            <option value="Ironing">Ironing</option>
                            <option value="Both">Both</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a service.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" name="weight" id="weight" class="form-control" placeholder="Enter weight in kg" required>
                        <div class="invalid-feedback">
                            Please provide the weight in kilograms.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter your address" required></textarea>
                        <div class="invalid-feedback">
                            Please provide your address.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
    <footer class="text-center">
        <p>&copy; 2024 SADA Laundry. All Rights Reserved.</p>
        <p>Email: SADA@laundry.com | Phone: 123-456-7890</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap form validation
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>

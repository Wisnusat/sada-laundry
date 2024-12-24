<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SADA Laundry</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body class="d-flex flex-column min-vh-100">
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
                                <button type="submit" class="btn btn-link nav-link text-white">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <main class="flex-grow-1">
        @if(session('success'))
            <div class="position-fixed top-10 start-50 translate-middle w-25" style="z-index: 1050;">
                <div class="alert alert-success alert-dismissible d-none" role="alert" id="alert-box">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        <!-- Home Section -->
        <section id="home" class="py-5 text-center">
            <div class="container">
                <h1 class="display-4">Welcome to SADA Laundry</h1>
                <p class="lead">Your laundry picked up, cleaned, and delivered. Simply.</p>
            </div>
        </section>
    </main>
    <!-- Banner Section -->
    <div class="container banner-section text-center">
        <img src="{{ asset('image1/laundry .jpg') }}" alt="Laundry Service" class="service-image">
    </div>
    <!-- Footer -->
    <footer class="text-center">
        <p>&copy; 2024 SADA Laundry. All Rights Reserved.</p>
        <p>Email: SADA@laundry.com | Phone: 123-456-7890</p>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertBox = document.getElementById('alert-box');

        @if(session('success'))
            alertBox.classList.remove('d-none');
            setTimeout(() => {
                alertBox.classList.add('d-none');
            }, 3000); // Auto-hide after 5 seconds
        @endif
    });
</script>

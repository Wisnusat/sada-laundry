<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SADA Laundry - Professional Laundry Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --accent-color: #ffc107;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid white;
        }

        .hero-section {
            background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(13, 110, 253, 0.9)),
                        url('/api/placeholder/1920/1080');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .feature-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .service-card {
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .service-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .cta-section {
            background-color: var(--accent-color);
            padding: 60px 0;
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0 20px;
        }

        .social-icons {
            font-size: 1.5rem;
            margin: 20px 0;
        }

        .social-icons a {
            color: white;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: var(--accent-color);
        }

        .alert-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
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
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning text-white px-3 mx-2" href="/register">Register</a>
                        </li>
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
                                <button type="submit" class="btn btn-outline-light mx-2">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert-float">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Professional Laundry Services</h1>
            <p class="lead mb-4">Experience pristine cleanliness with our expert laundry solutions</p>
            @guest
                <div class="d-flex justify-content-center gap-3">
                    <a href="/register" class="btn btn-warning btn-lg">Get Started</a>
                    <a href="/login" class="btn btn-outline-light btn-lg">Login</a>
                </div>
            @else
                @if (optional(auth()->user())->role !== 'admin')
                    <a href="/order" class="btn btn-warning btn-lg">Order Now</a>
                @endif
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Why Choose SADA Laundry?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="text-center">
                            <i class="fas fa-tshirt feature-icon"></i>
                            <h3 class="h5">Expert Care</h3>
                            <p>Professional handling of all your garments with attention to detail</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="text-center">
                            <i class="fas fa-truck feature-icon"></i>
                            <h3 class="h5">Free Pickup & Delivery</h3>
                            <p>Convenient doorstep service at no extra charge</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4">
                        <div class="text-center">
                            <i class="fas fa-clock feature-icon"></i>
                            <h3 class="h5">Quick Turnaround</h3>
                            <p>Fast 24-48 hour service for regular orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Services</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="https://images.unsplash.com/photo-1624372635310-01d078c05dd9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8bGF1bmRyeXxlbnwwfHwwfHx8MA%3D%3D" alt="Wash & Fold" class="service-image">
                        <div class="card-body p-4">
                            <h3 class="h5">Wash</h3>
                            <p>Professional washing service for your everyday clothes. Fresh and Clean!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="https://images.unsplash.com/photo-1489274495757-95c7c837b101?q=80&w=2030&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Dry Cleaning" class="service-image">
                        <div class="card-body p-4">
                            <h3 class="h5">Iron</h3>
                            <p>Special iron care for your delicate and formal wear. Make your clothes new again</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="https://plus.unsplash.com/premium_photo-1678218580850-15c50b9f3525?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTN8fGxhdW5kcnl8ZW58MHx8MHx8fDA%3D" alt="Express Service" class="service-image">
                        <div class="card-body p-4">
                            <h3 class="h5">Wash & Iron</h3>
                            <p>Professional washing service for your everyday clothes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p class="mb-3">"Excellent service! My clothes always come back perfectly clean and well-pressed."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://i.pravatar.cc/50" alt="Customer" class="rounded-circle me-3">
                            <div>
                                <h4 class="h6 mb-0">John Doe</h4>
                                <small class="text-muted">Regular Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p class="mb-3">"Great attention to detail and fantastic customer service. Highly recommended!"</p>
                        <div class="d-flex align-items-center">
                            <img src="https://i.pravatar.cc/50" alt="Customer" class="rounded-circle me-3">
                            <div>
                                <h4 class="h6 mb-0">Jane Smith</h4>
                                <small class="text-muted">Loyal Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p class="mb-3">"Convenient pickup and delivery service. Makes my life so much easier!"</p>
                        <div class="d-flex align-items-center">
                            <img src="https://i.pravatar.cc/50" alt="Customer" class="rounded-circle me-3">
                            <div>
                                <h4 class="h6 mb-0">Mike Johnson</h4>
                                <small class="text-muted">Happy Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (optional(auth()->user())->role !== 'admin')
        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container text-center">
                <h2 class="mb-4">Ready to experience our service?</h2>
                <p class="lead mb-4">Join thousands of satisfied customers today!</p>
                @guest
                    <a href="/register" class="btn btn-primary btn-lg">Get Started Now</a>
                @else
                    <a href="/order" class="btn btn-primary btn-lg">Place an Order</a>
                @endguest
            </div>
        </section>
    @endif

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h3 class="h5">About SADA Laundry</h3>
                    <p>Professional laundry services dedicated to keeping your clothes fresh and clean.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h3 class="h5">Contact Us</h3>
                    <p><i class="fas fa-envelope me-2"></i> SADA@laundry.com</p>
                    <p><i class="fas fa-phone me-2"></i> 123-456-7890</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h3 class="h5">Follow Us</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <p class="text-center mb-0">&copy; 2024 SADA Laundry. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert-float .alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }, 3000);
            });
        });
    </script>
</body>
</html>

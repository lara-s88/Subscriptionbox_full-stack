<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

</head>
<body>

   <x-navbar activePage="login"></x-navbar>

    <main style="padding-top: 76px; min-height: 100vh;" class="d-flex align-items-center py-5">
        <div class="container">
            <div class="row align-items-stretch g-4 justify-content-center">
                <div class="col-lg-5 d-none d-lg-flex">
                    <div class="auth-hero w-100">
                        <div class="position-relative" style="z-index:1;">
                            <div class="mb-4"><i class="bi bi-box-seam-fill" style="font-size:3.5rem;"></i></div>
                            <h2 class="display-6 fw-bold mb-3">Subscription Box<br>Portal Access</h2>
                            <p class="lead mb-5" style="opacity:.88;">Customers manage recurring boxes here, and admins can sign in to review orders, returns, inventory, and themes.</p>
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <span>Role-based access for customers and admins</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <span>Tiered subscriptions, swaps, and delivery visibility</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <span>Admin controls for stock thresholds, returns, and monthly themes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-7 col-sm-10">
                    <div class="auth-card">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-box-arrow-in-right text-primary" style="font-size:2.25rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Login</h4>
                            <p class="text-muted small mb-0">Welcome back to SportBox.</p>
                        </div>
                        <h5 class="fw-bold mb-1">Welcome back!</h5>
                        <p class="text-muted small mb-4">Sign in with an account saved in the app database.</p>

                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-semibold small d-block mb-2">Sign in as</label>
                                <div class="btn-group w-100" role="group" aria-label="Account type">
                                    <input type="radio" class="btn-check" name="account_type" id="loginTypeCustomer" value="customer" autocomplete="off" {{ old('account_type', 'customer') === 'customer' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary py-2" for="loginTypeCustomer"><i class="bi bi-person me-1"></i>Customer</label>
                                    <input type="radio" class="btn-check" name="account_type" id="loginTypeAdmin" value="admin" autocomplete="off" {{ old('account_type') === 'admin' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary py-2" for="loginTypeAdmin"><i class="bi bi-shield-lock me-1"></i>Admin</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="email">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <label class="form-label fw-semibold small mb-0" for="password">Password</label>
                                    <a href="#" class="text-primary text-decoration-none small">Forgot password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                                <label class="form-check-label text-muted small" for="rememberMe">Remember me for 30 days</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login to SportBox
                            </button>
                        </form>
                        <div class="text-center mt-4">
                            <span class="text-muted small">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="text-primary fw-semibold small text-decoration-none">Create one</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5>
                    <p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('sports') }}">Sports</a></li>
                        <li><a href="{{ route('subscriptions') }}">Subscriptions</a></li>
                        <li><a href="{{ route('reward') }}">Rewards</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Account</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Contact</h6>
                    <p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com</p>
                    <p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p>
                    <p style="font-size:.9rem;"><i class="bi bi-geo-alt me-2 text-primary"></i>123 Sport Lane, NY 10001</p>
                </div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">&copy; 2026 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - SportBox</title>
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
                            <p class="lead mb-5" style="opacity:.88;">Create your customer account and let the backend connect it to your database data.</p>
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
                                <i class="bi bi-person-plus text-primary" style="font-size:2.25rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-1">Register</h4>
                            <p class="text-muted small mb-0">Create a new SportBox account.</p>
                        </div>
                        <h5 class="fw-bold mb-1">Create your account</h5>
                        <p class="text-muted small mb-4">New registrations create customer accounts in the database.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold small" for="first_name">First Name</label>
                                    <input type="text" class="form-control" placeholder="John" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold small" for="last_name">Last Name</label>
                                    <input type="text" class="form-control" placeholder="Doe" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="email">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" class="form-control" placeholder="you@example.com" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" class="form-control" placeholder="Min. 8 characters" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="favorite_theme">Favorite Theme</label>
                                <select class="form-select" id="favorite_theme" name="favorite_theme">
                                    <option value="">Select your theme...</option>
                                    <option>Football</option>
                                    <option>Basketball</option>
                                    <option>Fitness</option>
                                    <option>Tennis</option>
                                    <option>Coffee</option>
                                    <option>Books</option>
                                    <option>Electronics</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="referral_code">Referral Code <span class="text-muted fw-normal">(optional)</span></label>
                                <input type="text" class="form-control" placeholder="Enter referral code" id="referral_code" name="referral_code" value="{{ old('referral_code') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="state_code">State Code</label>
                                <input type="text" class="form-control" placeholder="NY" id="state_code" name="state_code" value="{{ old('state_code') }}" maxlength="2">
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                <label class="form-check-label text-muted small" for="termsCheck">
                                    I agree to the <a href="#" class="text-primary">Terms &amp; Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                                <i class="bi bi-person-check me-2"></i>Create My Account
                            </button>
                        </form>
                        <div class="text-center mt-4">
                            <span class="text-muted small">Already have an account?</span>
                            <a href="{{ route('login') }}" class="text-primary fw-semibold small text-decoration-none">Login</a>
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

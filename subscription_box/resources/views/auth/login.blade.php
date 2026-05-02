<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

</head>
<body>
   <x-navbar activePage="sports"></x-navbar>

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
                        <div class="auth-tab-nav" id="authPageTabs">
                            <button class="auth-tab-btn active" onclick="switchTab('login', this)">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>
                            <button class="auth-tab-btn" onclick="switchTab('register', this)">
                                <i class="bi bi-person-plus me-2"></i>Register
                            </button>
                        </div>

                        <div id="loginForm">
                            <h5 class="fw-bold mb-1">Welcome back!</h5>
                            <p class="text-muted small mb-4">Choose a role and sign in with an account saved in the app database.</p>
                            <form onsubmit="handleLogin(event)">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Login As</label>
                                    <div class="auth-tab-nav mb-0">
                                        <button type="button" class="auth-tab-btn active" data-role-btn="customer" onclick="selectLoginRole('customer', this)">
                                            <i class="bi bi-person me-2"></i>Customer
                                        </button>
                                        <button type="button" class="auth-tab-btn" data-role-btn="admin" onclick="selectLoginRole('admin', this)">
                                            <i class="bi bi-shield-lock me-2"></i>Admin
                                        </button>
                                    </div>
                                    <input type="hidden" id="loginRole" value="customer">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent"><i class="bi bi-envelope text-muted"></i></span>
                                        <input type="email" class="form-control" id="loginEmail" placeholder="you@example.com" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <label class="form-label fw-semibold small mb-0">Password</label>
                                        <a href="#" class="text-primary text-decoration-none small">Forgot password?</a>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent"><i class="bi bi-lock text-muted"></i></span>
                                        <input type="password" class="form-control" id="loginPwd" placeholder="Enter your password" required>
                                        <button class="input-group-text bg-transparent border-start-0" type="button" onclick="togglePwd('loginPwd', this)">
                                            <i class="bi bi-eye text-muted"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label text-muted small" for="rememberMe">Remember me for 30 days</label>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold mb-4">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login to SportBox
                                </button>
                                <div class="p-3 rounded-4 border mb-4" style="background:rgba(16,185,129,.06); border-color:rgba(16,185,129,.2)!important;">
                                    <div class="small fw-semibold text-primary mb-2">Demo database accounts</div>
                                    <div class="small text-muted mb-1">Admin: admin@sportbox.com / Admin123!</div>
                                    <div class="small text-muted">Customer: alex@sportbox.com / User123!</div>
                                </div>
                            </form>
                        </div>

                        <div id="registerForm" style="display:none;">
                            <h5 class="fw-bold mb-1">Create your account</h5>
                            <p class="text-muted small mb-4">New registrations create customer accounts in the mock database for now.</p>
                            <form onsubmit="handleRegister(event)">
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">First Name</label>
                                        <input type="text" class="form-control" placeholder="John" id="regFirstName" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Doe" id="regLastName" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent"><i class="bi bi-envelope text-muted"></i></span>
                                        <input type="email" class="form-control" placeholder="you@example.com" id="regEmail" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent"><i class="bi bi-lock text-muted"></i></span>
                                        <input type="password" class="form-control" placeholder="Min. 8 characters" id="regPwd" required>
                                        <button class="input-group-text bg-transparent border-start-0" type="button" onclick="togglePwd('regPwd', this)">
                                            <i class="bi bi-eye text-muted"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Favorite Theme</label>
                                    <select class="form-select" id="regFavoriteSport">
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
                                    <label class="form-label fw-semibold small">Referral Code <span class="text-muted fw-normal">(optional)</span></label>
                                    <input type="text" class="form-control" placeholder="Enter referral code" id="regReferralCode">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">State Code (service zone check)</label>
                                    <input type="text" class="form-control" placeholder="NY" id="regStateCode" maxlength="2" required>
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
                    <div class="social-links d-flex gap-2">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('sports') }}">Sports</a></li>
                        <li><a href="{{ route('subscriptions') }}">Subscriptions</a></li>
                        <li id="footerRewardItem"><a href="{{ route('reward') }}">Rewards</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Account</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('login') }}" id="footerAuthLink">Login</a></li>
                        <li id="footerRegisterItem"><a href="{{ route('login') }}">Register</a></li>
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

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100">
        <div id="mainToast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toastMsg">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/home/login.js') }}"></script>
</body>
</html>

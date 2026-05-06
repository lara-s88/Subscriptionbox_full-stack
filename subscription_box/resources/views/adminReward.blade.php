<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Rewards - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/reward.css') }}">
    <style>
        .reward-admin-shell {
            padding-top: 76px;
        }

        .table thead th {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #6b7280;
        }
    </style>
</head>

<body>
    <x-navbar activePage="reward"></x-navbar>

    <div class="hero-section-sm text-center reward-admin-shell">
        <div class="container position-relative">
            <h1 class="display-5 fw-bold mb-3"><i class="bi bi-award me-3"></i>Customer Rewards Monitor</h1>
            <p class="lead mb-0" style="opacity:.88;">Admin view of each customer account and its current reward points.</p>
        </div>
    </div>

    <section class="py-5" id="adminRewardsView">
        <div class="container">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Customer Reward Points</h6>
                        <span class="badge rounded-pill" style="background:var(--gradient);">0 Accounts</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="h4 fw-bold text-primary mb-1">0</div>
                                <div class="text-muted small">Tracked customers</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="h4 fw-bold text-primary mb-1">0</div>
                                <div class="text-muted small">Total reward points</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <div class="h4 fw-bold text-primary mb-1">N/A</div>
                                <div class="text-muted small">Top reward balance</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Points</th>
                                    <th>Tier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Customer name</td>
                                    <td>customer@example.com</td>
                                    <td>Plan</td>
                                    <td class="text-primary fw-semibold">0</td>
                                    <td><span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">Tier</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Customer name</td>
                                    <td>customer@example.com</td>
                                    <td>Plan</td>
                                    <td class="text-primary fw-semibold">0</td>
                                    <td><span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">Tier</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Customer name</td>
                                    <td>customer@example.com</td>
                                    <td>Plan</td>
                                    <td class="text-primary fw-semibold">0</td>
                                    <td><span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">Tier</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100">
        <div id="mainToast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toastMsg">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <footer class="footer py-5 mt-3">
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
                        <li><a href="{{ route('admin.reward') }}">Rewards</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Account</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('login') }}" id="footerAuthLink">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Contact</h6>
                    <p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com</p>
                    <p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p>
                </div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">&copy; 2026 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

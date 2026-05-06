<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral &amp; Rewards - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/reward.css') }}">
    
</head>
<body>
    <!-- Navbar -->
   <x-navbar activePage="reward"></x-navbar>
   @php($isAdminReward = ($rewardMode ?? 'customer') === 'admin')

    <!-- Hero -->
    <div class="hero-section-sm text-center">
        <div class="container position-relative">
            <h1 class="display-5 fw-bold mb-3">
                <i class="bi {{ $isAdminReward ? 'bi-award' : 'bi-gift' }} me-3"></i>{{ $isAdminReward ? 'Customer Rewards Monitor' : 'Referral &amp; Rewards' }}
            </h1>
            <p class="lead mb-0" style="opacity:.88;">{{ $isAdminReward ? 'Admin view of each customer account and its current reward points.' : 'Invite friends, earn points, unlock exclusive rewards' }}</p>
        </div>
    </div>

    <!-- Content -->
    <section class="py-5" id="customerRewardsView" @if($isAdminReward) style="display:none;" @endif>
        <div class="container">
            <!-- Points Summary Banner -->
            <div class="p-4 rounded-4 mb-5 text-white" style="background:var(--gradient);">
                <div class="row align-items-center g-3">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:60px;height:60px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-trophy-fill fs-3"></i>
                            </div>
                            <div>
                                <div class="display-6 fw-bold mb-0">1,240 Points</div>
                                <div style="opacity:.85;">Silver Tier — 760 points to Gold</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="d-flex gap-3 justify-content-md-end flex-wrap">
                            <div class="text-center">
                                <div class="fw-bold fs-5">3</div>
                                <div class="small" style="opacity:.8;">Friends Referred</div>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold fs-5">$24</div>
                                <div class="small" style="opacity:.8;">Saved</div>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold fs-5">8</div>
                                <div class="small" style="opacity:.8;">Boxes Received</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <!-- Referral Code -->
                    <div class="card border-0 rounded-4 shadow-sm mb-4">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                            <h6 class="fw-bold mb-0"><i class="bi bi-share text-primary me-2"></i>Your Referral Code</h6>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-4">Share your code and earn <strong class="text-primary">200 points</strong> for every friend who subscribes!</p>
                            <div class="referral-box mb-4">
                                <div class="referral-code-text" id="refCode">SPORT123</div>
                                <div class="text-muted small mt-1">Click to copy</div>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-primary" type="button"><i class="bi bi-clipboard me-2"></i>Copy Code</button>
                                <button class="btn btn-outline-primary" type="button"><i class="bi bi-link-45deg me-2"></i>Copy Link</button>
                            </div>
                        </div>
                    </div>

                    <!-- Share on Social -->
                    <div class="card border-0 rounded-4 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-megaphone text-primary me-2"></i>Share &amp; Earn</h6>
                            <p class="text-muted small mb-4">Share via social media and earn an extra <strong class="text-primary">50 points</strong> per platform!</p>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm px-3 py-2 rounded-pill fw-semibold" style="background:#1877F2;color:white;" type="button"><i class="bi bi-facebook me-1"></i>Facebook</button>
                                <button class="btn btn-sm px-3 py-2 rounded-pill fw-semibold" style="background:#E1306C;color:white;" type="button"><i class="bi bi-instagram me-1"></i>Instagram</button>
                                <button class="btn btn-sm px-3 py-2 rounded-pill fw-semibold" style="background:#1DA1F2;color:white;" type="button"><i class="bi bi-twitter-x me-1"></i>Twitter</button>
                                <button class="btn btn-sm px-3 py-2 rounded-pill fw-semibold" style="background:#25D366;color:white;" type="button"><i class="bi bi-whatsapp me-1"></i>WhatsApp</button>
                            </div>
                        </div>
                    </div>

                    <!-- Friends Invited -->
                    <div class="card border-0 rounded-4 shadow-sm">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Friends Invited</h6>
                                <span class="badge rounded-pill" style="background:var(--gradient);">3 Friends</span>
                            </div>
                        </div>
                        <div class="card-body p-3" id="friendsList">
                            <div class="d-flex align-items-center justify-content-between border rounded-3 p-3 mb-2">
                                <div>
                                    <div class="fw-semibold small">Friend name</div>
                                    <div class="text-muted" style="font-size:.8rem;">Backend referral status</div>
                                </div>
                                <span class="badge rounded-pill" style="background:rgba(16,185,129,.1);color:var(--primary);">Status</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6">
                    <!-- Progress -->
                    <div class="card border-0 rounded-4 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4"><i class="bi bi-bar-chart-line text-primary me-2"></i>Tier Progress</h6>
                            <div class="d-flex flex-column gap-3 mb-4" id="tierList">
                                <div class="d-flex align-items-center justify-content-between border rounded-3 p-3">
                                    <div class="fw-semibold small">Tier name</div>
                                    <span class="text-muted small">Points</span>
                                </div>
                            </div>
                            <div class="p-3 rounded-3 mt-2" style="background:linear-gradient(135deg,rgba(16,185,129,.06),rgba(15,118,110,.03));">
                                <div class="d-flex justify-content-between small mb-2">
                                    <span class="text-muted">Silver → Gold</span>
                                    <span class="fw-semibold text-primary">1,240 / 2,000</span>
                                </div>
                                <div class="progress" style="height:10px;border-radius:6px;">
                                    <div class="progress-bar" style="width:62%;background:var(--gradient);border-radius:6px;"></div>
                                </div>
                                <div class="small text-muted mt-2"><i class="bi bi-info-circle me-1"></i>760 more points to reach Gold tier</div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Rewards -->
                    <div class="card border-0 rounded-4 shadow-sm">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                            <h6 class="fw-bold mb-0"><i class="bi bi-gift text-primary me-2"></i>Available Rewards</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex flex-column gap-3" id="rewardsList">
                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold">Reward name</div>
                                            <div class="small text-muted">Backend reward details go here.</div>
                                        </div>
                                        <button class="btn btn-sm btn-outline-primary" type="button">Redeem</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5" id="adminRewardsView" @if(!$isAdminReward) style="display:none;" @endif>
        <div class="container">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Customer Reward Points</h6>
                        <span class="badge rounded-pill" style="background:var(--gradient);" id="adminRewardsCount">0 Accounts</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 mb-4" id="adminRewardStats">
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
                            <tbody id="adminRewardsTable">
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

    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100">
        <div id="mainToast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toastMsg">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-5 mt-3">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4"><h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5><p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p><div class="social-links d-flex gap-2"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-twitter-x"></i></a><a href="#"><i class="bi bi-youtube"></i></a></div></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Quick Links</h6><ul class="footer-links"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('sports') }}">Sports</a></li><li><a href="{{ route('subscriptions') }}">Subscriptions</a></li><li id="footerRewardItem"><a href="{{ route('reward') }}">Rewards</a></li></ul></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Account</h6><ul class="footer-links"><li><a href="{{ route('dashboard') }}">Dashboard</a></li><li><a href="{{ route('login') }}" id="footerAuthLink">Login</a></li></ul></div>
                <div class="col-lg-4"><h6 class="fw-bold mb-3">Contact</h6><p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com</p><p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p></div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">© 2024 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>

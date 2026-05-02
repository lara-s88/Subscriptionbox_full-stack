<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    
</head>

<body>

    <x-navbar activePage="dashboard"></x-navbar>

    <div class="page-header">
        <div class="container position-relative">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div
                    style="width:60px;height:60px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-person-fill fs-2 text-white" id="headerIcon"></i>
                </div>
                <div>
                    <p class="mb-0 small" style="opacity:.75;" id="headerEyebrow">Welcome back!</p>
                    <h3 class="mb-0 fw-bold" id="headerName">Dashboard</h3>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap" id="headerBadges"></div>
        </div>
    </div>

    <main class="py-5">
        <div class="container">
            <div id="emptyState" class="surface-card p-5 text-center" style="display:none;">
                <div class="mb-3"><i class="bi bi-shield-lock fs-1 text-primary"></i></div>
                <h4 class="fw-bold mb-2">Sign in to open the portal</h4>
                <p class="text-muted mb-4">Customers can manage subscriptions here, and admins can review orders,
                    returns, stock alerts, and theme uploads.</p>
                <a href="{{ route('login') }}" class="btn btn-primary px-4">Go to Login</a>
            </div>

            <section id="customerDashboard" style="display:none;">
                <div class="row g-3 mb-4" id="customerStats"></div>
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden">
                            <div class="card-header border-0 py-3 px-4"
                                style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-box-seam text-primary me-2"></i>Upcoming
                                        Box</h6>
                                    <span class="status-pill" id="customerDeliveryPill"
                                        style="background:#fef9c3;color:#854d0e;">Shipped</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-4">
                                        <div class="overflow-hidden rounded-3" style="height:185px;">
                                            <img src="https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800"
                                                class="w-100 h-100" style="object-fit:cover;" alt="Customer box">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-start gap-2 mb-1">
                                            <h5 class="fw-bold mb-0" id="customerPackageName">Football Pro Box</h5>
                                            <span class="badge rounded-pill px-2 py-1" id="customerTierBadge"
                                                style="background:var(--gradient);font-size:.7rem;">Pro</span>
                                        </div>
                                        <p class="text-muted small mb-1"><i class="bi bi-calendar3 me-1"></i>Est.
                                            delivery: <strong id="customerDeliveryDate">Apr 28, 2026</strong></p>
                                        <p class="text-muted small mb-3"><i class="bi bi-upc-scan me-1"></i>Tracking:
                                            <span class="font-monospace text-primary"
                                                id="customerTrackingCode">SPX-789-XYZ</span>
                                        </p>
                                        <p class="small fw-semibold mb-2">Box Contents:</p>
                                        <div class="d-flex flex-wrap gap-2 mb-3" id="boxContents"></div>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="{{ route('customize') }}" class="btn btn-primary btn-sm px-3"><i
                                                    class="bi bi-pencil-square me-1"></i>Swap Items</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 rounded-3" style="background:#f8fafc;">
                                    <p class="small fw-semibold text-muted mb-3 text-uppercase"
                                        style="font-size:.75rem;letter-spacing:.05em;">Delivery Status</p>
                                    <div class="delivery-tracker" id="deliveryTracker">
                                        <div class="tracker-progress" id="trackerProgress"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 shadow-sm">
                            <div class="card-header border-0 py-3 px-4"
                                style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                                <h6 class="fw-bold mb-0"><i class="bi bi-clock-history text-primary me-2"></i>Order
                                    History</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="ps-4 py-3">Box</th>
                                                <th class="py-3">Date</th>
                                                <th class="py-3">Amount</th>
                                                <th class="py-3">Status</th>
                                                <th class="py-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="orderHistory"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 rounded-4 shadow-sm mb-4">
                            <div class="card-header border-0 py-3 px-4"
                                style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                                <h6 class="fw-bold mb-0"><i class="bi bi-lightning-charge text-primary me-2"></i>Quick
                                    Actions</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="quick-action-card" onclick="location.href='{{ route('customize') }}'">
                                            <div class="quick-action-icon"
                                                style="background:linear-gradient(135deg,rgba(16,185,129,.12),rgba(16,185,129,.06));">
                                                <i class="bi bi-box-seam" style="color:var(--primary);"></i>
                                            </div>
                                            <div class="small fw-semibold">Swap Items</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="quick-action-card" onclick="location.href='{{ route('subscriptions') }}'">
                                            <div class="quick-action-icon"
                                                style="background:linear-gradient(135deg,rgba(139,92,246,.12),rgba(139,92,246,.06));">
                                                <i class="bi bi-arrow-up-circle" style="color:#8b5cf6;"></i>
                                            </div>
                                            <div class="small fw-semibold">Change Plan</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="quick-action-card" onclick="location.href='{{ route('reward') }}'">
                                            <div class="quick-action-icon"
                                                style="background:linear-gradient(135deg,rgba(245,158,11,.12),rgba(245,158,11,.06));">
                                                <i class="bi bi-gift" style="color:#f59e0b;"></i>
                                            </div>
                                            <div class="small fw-semibold">Rewards</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="quick-action-card" onclick="location.href='{{ route('cart') }}'">
                                            <div class="quick-action-icon"
                                                style="background:linear-gradient(135deg,rgba(59,130,246,.12),rgba(59,130,246,.06));">
                                                <i class="bi bi-cart3" style="color:#2563eb;"></i>
                                            </div>
                                            <div class="small fw-semibold">Cart</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="quick-action-card" onclick="toggleSubscriptionState()">
                                            <div class="quick-action-icon"
                                                style="background:linear-gradient(135deg,rgba(239,68,68,.12),rgba(239,68,68,.06));">
                                                <i id="pauseResumeIcon" class="bi bi-pause-circle"
                                                    style="color:#ef4444;"></i>
                                            </div>
                                            <div id="pauseResumeLabel" class="small fw-semibold">Pause</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 shadow-sm mb-4">
                            <div class="card-header border-0 py-3 px-4"
                                style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                                <h6 class="fw-bold mb-0"><i class="bi bi-credit-card text-primary me-2"></i>My
                                    Subscription</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3 mb-3 p-3 rounded-3"
                                    style="background:var(--gradient);">
                                    <div class="flex-grow-1">
                                        <div class="text-white fw-bold fs-5" id="subscriptionTitle">Pro Plan</div>
                                        <div class="small" style="color:rgba(255,255,255,.75);"
                                            id="subscriptionPrice">$49 / month</div>
                                    </div>
                                    <i class="bi bi-star-fill text-warning fs-3"></i>
                                </div>
                                <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Next
                                        billing:</span><span class="fw-semibold" id="subscriptionBillingDate">May 1,
                                        2026</span></div>
                                <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Swaps
                                        remaining:</span><span class="fw-semibold text-primary">Unlimited</span></div>
                                <div class="d-flex justify-content-between small mb-3"><span class="text-muted">Member
                                        since:</span><span class="fw-semibold" id="subscriptionMemberSince">Aug
                                        2023</span></div>
                                <a href="{{ route('subscriptions') }}" class="btn btn-outline-primary w-100 btn-sm">Upgrade Plan</a>
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-trophy text-warning me-2"></i>Rewards
                                    </h6>
                                    <a href="{{ route('reward') }}" class="text-primary text-decoration-none small">View all</a>
                                </div>
                                <div class="text-center mb-3">
                                    <div class="display-6 fw-bold text-primary" id="customerPoints">0</div>
                                    <div class="text-muted small">Points earned</div>
                                </div>
                                <div class="d-flex justify-content-between small mb-2">
                                    <span class="text-muted">Progress to Gold</span>
                                    <span class="fw-semibold" id="pointsProgressLabel">0 / 2,000</span>
                                </div>
                                <div class="progress mb-3" style="height:8px;border-radius:4px;">
                                    <div class="progress-bar" id="pointsProgressBar"
                                        style="width:0;background:var(--gradient);border-radius:4px;"></div>
                                </div>
                                <a href="{{ route('reward') }}" class="btn btn-primary w-100 btn-sm">Redeem Points</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="adminDashboard" style="display:none;">
                <div class="row g-3 mb-4" id="adminStats"></div>
                <div class="row g-4">
                    <div class="col-xl-8">
                        <div class="surface-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-truck text-primary me-2"></i>Account Orders &
                                    Tracking</h5>
                                <span class="small text-muted">Live-ready structure for backend data</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Account</th>
                                            <th>Package</th>
                                            <th>Tracking</th>
                                            <th>Status</th>
                                            <th>Points</th>
                                            <th>Returned</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adminOrdersTable"></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="surface-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i
                                        class="bi bi-arrow-counterclockwise text-primary me-2"></i>Returned Orders</h5>
                                <span class="small text-muted">Customer return visibility for support follow-up</span>
                            </div>
                            <div id="returnedOrdersList" class="d-flex flex-column gap-3"></div>
                        </div>

                        <div class="surface-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-diagram-3 text-primary me-2"></i>Shipping
                                    Package Batching</h5>
                                <span class="small text-muted">Grouped batches from the shipping system</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Batch</th>
                                            <th>Region</th>
                                            <th>Orders</th>
                                            <th>Warehouse State</th>
                                        </tr>
                                    </thead>
                                    <tbody id="batchingTable"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="surface-card p-4 mb-4 upload-panel">
                            <h5 class="fw-bold mb-2"><i class="bi bi-cloud-upload text-primary me-2"></i>Upload Themes
                            </h5>
                            <p class="text-muted small mb-4">Admins can add next-month theme data here now, then
                                connect this form to a backend import later.</p>
                            <form onsubmit="handleThemeUpload(event)">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Theme Name</label>
                                    <input type="text" class="form-control" id="themeName"
                                        placeholder="May Gadget Drop" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Month</label>
                                    <input type="text" class="form-control" id="themeMonth"
                                        placeholder="June 2026" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Item Count</label>
                                    <input type="number" class="form-control" id="themeItems" min="1"
                                        placeholder="6" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Upload Theme</button>
                            </form>
                        </div>

                        <div class="surface-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i
                                        class="bi bi-exclamation-triangle text-warning me-2"></i>Stock Threshold</h5>
                                <span class="small text-muted">Low stock alerts</span>
                            </div>
                            <div id="stockThresholdList" class="d-flex flex-column gap-3"></div>
                        </div>

                        <div class="surface-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-palette text-primary me-2"></i>Theme Library
                                </h5>
                                <span class="small text-muted">Latest uploads</span>
                            </div>
                            <div id="themeLibrary" class="d-flex flex-column gap-3"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div class="modal fade" id="pauseModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Pause Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <div
                            style="width:70px;height:70px;background:rgba(245,158,11,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                            <i class="bi bi-pause-circle-fill text-warning fs-2"></i>
                        </div>
                        <p class="text-muted mb-0">How long would you like to pause?</p>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <button class="btn btn-outline-primary text-start px-4 py-3 rounded-3"
                            onclick="confirmPause(1)"><i class="bi bi-calendar me-2"></i>1 Month</button>
                        <button class="btn btn-outline-primary text-start px-4 py-3 rounded-3"
                            onclick="confirmPause(2)"><i class="bi bi-calendar me-2"></i>2 Months</button>
                        <button class="btn btn-outline-primary text-start px-4 py-3 rounded-3"
                            onclick="confirmPause(3)"><i class="bi bi-calendar me-2"></i>3 Months</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100">
        <div id="mainToast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toastMsg">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

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
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Contact</h6>
                    <p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com
                    </p>
                    <p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p>
                </div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">&copy; 2026 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/home/dashboard.js') }}"></script>
  
    
</body>

</html>

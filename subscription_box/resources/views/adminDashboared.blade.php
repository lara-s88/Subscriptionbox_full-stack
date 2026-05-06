<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SportBox</title>
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
                <div style="width:60px;height:60px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-shield-check fs-2 text-white"></i>
                </div>
                <div>
                    <p class="mb-0 small" style="opacity:.75;">Operations Admin</p>
                    <h3 class="mb-0 fw-bold">Admin Dashboard</h3>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="admin-pill">Admin account</span>
                <span class="admin-pill">Orders in view</span>
                <span class="admin-pill">Shipping batches</span>
            </div>
        </div>
    </div>

    <main class="py-5">
        <div class="container">
            <section id="adminDashboard">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card" style="border-left-color:var(--primary);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon" style="color:var(--primary);"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <div class="h4 fw-bold mb-0" style="color:var(--primary);">0</div>
                                    <div class="text-muted small">Customer Accounts</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card" style="border-left-color:#ef4444;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon" style="color:#ef4444;"><i class="bi bi-arrow-counterclockwise"></i></div>
                                <div>
                                    <div class="h4 fw-bold mb-0" style="color:#ef4444;">0</div>
                                    <div class="text-muted small">Returned Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card" style="border-left-color:#f59e0b;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon" style="color:#f59e0b;"><i class="bi bi-exclamation-triangle-fill"></i></div>
                                <div>
                                    <div class="h4 fw-bold mb-0" style="color:#f59e0b;">0</div>
                                    <div class="text-muted small">Low Stock Alerts</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card" style="border-left-color:#3b82f6;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon" style="color:#3b82f6;"><i class="bi bi-diagram-3-fill"></i></div>
                                <div>
                                    <div class="h4 fw-bold mb-0" style="color:#3b82f6;">0</div>
                                    <div class="text-muted small">Shipping Batches</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-8">
                        <div class="surface-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-truck text-primary me-2"></i>Account Orders &amp; Tracking</h5>
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
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">Account name</div>
                                                <div class="small text-muted">email@example.com</div>
                                            </td>
                                            <td>Package name</td>
                                            <td><span class="font-monospace text-primary">Tracking code</span></td>
                                            <td><span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">Status</span></td>
                                            <td>0</td>
                                            <td><span class="badge rounded-pill px-3" style="background:rgba(59,130,246,.12);color:#2563eb;">No return</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="surface-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-arrow-counterclockwise text-primary me-2"></i>Returned Orders</h5>
                                <span class="small text-muted">Customer return visibility for support follow-up</span>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold">Account name - Package name</div>
                                            <div class="small text-muted">Order ID - Tracking code</div>
                                        </div>
                                        <span class="badge rounded-pill px-3" style="background:rgba(239,68,68,.12);color:#dc2626;">Returned</span>
                                    </div>
                                    <div class="small text-muted mt-2">Reason: return reason goes here.</div>
                                </div>
                            </div>
                        </div>

                        <div class="surface-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-diagram-3 text-primary me-2"></i>Shipping Package Batching</h5>
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
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">Batch ID</td>
                                            <td>Region</td>
                                            <td>0</td>
                                            <td><span class="badge rounded-pill px-3" style="background:rgba(59,130,246,.12);color:#2563eb;">Warehouse state</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="surface-card p-4 mb-4 upload-panel">
                            <h5 class="fw-bold mb-2"><i class="bi bi-cloud-upload text-primary me-2"></i>Upload Themes</h5>
                            <p class="text-muted small mb-4">Admins can add next-month theme data here now, then connect this form to a backend import later.</p>
                            <form method="POST" action="#">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Theme Name</label>
                                    <input type="text" class="form-control" name="theme_name" placeholder="May Gadget Drop">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Month</label>
                                    <input type="text" class="form-control" name="theme_month" placeholder="June 2026">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Item Count</label>
                                    <input type="number" class="form-control" name="theme_items" min="1" placeholder="6">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Upload Theme</button>
                            </form>
                        </div>

                        <div class="surface-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Stock Threshold</h5>
                                <span class="small text-muted">Low stock alerts</span>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold">Inventory item</div>
                                            <div class="small text-muted">Theme name</div>
                                        </div>
                                        <span class="badge rounded-pill px-3" style="background:rgba(245,158,11,.15);color:#b45309;">0 in stock</span>
                                    </div>
                                    <div class="small text-muted mt-2">Threshold: 0</div>
                                </div>
                            </div>
                        </div>

                        <div class="surface-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-palette text-primary me-2"></i>Theme Library</h5>
                                <span class="small text-muted">Latest uploads</span>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold">Theme name</div>
                                            <div class="small text-muted">Month</div>
                                        </div>
                                        <span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">Status</span>
                                    </div>
                                    <div class="small text-muted mt-2">0 items</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100">
        <div id="mainToast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toastMsg">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
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

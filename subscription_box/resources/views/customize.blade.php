<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Box - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customize.css') }}">
    
</head>
<body>
    <!-- Navbar -->
    <x-navbar activePage="customize"></x-navbar>

    <!-- Header -->
    <div class="hero-section-sm">
        <div class="container position-relative">
            <div class="d-flex gap-2 flex-wrap mb-3">
                <a href="{{ route('boxes') }}" class="btn btn-sm btn-outline-light px-3"><i class="bi bi-arrow-left me-1"></i>Back to Boxes</a>
                <a href="{{ route('cart') }}" class="btn btn-sm btn-light px-3"><i class="bi bi-cart3 me-1"></i>View Cart</a>
            </div>
            <h1 class="display-6 fw-bold mb-1" id="boxTitle">Customize Your Box</h1>
            <p class="lead mb-0" style="opacity:.85;" id="boxSubtitle">Swap, remove, or add items to match your preferences</p>
        </div>
    </div>

    <!-- Content -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Left: Items -->
                <div class="col-lg-7">
                    <!-- Current Items -->
                    <div class="card border-0 rounded-4 shadow-sm mb-4">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0"><i class="bi bi-box-seam text-primary me-2"></i>Box Items</h6>
                                <span class="badge rounded-pill" style="background:var(--gradient);" id="itemCount">0 items</span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3">Drag to reorder, or remove items you don't want.</p>
                            <div class="d-flex flex-column gap-2" id="itemsList"></div>
                        </div>
                    </div>

                    <!-- Add Items -->
                    <div class="card border-0 rounded-4 shadow-sm mb-4">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                            <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle text-primary me-2"></i>Add More Items</h6>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3">Click any item below to add it to your box.</p>
                            <div class="d-flex flex-wrap gap-2" id="availableItems"></div>
                        </div>
                    </div>

                    <!-- Preferences -->
                    <div class="card border-0 rounded-4 shadow-sm">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                            <h6 class="fw-bold mb-0"><i class="bi bi-sliders text-primary me-2"></i>Preferences</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="fw-semibold small mb-3 d-block">Clothing Size</label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="size-btn" onclick="selectSize(this)">XS</button>
                                        <button class="size-btn" onclick="selectSize(this)">S</button>
                                        <button class="size-btn active" onclick="selectSize(this)">M</button>
                                        <button class="size-btn" onclick="selectSize(this)">L</button>
                                        <button class="size-btn" onclick="selectSize(this)">XL</button>
                                        <button class="size-btn" onclick="selectSize(this)">XXL</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold small mb-3 d-block">Diet Preference</label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="pref-btn active" onclick="selectPref('diet', this)">Standard</button>
                                        <button class="pref-btn" onclick="selectPref('diet', this)">Keto</button>
                                        <button class="pref-btn" onclick="selectPref('diet', this)">Vegan</button>
                                        <button class="pref-btn" onclick="selectPref('diet', this)">High Protein</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold small mb-3 d-block">Skill Level</label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="pref-btn" onclick="selectPref('skill', this)">Beginner</button>
                                        <button class="pref-btn active" onclick="selectPref('skill', this)">Intermediate</button>
                                        <button class="pref-btn" onclick="selectPref('skill', this)">Pro</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="fw-semibold small mb-3 d-block">Delivery Frequency</label>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="pref-btn active" onclick="selectPref('freq', this)">Monthly</button>
                                        <button class="pref-btn" onclick="selectPref('freq', this)">Bi-Monthly</button>
                                        <button class="pref-btn" onclick="selectPref('freq', this)">Quarterly</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary -->
                <div class="col-lg-5">
                    <div class="summary-card">
                        <div class="mb-3">
                            <div class="overflow-hidden rounded-3 mb-3" style="height:160px;">
                                <img id="summaryImg" src="https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800" alt="Box" class="w-100 h-100" style="object-fit:cover;">
                            </div>
                            <h5 class="fw-bold mb-1" id="summaryTitle">Football Clothing Box</h5>
                            <p class="text-muted small" id="summaryType">Clothing Box</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Items in box:</span>
                                <span class="fw-semibold small" id="summaryCount">4 items</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Clothing size:</span>
                                <span class="fw-semibold small" id="summarySize">M</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Diet preference:</span>
                                <span class="fw-semibold small" id="summaryDiet">Standard</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Delivery:</span>
                                <span class="fw-semibold small" id="summaryFreq">Monthly</span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary fs-4" id="summaryPrice">$49.99</span>
                        </div>

                        <!-- Swaps indicator -->
                        <div class="p-3 rounded-3 mb-4" style="background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.15);">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-arrow-repeat text-primary"></i>
                                <span class="small fw-semibold">Swaps Used</span>
                            </div>
                            <div class="progress mb-1" style="height:6px;border-radius:3px;">
                                <div class="progress-bar" id="swapBar" style="width:40%;background:var(--gradient);border-radius:3px;"></div>
                            </div>
                            <div class="small text-muted" id="swapText">2 of 5 swaps used (Pro plan: unlimited)</div>
                        </div>

                        <button class="btn btn-primary w-100 py-3 fw-semibold mb-2" onclick="confirmSelection()">
                            <i class="bi bi-cart-check me-2"></i>Save to Cart
                        </button>
                        <a href="{{ route('boxes') }}" class="btn btn-outline-secondary w-100 py-2">
                            <i class="bi bi-arrow-left me-1"></i>Back to Boxes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-body p-5 text-center">
                    <div style="width:80px;height:80px;background:linear-gradient(135deg,rgba(16,185,129,.12),rgba(16,185,129,.06));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                        <i class="bi bi-check-circle-fill text-primary" style="font-size:2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Box Customized! 🎉</h4>
                    <p class="text-muted mb-4">Your selections are saved in the cart. Review everything there and confirm shipping when ready.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('cart') }}" class="btn btn-primary px-4"><i class="bi bi-cart3 me-1"></i>View Cart</a>
                        <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Continue Editing</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Quick Links</h6><ul class="footer-links"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('sports') }}">Sports</a></li><li><a href="{{ route('subscriptions') }}">Subscriptions</a></li></ul></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Account</h6><ul class="footer-links"><li><a href="{{ route('dashboard') }}">Dashboard</a></li><li><a href="{{ route('login') }}" id="footerAuthLink">Login</a></li></ul></div>
                <div class="col-lg-4"><h6 class="fw-bold mb-3">Contact</h6><p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com</p><p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p></div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">© 2024 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
     <script src="{{ asset('assets/js/home/customize.js') }}"></script>
</body>
</html>

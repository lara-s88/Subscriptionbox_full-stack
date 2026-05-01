<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxes - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    
</head>
<body>
    <!-- Navbar -->
  <x-navbar activePage="boxes"></x-navbar>

    <!-- Mini Hero -->
    <div class="hero-section-sm">
        <div class="container position-relative">
            <a href="sports.html" class="btn btn-sm btn-outline-light px-3 mb-3"><i class="bi bi-arrow-left me-1"></i>All Sports</a>
            <h1 class="display-5 fw-bold mb-2" id="sportTitle">Football Boxes</h1>
            <p class="lead mb-0" style="opacity:.88;" id="sportDesc">Premium curated boxes for football enthusiasts</p>
        </div>
    </div>

    <!-- Content -->
    <section class="py-5">
        <div class="container">
            <!-- Filters Row -->
            <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                <!-- Type Filter -->
                <div class="filter-tabs-wrap" id="typeFilters">
                    <button class="filter-tab active" data-type="all" onclick="filterType('all', this)">All</button>
                    <button class="filter-tab" data-type="clothing" onclick="filterType('clothing', this)">👕 Clothing</button>
                    <button class="filter-tab" data-type="equipment" onclick="filterType('equipment', this)">🏋️ Equipment</button>
                    <button class="filter-tab" data-type="diet" onclick="filterType('diet', this)">🥗 Diet</button>
                </div>
                <!-- Price Filter -->
                <div class="d-flex gap-2 flex-wrap" id="priceFilters">
                    <button class="price-filter-btn active" data-price="all" onclick="filterPrice('all', this)">All Prices</button>
                    <button class="price-filter-btn" data-price="under40" onclick="filterPrice('under40', this)">Under $40</button>
                    <button class="price-filter-btn" data-price="40to60" onclick="filterPrice('40to60', this)">$40–$60</button>
                    <button class="price-filter-btn" data-price="over60" onclick="filterPrice('over60', this)">$60+</button>
                </div>
                <!-- Search -->
                <div class="search-bar-wrap ms-auto" style="min-width:220px;">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" placeholder="Search boxes..." id="searchInput" oninput="searchBoxes()">
                </div>
                <a href="cart.html" class="btn btn-outline-primary">
                    <i class="bi bi-cart3 me-1"></i>View Cart
                </a>
            </div>

            <!-- Results count -->
            <p class="text-muted small mb-4" id="resultsCount"></p>

            <!-- Skeleton (shown during load) -->
            <div class="row g-4" id="skeletonGrid"></div>

            <!-- Box Grid -->
            <div class="row g-4" id="boxGrid" style="display:none;"></div>

            <!-- Empty State -->
            <div id="emptyState" style="display:none;" class="text-center py-5">
                <i class="bi bi-box2 display-3 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No boxes found</h5>
                <p class="text-muted small">Try adjusting your filters or search query</p>
                <button class="btn btn-outline-primary" onclick="resetFilters()">Reset Filters</button>
            </div>
        </div>
    </section>

    <!-- Box Modal -->
    <div class="modal fade" id="boxModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <img id="modalImg" src="" alt="" class="w-100 rounded-3 shadow-sm" style="height:240px;object-fit:cover;">
                        </div>
                        <div class="col-md-7">
                            <div class="d-flex align-items-start gap-2 mb-1">
                                <h4 class="fw-bold mb-0" id="modalTitle">Box Title</h4>
                            </div>
                            <div class="price-badge mb-3" id="modalPrice" style="display:inline-block;">$49.99</div>
                            <p class="text-muted small mb-3" id="modalDesc"></p>
                            <p class="fw-semibold small mb-2">What's inside:</p>
                            <div class="d-flex flex-wrap gap-2 mb-4" id="modalItems"></div>
                            <div class="d-flex gap-2">
                                <a href="customize.html" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i>Customize Box</a>
                                <button class="btn btn-outline-primary" onclick="addToCart()"><i class="bi bi-cart-plus me-1"></i>Add to Cart</button>
                            </div>
                        </div>
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
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4"><h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5><p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p><div class="social-links d-flex gap-2"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-twitter-x"></i></a><a href="#"><i class="bi bi-youtube"></i></a></div></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Quick Links</h6><ul class="footer-links"><li><a href="{{ route('welcome') }}">Home</a></li><li><a href="{{ route('sports') }}">Sports</a></li><li><a href="{{ route('subscription') }}">Subscriptions</a></li></ul></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Account</h6><ul class="footer-links"><li><a href="{{ route('dsahboard') }}">Dashboard</a></li><li><a href="{{ route('login') }}" id="footerAuthLink">Login</a></li></ul></div>
                <div class="col-lg-4"><h6 class="fw-bold mb-3">Contact</h6><p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com</p><p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p></div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">© 2024 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/home/boxes.js') }}"></script>
</body>
</html>

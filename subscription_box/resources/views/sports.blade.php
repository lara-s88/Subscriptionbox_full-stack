<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports - SportBox</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Shared Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sports.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

   
</head>

<body>

    <x-navbar activePage="sports"></x-navbar>

    <!-- ===== Hero Section ===== -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-4">Explore All Sports</h1>
                    <p class="lead mb-4" style="opacity:.92;">
                        Discover premium boxes tailored for your favourite sport.
                        Customize your gear and get it delivered monthly.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="#sports-section" class="btn btn-light btn-lg fw-semibold px-4"
                            style="color:var(--primary-dark);">
                            <i class="bi bi-grid me-2"></i>Browse Sports
                        </a>
                        <a href="{{ route('subscriptions') }}" class="btn btn-outline-light btn-lg px-4">View Plans</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Sports / Boxes Grid ===== -->
    <section id="sports-section" class="py-5">
        <div class="container">

            <!-- Filter Tabs -->
            <div class="text-center mb-4">
                <div class="filter-tabs-wrap" id="filterTabsWrap">
                    <button class="filter-tab active" data-sport="all" type="button">
                        <i class="bi bi-grid me-1"></i>All Sports
                    </button>
                    <a class="filter-tab text-decoration-none" href="{{ route('boxes') }}?sport=football">Football</a>
                    <a class="filter-tab text-decoration-none" href="{{ route('boxes') }}?sport=basketball">Basketball</a>
                    <a class="filter-tab text-decoration-none" href="{{ route('boxes') }}?sport=gym">Gym/Fitness</a>
                    <a class="filter-tab text-decoration-none" href="{{ route('boxes') }}?sport=tennis">Tennis</a>
                </div>
            </div>

            <!-- Search -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="search-bar-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control" placeholder="Search sports or boxes…"
                            id="searchInput">
                    </div>
                </div>
            </div>

            <!-- Dynamic section header -->
            <div class="mb-4" id="sectionHeader">
                <h4 class="fw-bold mb-1">All Sports</h4>
                <p class="text-muted small mb-0">Sports loaded from the backend will appear in these cards.</p>
            </div>

            <!-- Skeleton (shown briefly on load) -->
            <div class="row g-4" id="skeletonGrid"></div>

            <!-- Main grid -->
            <div class="row g-4" id="sports-grid">
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=football" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/274422/pexels-photo-274422.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Football" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-dribbble text-primary fs-5"></i>
                                <h5 class="card-title fw-bold mb-0">Football</h5>
                            </div>
                            <p class="card-text text-muted small mb-3">Backend description goes here.</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted small">Boxes</span>
                                <span class="text-primary fw-semibold small">Browse <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=basketball" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/1752757/pexels-photo-1752757.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Basketball" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-basket3-fill text-primary fs-5"></i>
                                <h5 class="card-title fw-bold mb-0">Basketball</h5>
                            </div>
                            <p class="card-text text-muted small mb-3">Backend description goes here.</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted small">Boxes</span>
                                <span class="text-primary fw-semibold small">Browse <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=gym" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Gym/Fitness" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-heart-pulse-fill text-primary fs-5"></i>
                                <h5 class="card-title fw-bold mb-0">Gym/Fitness</h5>
                            </div>
                            <p class="card-text text-muted small mb-3">Backend description goes here.</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted small">Boxes</span>
                                <span class="text-primary fw-semibold small">Browse <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=tennis" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/209977/pexels-photo-209977.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Tennis" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-trophy-fill text-primary fs-5"></i>
                                <h5 class="card-title fw-bold mb-0">Tennis</h5>
                            </div>
                            <p class="card-text text-muted small mb-3">Backend description goes here.</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted small">Boxes</span>
                                <span class="text-primary fw-semibold small">Browse <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Empty state -->
            <div id="emptyState" style="display:none;" class="text-center py-5">
                <i class="bi bi-search display-3 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No results found</h5>
                <p class="text-muted small">Try a different search term or browse all sports</p>
                <a class="btn btn-outline-primary" href="{{ route('sports') }}">Browse All Sports</a>
            </div>

        </div>
    </section>

    <!-- ===== Box Detail Modal ===== -->
    <div class="modal fade" id="boxModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Box Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <img id="modalImage" src="" alt="" class="w-100 rounded-3 shadow-sm"
                                style="height:240px;object-fit:cover;">
                        </div>
                        <div class="col-md-7">
                            <h4 class="fw-bold mb-1" id="modalBoxTitle"></h4>
                            <div class="h4 fw-bold text-primary mb-3" id="modalPrice"></div>
                            <div class="mb-4" id="modalItems"></div>
                            <div class="d-flex gap-2">
                                <a id="customizeBtn" href="{{ route('customize') }}" class="btn btn-primary">
                                    <i class="bi bi-pencil-square me-1"></i>Customize Box
                                </a>
                                <button class="btn btn-outline-primary" type="button">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
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
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- ===== Footer ===== -->
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
                        <li id="footerRewardItem"><a href="{{ route('reward') }}">Rewards</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Account</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('login') }}" id="footerAuthLink">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Contact</h6>
                    <p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com
                    </p>
                    <p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p>
                    <p style="font-size:.9rem;"><i class="bi bi-geo-alt me-2 text-primary"></i>123 Sport Lane, NY
                        10001</p>
                </div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">© 2024 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

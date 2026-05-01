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

 <!-- Mock Data -->
    <script>
        const mockData = {
            sports: [{
                    id: 1,
                    name: 'Football',
                    icon: 'bi-dribbble',
                    image: 'https://images.pexels.com/photos/274422/pexels-photo-274422.jpeg?auto=compress&cs=tinysrgb&w=800',
                    description: 'Gear up for the game with authentic jerseys, balls, and training equipment.',
                    boxes: [{
                            id: 1,
                            title: 'Football Clothing Box',
                            price: '$49.99',
                            image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'clothing',
                            items: ['Jersey (S-XXL)', 'Training Shorts', 'Socks', 'Cap']
                        },
                        {
                            id: 2,
                            title: 'Equipment Essentials',
                            price: '$69.99',
                            image: 'https://images.pexels.com/photos/46798/the-ball-stadion-football-the-pitch-46798.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'equipment',
                            items: ['Soccer Ball', 'Shin Guards', 'Training Cones', 'Water Bottle']
                        },
                        {
                            id: 3,
                            title: 'Diet & Recovery',
                            price: '$39.99',
                            image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'diet',
                            items: ['Protein Powder', 'Energy Bars', 'Recovery Drink', 'Vitamin Pack']
                        }
                    ]
                },
                {
                    id: 2,
                    name: 'Basketball',
                    icon: 'bi-basket3-fill',
                    image: 'https://images.pexels.com/photos/1752757/pexels-photo-1752757.jpeg?auto=compress&cs=tinysrgb&w=800',
                    description: 'Dribble in style with premium basketballs, sneakers, and apparel.',
                    boxes: [{
                            id: 4,
                            title: 'Basketball Gear Pack',
                            price: '$59.99',
                            image: 'https://images.pexels.com/photos/1752757/pexels-photo-1752757.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'equipment',
                            items: ['Basketball', 'Knee Pads', 'Grip Tape', 'Pump']
                        },
                        {
                            id: 5,
                            title: 'Performance Apparel',
                            price: '$44.99',
                            image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'clothing',
                            items: ['Shooting Shirt', 'Basketball Shorts', 'Ankle Socks', 'Headband']
                        },
                        {
                            id: 6,
                            title: 'Nutrition Starter',
                            price: '$34.99',
                            image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'diet',
                            items: ['Whey Protein', 'Pre-Workout', 'BCAA Drink', 'Electrolytes']
                        }
                    ]
                },
                {
                    id: 3,
                    name: 'Gym/Fitness',
                    icon: 'bi-heart-pulse-fill',
                    image: 'https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=800',
                    description: 'Build strength with resistance bands, supplements, and workout gear.',
                    boxes: [{
                            id: 7,
                            title: 'Strength Training Kit',
                            price: '$54.99',
                            image: 'https://images.pexels.com/photos/416717/pexels-photo-416717.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'equipment',
                            items: ['Resistance Bands', 'Jump Rope', 'Gloves', 'Chalk']
                        },
                        {
                            id: 8,
                            title: 'Workout Apparel',
                            price: '$39.99',
                            image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'clothing',
                            items: ['Gym Tank', 'Leggings', 'Sports Bra', 'Compression Sleeves']
                        },
                        {
                            id: 9,
                            title: 'Muscle Builder Pack',
                            price: '$49.99',
                            image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'diet',
                            items: ['Creatine', 'Mass Gainer', 'BCAAs', 'Test Booster']
                        }
                    ]
                },
                {
                    id: 4,
                    name: 'Tennis',
                    icon: 'bi-trophy-fill',
                    image: 'https://images.pexels.com/photos/209977/pexels-photo-209977.jpeg?auto=compress&cs=tinysrgb&w=800',
                    description: 'Ace your game with rackets, balls, grips, and performance wear.',
                    boxes: [{
                            id: 10,
                            title: 'Tennis Pro Kit',
                            price: '$64.99',
                            image: 'https://images.pexels.com/photos/209977/pexels-photo-209977.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'equipment',
                            items: ['Tennis Racket', 'Pressure Balls', 'Overgrip', 'Vibration Dampener']
                        },
                        {
                            id: 11,
                            title: 'Court Apparel',
                            price: '$42.99',
                            image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'clothing',
                            items: ['Polo Shirt', 'Tennis Shorts', 'Wristbands', 'Visor']
                        },
                        {
                            id: 12,
                            title: 'Endurance Fuel',
                            price: '$37.99',
                            image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=600',
                            type: 'diet',
                            items: ['Electrolyte Tabs', 'Energy Gels', 'Recovery Shake', 'Magnesium']
                        }
                    ]
                }
            ]
        };

        /* Build a flat box lookup for the modal */
        const boxLookup = {};
        mockData.sports.forEach(s => s.boxes.forEach(b => {
            boxLookup[b.id] = {
                ...b,
                sportName: s.name
            };
        }));
    </script>
   

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
                        <a href="plans.html" class="btn btn-outline-light btn-lg px-4">View Plans</a>
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
                    <button class="filter-tab active" data-sport="all" onclick="filterSport('all', this)">
                        <i class="bi bi-grid me-1"></i>All Sports
                    </button>
                    <!-- Sport tabs injected by JS -->
                </div>
            </div>

            <!-- Search -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="search-bar-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" class="form-control" placeholder="Search sports or boxes…"
                            id="searchInput" oninput="handleSearch()">
                    </div>
                </div>
            </div>

            <!-- Dynamic section header -->
            <div class="mb-4" id="sectionHeader"></div>

            <!-- Skeleton (shown briefly on load) -->
            <div class="row g-4" id="skeletonGrid"></div>

            <!-- Main grid -->
            <div class="row g-4" id="sports-grid" style="display:none;"></div>

            <!-- Empty state -->
            <div id="emptyState" style="display:none;" class="text-center py-5">
                <i class="bi bi-search display-3 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No results found</h5>
                <p class="text-muted small">Try a different search term or browse all sports</p>
                <button class="btn btn-outline-primary"
                    onclick="filterSport('all', document.querySelector('[data-sport=all]'))">Browse All Sports</button>
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
                                <a id="customizeBtn" href="customize.html" class="btn btn-primary">
                                    <i class="bi bi-pencil-square me-1"></i>Customize Box
                                </a>
                                <button class="btn btn-outline-primary" onclick="addToCart()">
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
                        <li><a href="{{ route('login') }}">Register</a></li>
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
    <script src="{{ asset('assets/js/home/sports.js') }}"></script>
</body>

</html>

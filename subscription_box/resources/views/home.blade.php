<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportBox - Your Sport. Your Box. Delivered.</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Shared Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    {{-- Page-specific Styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/home/index.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

</head>

<body>

    <x-navbar activePage="home"></x-navbar>

    <!-- ===== Hero Section ===== -->
    <section id="home" class="main-hero">
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge rounded-pill px-3 py-2 mb-3 d-inline-block"
                        style="background:rgba(255,255,255,.18);font-size:.85rem;">🏆 Premium Sports Subscription
                        Boxes</span>
                    <h1 class="display-4 fw-bold mb-4">Your Sport.<br>Your Box.<br>Delivered.</h1>
                    <p class="lead mb-4" style="opacity:.92;">
                        Discover premium sports gear, apparel, and nutrition tailored to your passion.
                        Customize your box and get it delivered monthly.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                        <a href="#sports" class="btn btn-light btn-lg fw-semibold px-4"
                            style="color:var(--primary-dark);">
                            <i class="bi bi-grid me-2"></i>Explore Sports
                        </a>
                        <a href="{{ route('subscriptions') }}" class="btn btn-outline-light btn-lg px-4">View Plans</a>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="trust-tag"><i class="bi bi-star-fill text-warning"></i>4.9 Rating</div>
                        <div class="trust-tag"><i class="bi bi-people-fill"></i>10K+ Athletes</div>
                        <div class="trust-tag"><i class="bi bi-shield-check-fill"></i>30-Day Guarantee</div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://images.pexels.com/photos/2468339/pexels-photo-2468339.jpeg?auto=compress&cs=tinysrgb&w=1200"
                        alt="Sports Box" class="img-fluid rounded-4 d-block ms-lg-auto"
                        style="width:100%;max-width:640px;height:500px;object-fit:cover;object-position:center center;opacity:0.9;box-shadow:0 35px 80px rgba(15,23,42,0.28), 0 0 80px rgba(255,255,255,0.18);filter:saturate(0.95);">
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Featured Sports ===== -->
    <section id="sports" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Choose Your Sport</h2>
                <p class="lead text-muted">Find boxes perfect for your favorite sport</p>
            </div>
            <div class="row g-4" id="sports-grid">
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=football" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/274422/pexels-photo-274422.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Football" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-2">Football</h5>
                            <p class="card-text text-muted small mb-0">Backend description goes here.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=basketball" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/1752757/pexels-photo-1752757.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Basketball" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-2">Basketball</h5>
                            <p class="card-text text-muted small mb-0">Backend description goes here.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=gym" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Gym/Fitness" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-2">Gym/Fitness</h5>
                            <p class="card-text text-muted small mb-0">Backend description goes here.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-3">
                    <a href="{{ route('boxes') }}?sport=tennis" class="sport-card h-100 text-decoration-none text-body d-block">
                        <img src="https://images.pexels.com/photos/209977/pexels-photo-209977.jpeg?auto=compress&cs=tinysrgb&w=800" class="card-img-top" alt="Tennis" style="height:200px;object-fit:cover;">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-2">Tennis</h5>
                            <p class="card-text text-muted small mb-0">Backend description goes here.</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('sports') }}" class="btn btn-outline-primary px-4">
                    View All Sports &amp; Boxes <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== How It Works ===== -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">How It Works</h2>
                <p class="lead text-muted">Simple 3-step process to get your perfect sports box</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="text-center p-4">
                        <div class="step-icon">
                            <i class="bi bi-1-circle-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Pick Your Sport</h4>
                        <p class="text-muted">Choose from our curated sports categories. Football, Basketball, Tennis,
                            Gym, and more.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center p-4">
                        <div class="step-icon">
                            <i class="bi bi-2-circle-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Customize Your Box</h4>
                        <p class="text-muted">Swap items, set your size, and pick your diet preferences before every
                            shipment.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="text-center p-4">
                        <div class="step-icon">
                            <i class="bi bi-3-circle-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Get It Delivered</h4>
                        <p class="text-muted">Your personalized sports box arrives at your door every month, ready to
                            use.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Subscription Plans ===== -->
    <section id="plans" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Choose Your Plan</h2>
                <p class="lead text-muted">Flexible subscription tiers for every athlete</p>
            </div>
            <div class="row g-4 justify-content-center align-items-stretch">
                <!-- Basic -->
                <div class="col-lg-4 col-md-8">
                    <div class="plan-card">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div
                                    style="width:42px;height:42px;border-radius:10px;background:rgba(16,185,129,.1);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-box text-primary fs-5"></i>
                                </div>
                                <h3 class="fw-bold mb-0">Basic</h3>
                            </div>
                            <p class="text-muted small mb-0">Perfect for getting started</p>
                        </div>
                        <div class="mb-4">
                            <span class="display-5 fw-bold text-primary">$29</span><span
                                class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>1 Box per
                                    month</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>3 Item
                                    swaps</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Standard
                                    shipping</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Community
                                    access</span></li>
                            <li class="mb-3 d-flex gap-2"><i class="bi bi-x-circle-fill flex-shrink-0 mt-1"
                                    style="color:#d1d5db;"></i><span class="text-muted">Early access</span></li>
                            <li class="d-flex gap-2"><i class="bi bi-x-circle-fill flex-shrink-0 mt-1"
                                    style="color:#d1d5db;"></i><span class="text-muted">Free express shipping</span>
                            </li>
                        </ul>
                        <a href="{{ route('subscriptions') }}" class="btn btn-outline-primary w-100 py-3 fw-semibold">Get Started —
                            Basic</a>
                    </div>
                </div>

                <!-- Pro -->
                <div class="col-lg-4 col-md-8">
                    <div class="plan-card popular">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge px-3 py-2 rounded-pill" style="background:var(--gradient);">⭐ Most
                                Popular</span>
                        </div>
                        <div class="mb-4 mt-2">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div
                                    style="width:42px;height:42px;border-radius:10px;background:var(--gradient);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-star-fill text-white fs-5"></i>
                                </div>
                                <h3 class="fw-bold mb-0">Pro</h3>
                            </div>
                            <p class="text-muted small mb-0">For the dedicated athlete</p>
                        </div>
                        <div class="mb-4">
                            <span class="display-5 fw-bold text-primary">$49</span><span
                                class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>2 Boxes
                                    per month</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span><strong>Unlimited</strong>
                                    item swaps</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Free
                                    express shipping</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Community
                                    access</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Early
                                    access to new items</span></li>
                            <li class="d-flex gap-2"><i class="bi bi-x-circle-fill flex-shrink-0 mt-1"
                                    style="color:#d1d5db;"></i><span class="text-muted">VIP events</span></li>
                        </ul>
                        <a href="{{ route('subscriptions') }}" class="btn btn-primary w-100 py-3 fw-semibold">Get Started — Pro</a>
                    </div>
                </div>

                <!-- VIP -->
                <div class="col-lg-4 col-md-8">
                    <div class="plan-card">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div
                                    style="width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,rgba(245,158,11,.15),rgba(245,158,11,.07));display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-gem fs-5" style="color:#f59e0b;"></i>
                                </div>
                                <h3 class="fw-bold mb-0">VIP</h3>
                            </div>
                            <p class="text-muted small mb-0">The ultimate sports experience</p>
                        </div>
                        <div class="mb-4">
                            <span class="display-5 fw-bold text-primary">$89</span><span
                                class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span><strong>3</strong>
                                    Boxes per month</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Unlimited
                                    item swaps</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Free
                                    express shipping</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Community
                                    access</span></li>
                            <li class="mb-3 d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>Dedicated
                                    account manager</span></li>
                            <li class="d-flex gap-2"><i
                                    class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>VIP
                                    events &amp; challenges</span></li>
                        </ul>
                        <a href="{{ route('subscriptions') }}" class="btn btn-outline-primary w-100 py-3 fw-semibold">Get Started —
                            VIP</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('subscriptions') }}" class="btn btn-outline-primary px-4">
                    Compare All Plans <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== Testimonials ===== -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">What Athletes Say</h2>
                <p class="lead text-muted">Loved by thousands of sports enthusiasts worldwide</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i>
                        </div>
                        <p class="text-muted mb-4">"SportBox completely changed my football training. The quality of
                            gear is outstanding and the customization feature is brilliant!"</p>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/44?u=marcus" alt="Marcus T."
                                class="rounded-circle flex-shrink-0" width="44" height="44">
                            <div>
                                <div class="fw-semibold small">Marcus T.</div>
                                <div class="text-muted" style="font-size:.8rem;">Football Player · Pro Plan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i>
                        </div>
                        <p class="text-muted mb-4">"I love getting my monthly gym box. The protein supplements and
                            workout gear are top-notch. Definitely worth every penny!"</p>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/44?u=priya" alt="Priya K."
                                class="rounded-circle flex-shrink-0" width="44" height="44">
                            <div>
                                <div class="fw-semibold small">Priya K.</div>
                                <div class="text-muted" style="font-size:.8rem;">Gym Enthusiast · Basic Plan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-fill text-warning ms-1"></i><i
                                class="bi bi-star-half text-warning ms-1"></i>
                        </div>
                        <p class="text-muted mb-4">"The tennis box had everything I needed for the season. Loved the
                            referral rewards too — scored a free month through my code!"</p>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://i.pravatar.cc/44?u=james" alt="James R."
                                class="rounded-circle flex-shrink-0" width="44" height="44">
                            <div>
                                <div class="fw-semibold small">James R.</div>
                                <div class="text-muted" style="font-size:.8rem;">Tennis Player · VIP Plan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA Section ===== -->
    <section class="py-5">
        <div class="container">
            <div class="p-5 rounded-4 text-center text-white" style="background:var(--gradient);">
                <h2 class="display-5 fw-bold mb-3">Ready to Level Up Your Game?</h2>
                <p class="lead mb-4" style="opacity:.9;">Join over 10,000 athletes getting premium gear delivered
                    every month.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg fw-semibold px-4"
                        style="color:var(--primary-dark);">
                        <i class="bi bi-person-plus me-2"></i>Get Started Free
                    </a>
                    <a href="{{ route('subscriptions') }}" class="btn btn-outline-light btn-lg px-4">View Plans</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Footer ===== -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5>
                    <p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered. Premium sports gear
                        tailored to your passion.</p>
                    <div class="social-icons d-flex gap-2">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="footer-list">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('sports') }}">Sports</a></li>
                        <li><a href="{{ route('subscriptions') }}">Subscriptions</a></li>
                        <li id="footer-reward-link"><a href="{{ route('reward') }}">Rewards</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Account</h6>
                    <ul class="footer-list">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('login') }}" id="footer-login-link">Login</a></li>
                        <li id="footerRegisterItem"><a href="{{ route('register') }}">Register</a></li>
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

    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100">
        <div id="msg-toast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toast-text">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
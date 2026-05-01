<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">

</head>
<body>

   <x-navbar activePage="cart"></x-navbar>

    <div class="hero-section-sm">
        <div class="container position-relative">
            <h1 class="display-6 fw-bold mb-2"><i class="bi bi-cart3 me-2"></i>Customer Cart</h1>
            <p class="lead mb-0" style="opacity:.88;">View everything in your next shipment, add extras before shipping, and confirm delivery in one place.</p>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div id="guestState" class="cart-card text-center" style="display:none;">
                        <i class="bi bi-person-lock display-4 text-primary d-block mb-3"></i>
                        <h4 class="fw-bold mb-2">Customer login required</h4>
                        <p class="text-muted mb-4">Only customer accounts can use the cart and confirm shipping.</p>
                        <a href="auth.html" class="btn btn-primary">Go to Login</a>
                    </div>

                    <div id="emptyState" class="cart-card text-center" style="display:none;">
                        <i class="bi bi-cart-x display-4 text-primary d-block mb-3"></i>
                        <h4 class="fw-bold mb-2">Your cart is empty</h4>
                        <p class="text-muted mb-4">Start from the box pages or customize a package to add it here.</p>
                        <a href="sports.html" class="btn btn-primary">Browse Boxes</a>
                    </div>

                    <div id="cartList" class="d-flex flex-column gap-4"></div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-card">
                        <h5 class="fw-bold mb-3">Shipping Summary</h5>
                        <div class="shipping-note p-3 mb-4">
                            <div class="fw-semibold text-primary mb-1">Add-ons ship free</div>
                            <div class="small text-muted">Any add-on selected before confirmation is bundled into the same shipment without an extra shipping fee.</div>
                        </div>
                        <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Boxes</span><span class="fw-semibold" id="summaryCount">0</span></div>
                        <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Add-ons</span><span class="fw-semibold" id="summaryAddOns">0</span></div>
                        <div class="d-flex justify-content-between small mb-3"><span class="text-muted">Order total</span><span class="fw-semibold" id="summaryTotal">$0.00</span></div>
                        <button class="btn btn-primary w-100 py-3 fw-semibold mb-2" id="confirmShippingBtn" onclick="confirmShipping()">
                            <i class="bi bi-truck me-2"></i>Confirm Shipping
                        </button>
                        <a href="sports.html" class="btn btn-outline-secondary w-100">Add More Boxes</a>
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
                <div class="col-lg-4"><h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5><p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p><div class="social-links d-flex gap-2"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-instagram"></i></a><a href="#"><i class="bi bi-twitter-x"></i></a><a href="#"><i class="bi bi-youtube"></i></a></div></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Quick Links</h6><ul class="footer-links"><li><a href="{{ route('welcome') }}">Home</a></li><li><a href="{{ route('sports') }}">Sports</a></li><li><a href="{{ route('subscription') }}l">Subscriptions</a></li></ul></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Account</h6><ul class="footer-links"><li><a href="{{ route('dsahboard') }}">Dashboard</a></li><li><a href="{{ route('login') }}" id="footerAuthLink">Login</a></li></ul></div>
                <div class="col-lg-4"><h6 class="fw-bold mb-3">Contact</h6><p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com</p><p style="font-size:.9rem;"><i class="bi bi-phone me-2 text-primary"></i>+1 (555) 123-4567</p></div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">&copy; 2026 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/home/cart.js') }}"></script>
</body>
</html>

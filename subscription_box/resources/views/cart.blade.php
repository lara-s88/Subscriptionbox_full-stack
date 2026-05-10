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

    <div class="page-hero">
        <div class="container position-relative">
            <h1 class="display-6 fw-bold mb-2"><i class="bi bi-cart3 me-2"></i>Customer Cart</h1>
            <p class="lead mb-0" style="opacity:.88;">Review pending boxes and confirm shipping.</p>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-4">
                        @forelse ($orders as $order)
                            @php
                                $image = $order->box?->base_image ?: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800';
                                $imageSrc = \Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset($image);
                            @endphp
                            <div class="cart-card">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-3">
                                        <img src="{{ $imageSrc }}" alt="Cart box" class="w-100 rounded-3" style="height:120px;object-fit:cover;">
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-1">{{ $order->box?->name ?? 'Box #' . $order->box_id }}</h6>
                                        <p class="text-muted small mb-2">{{ $order->box?->description }}</p>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(16,185,129,.1);color:var(--primary);">{{ $order->user?->customer?->clothing_size ?? 'Size saved' }}</span>
                                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(16,185,129,.1);color:var(--primary);">{{ ucfirst($order->user?->customer?->diet_preference ?? 'Diet saved') }}</span>
                                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(16,185,129,.1);color:var(--primary);">{{ str_replace('_', '-', $order->user?->customer?->delivery_frequency ?? 'Frequency saved') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        <div class="fw-bold text-primary fs-5">${{ number_format($order->total_amount, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="cart-card text-center">
                                <i class="bi bi-cart-x display-4 text-primary d-block mb-3"></i>
                                <h4 class="fw-bold mb-2">Your cart is empty</h4>
                                <p class="text-muted mb-4">Start from the box pages or customize a package to add it here.</p>
                                <a href="{{ route('sports') }}" class="btn btn-primary">Browse Boxes</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-card">
                        <h5 class="fw-bold mb-3">Shipping Summary</h5>
                        <div class="shipping-info p-3 mb-4">
                            <div class="fw-semibold text-primary mb-1">Confirm shipment</div>
                            <div class="small text-muted">Shipping details are saved to your customer account.</div>
                        </div>
                        <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Boxes</span><span class="fw-semibold">{{ $orders->count() }}</span></div>
                        <div class="d-flex justify-content-between small mb-3"><span class="text-muted">Order total</span><span class="fw-semibold">${{ number_format($orders->sum('total_amount'), 2) }}</span></div>
                        <button class="btn btn-primary w-100 py-3 fw-semibold mb-2" data-bs-toggle="modal" data-bs-target="#shippingModal" type="button" @disabled($orders->isEmpty())>
                            <i class="bi bi-truck me-2"></i>Ship
                        </button>
                        <a href="{{ route('sports') }}" class="btn btn-outline-secondary w-100">Add More Boxes</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="shippingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0">
                <form action="{{ route('cart.confirm-shipping') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Shipping Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ auth()->user()->customer->address ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">City</label>
                            <input type="text" class="form-control" name="city" value="{{ auth()->user()->customer->city ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Country</label>
                            <input type="text" class="form-control" name="country" value="{{ auth()->user()->customer->country ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Delivery Instructions</label>
                            <textarea class="form-control" name="delivery_instructions" rows="3">{{ auth()->user()->customer->delivery_instructions ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm Shipping</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer py-5 mt-3">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4"><h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5><p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Quick Links</h6><ul class="footer-list"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('sports') }}">Sports</a></li><li><a href="{{ route('subscriptions') }}">Subscriptions</a></li></ul></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Account</h6><ul class="footer-list"><li><a href="{{ route('dashboard') }}">Dashboard</a></li><li><a href="{{ route('cart') }}">Cart</a></li></ul></div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">&copy; 2026 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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
    <x-navbar activePage="boxes"></x-navbar>

    <div class="hero-section-sm">
        <div class="container position-relative">
            <a href="{{ route('sports') }}" class="btn btn-sm btn-outline-light px-3 mb-3"><i class="bi bi-arrow-left me-1"></i>All Sports</a>
            <h1 class="display-5 fw-bold mb-2">{{ $sport ? ucfirst($sport) . ' Boxes' : 'Boxes' }}</h1>
            <p class="lead mb-0" style="opacity:.88;">Premium curated boxes from the database</p>
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                <p class="text-muted small mb-0">{{ $boxes->count() }} box(es) available</p>
                <a href="{{ route('cart') }}" class="btn btn-outline-primary ms-auto">
                    <i class="bi bi-cart3 me-1"></i>View Cart
                </a>
            </div>

            <div class="row g-4">
                @forelse ($boxes as $box)
                    @php
                        $image = $box->base_image ?: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800';
                        $imageSrc = \Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset($image);
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="box-card h-100">
                            <div class="overflow-hidden" style="height:190px;">
                                <img src="{{ $imageSrc }}" alt="{{ $box->name }}" class="box-card-img">
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold mb-0 flex-grow-1 pe-2">{{ $box->name }}</h6>
                                    <span class="type-badge" style="background:#10b98118;color:#10b981;">{{ ucfirst($box->box_type) }}</span>
                                </div>
                                <p class="text-muted small mb-3" style="font-size:.82rem;">{{ $box->description }}</p>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach ($box->items as $boxItem)
                                        @if ($boxItem->inventoryItem)
                                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(16,185,129,.1);color:var(--primary);">{{ $boxItem->inventoryItem->name }}</span>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                    <span class="fw-bold text-primary fs-5">${{ number_format($box->base_price, 2) }}</span>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#addCartModal{{ $box->id }}" type="button">
                                            <i class="bi bi-cart-plus me-1"></i>Add Cart
                                        </button>
                                        <a href="{{ route('customize.box', $box->id) }}" class="btn btn-primary btn-sm px-3">
                                            <i class="bi bi-pencil-square me-1"></i>Customize
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addCartModal{{ $box->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 border-0">
                                <form action="{{ route('add.to.cart', $box->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Add {{ $box->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">Diet Preference</label>
                                            <select name="diet_preference" class="form-control" required>
                                                <option value="standard">Standard</option>
                                                <option value="keto">Keto</option>
                                                <option value="vegan">Vegan</option>
                                                <option value="Hiegh Protein">High Protein</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">Delivery Frequency</label>
                                            <select name="delivery_frequency" class="form-control" required>
                                                <option value="Monthly">Monthly</option>
                                                <option value="Bi_Monthly">Bi-Monthly</option>
                                                <option value="Quarterly">Quarterly</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold small">Clothing Size</label>
                                            <select name="clothing_size" class="form-control" required>
                                                @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                                    <option value="{{ $size }}">{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-box2 display-3 text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No boxes found</h5>
                            <a class="btn btn-outline-primary" href="{{ route('boxes') }}">Reset Filters</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4"><h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5><p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Quick Links</h6><ul class="footer-links"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('sports') }}">Sports</a></li><li><a href="{{ route('subscriptions') }}">Subscriptions</a></li></ul></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Account</h6><ul class="footer-links"><li><a href="{{ route('dashboard') }}">Dashboard</a></li><li><a href="{{ route('cart') }}">Cart</a></li></ul></div>
                <div class="col-lg-4"><h6 class="fw-bold mb-3">Contact</h6><p style="font-size:.9rem;"><i class="bi bi-envelope me-2 text-primary"></i>support@sportbox.com</p></div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">&copy; 2026 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

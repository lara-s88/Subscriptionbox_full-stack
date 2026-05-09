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
    <x-navbar activePage="customize"></x-navbar>

    @php
        $image = $box->base_image ?: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800';
        $imageSrc = \Illuminate\Support\Str::startsWith($image, ['http://', 'https://']) ? $image : asset($image);
    @endphp

    <div class="hero-section-sm">
        <div class="container position-relative">
            <div class="d-flex gap-2 flex-wrap mb-3">
                <a href="{{ route('boxes') }}" class="btn btn-sm btn-outline-light px-3"><i class="bi bi-arrow-left me-1"></i>Back to Boxes</a>
                <a href="{{ route('cart') }}" class="btn btn-sm btn-light px-3"><i class="bi bi-cart3 me-1"></i>View Cart</a>
            </div>
            <h1 class="display-6 fw-bold mb-1">Customize: {{ $box->name }}</h1>
            <p class="lead mb-0" style="opacity:.85;">Choose preferences and save this customized box to your cart</p>
        </div>
    </div>

    <form action="{{ route('customize.save', $box->id) }}" method="POST">
        @csrf
        <section class="py-5">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">Please complete all required choices.</div>
                @endif
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card border-0 rounded-4 shadow-sm mb-4">
                            <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-box-seam text-primary me-2"></i>Box Items</h6>
                                    <span class="badge rounded-pill" style="background:var(--gradient);">{{ $box->items->count() }} items</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted small mb-3">These items are included in the selected box.</p>
                                <div class="d-flex flex-column gap-2">
                                    @forelse ($box->items as $boxItem)
                                        @if ($boxItem->inventoryItem)
                                            <div class="custom-item d-flex align-items-center justify-content-between gap-3 p-3 rounded-3 border">
                                                <div class="d-flex align-items-center gap-3">
                                                    <i class="bi bi-check-circle text-primary"></i>
                                                    <span class="fw-semibold small">{{ $boxItem->inventoryItem->name }}</span>
                                                </div>
                                                <span class="text-muted small">{{ $boxItem->inventoryItem->category }}</span>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="text-muted small">No items are assigned to this box yet.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 shadow-sm mb-4">
                            <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                                <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle text-primary me-2"></i>Optional Extra Items</h6>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted small mb-3">Choose any extra items you want bundled with this cart entry.</p>
                                <div class="d-flex flex-wrap gap-2">
                                    @forelse ($availableItems as $item)
                                        <label class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <input class="form-check-input me-1" type="checkbox" name="extra_items[]" value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </label>
                                    @empty
                                        <span class="text-muted small">No extra inventory items available.</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 shadow-sm">
                            <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                                <h6 class="fw-bold mb-0"><i class="bi bi-sliders text-primary me-2"></i>Preferences</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="fw-semibold small mb-2 d-block">Clothing Size</label>
                                        <select name="clothing_size" class="form-control" required>
                                            @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                                <option value="{{ $size }}">{{ $size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-semibold small mb-2 d-block">Diet Preference</label>
                                        <select name="diet_preference" class="form-control" required>
                                            <option value="standard">Standard</option>
                                            <option value="keto">Keto</option>
                                            <option value="vegan">Vegan</option>
                                            <option value="Hiegh Protein">High Protein</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-semibold small mb-2 d-block">Delivery Frequency</label>
                                        <select name="delivery_frequency" class="form-control" required>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Bi_Monthly">Bi-Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="summary-card">
                            <div class="mb-3">
                                <div class="overflow-hidden rounded-3 mb-3" style="height:160px;">
                                    <img src="{{ $imageSrc }}" alt="{{ $box->name }}" class="w-100 h-100" style="object-fit:cover;">
                                </div>
                                <h5 class="fw-bold mb-1">{{ $box->name }}</h5>
                                <p class="text-muted small">{{ ucfirst($box->box_type) }} Box</p>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2"><span class="text-muted small">Items in box:</span><span class="fw-semibold small">{{ $box->items->count() }} items</span></div>
                                <div class="d-flex justify-content-between mb-2"><span class="text-muted small">Box type:</span><span class="fw-semibold small">{{ ucfirst($box->box_type) }}</span></div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-primary fs-4">${{ number_format($box->base_price, 2) }}</span>
                            </div>
                            <button class="btn btn-primary w-100 py-3 fw-semibold mb-2" type="submit">
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
    </form>

    <footer class="footer py-5 mt-3">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4"><h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5><p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Quick Links</h6><ul class="footer-links"><li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('sports') }}">Sports</a></li><li><a href="{{ route('subscriptions') }}">Subscriptions</a></li></ul></div>
                <div class="col-lg-2 col-6"><h6 class="fw-bold mb-3">Account</h6><ul class="footer-links"><li><a href="{{ route('dashboard') }}">Dashboard</a></li><li><a href="{{ route('cart') }}">Cart</a></li></ul></div>
            </div>
            <hr class="my-4" style="border-color:#1e293b;">
            <p class="text-center mb-0" style="font-size:.85rem;">&copy; 2026 SportBox. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

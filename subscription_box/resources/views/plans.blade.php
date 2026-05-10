<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans Management - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>
    <x-navbar activePage="dashboard"></x-navbar>

    <div class="dash-header">
        <div class="container position-relative">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:60px;height:60px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-box-seam fs-2 text-white"></i>
                </div>
                <div>
                    <p class="mb-0 small" style="opacity:.75;">Subscription Management</p>
                    <h3 class="mb-0 fw-bold">Plans Management</h3>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="admin-badge">Create & edit plans</span>
                <span class="admin-badge">Manage features</span>
                <span class="admin-badge">Set pricing</span>
            </div>
        </div>
    </div>

    <main class="py-5">
        <div class="container">
            <!-- Display Success/Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Please check the form for errors.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-5">
                    <div class="content-card p-4 mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle text-primary me-2"></i>Create New Plan</h5>
                        <p class="text-muted small mb-4">Add a new subscription plan with custom features and pricing.</p>
                        <form method="POST" action="{{ route('admin.plans.create') }}">
                            @csrf

                            <!-- Plan Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    placeholder="e.g., Premium Box" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price Monthly -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Monthly Price <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control @error('price_monthly') is-invalid @enderror"
                                        name="price_monthly" placeholder="29.99" step="0.01" min="0"
                                        value="{{ old('price_monthly') }}" required>
                                </div>
                                @error('price_monthly')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Boxes Per Month -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Boxes Per Month</label>
                                <input type="number" class="form-control @error('boxes_per_month') is-invalid @enderror"
                                    name="boxes_per_month" placeholder="1" min="1" value="{{ old('boxes_per_month') }}">
                                <small class="text-muted">How many boxes are delivered per month</small>
                                @error('boxes_per_month')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Swap Limit -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Swap Limit</label>
                                <input type="number" class="form-control @error('swap_limit') is-invalid @enderror"
                                    name="swap_limit" placeholder="0" min="0" value="{{ old('swap_limit') }}">
                                <small class="text-muted">Number of items that can be swapped per box</small>
                                @error('swap_limit')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Features Section -->
                            <div class="mb-4 p-3 rounded-3" style="background:#f8fafc;">
                                <p class="fw-semibold small mb-3">Plan Features</p>

                                <!-- Express Shipping -->
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="express_shipping"
                                        id="express_shipping" value="1" {{ old('express_shipping') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="express_shipping">
                                        <i class="bi bi-lightning text-warning me-1"></i>Express Shipping
                                    </label>
                                </div>

                                <!-- Early Access -->
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="early_access"
                                        id="early_access" value="1" {{ old('early_access') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="early_access">
                                        <i class="bi bi-clock text-info me-1"></i>Early Access to Items
                                    </label>
                                </div>

                                <!-- VIP Support -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="vip_support"
                                        id="vip_support" value="1" {{ old('vip_support') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="vip_support">
                                        <i class="bi bi-star text-primary me-1"></i>VIP Support
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i>Create Plan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Plans Table Section -->
                <div class="col-lg-7">
                    <div class="content-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-list-ul text-primary me-2"></i>Active Plans</h5>
                            <span class="badge rounded-pill" style="background:rgba(16,185,129,.1);color:#059669;">
                                {{ count($plans ?? []) }} Plans
                            </span>
                        </div>
                        <p class="text-muted small mb-4">All subscription plans currently available for customers.</p>

                        @if (isset($plans) && count($plans) > 0)
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr style="border-bottom: 2px solid #e5e7eb;">
                                            <th class="fw-semibold">Plan Name</th>
                                            <th class="fw-semibold">Price</th>
                                            <th class="fw-semibold">Boxes</th>
                                            <th class="fw-semibold">Features</th>
                                            <th class="fw-semibold text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($plans as $plan)
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td>
                                                    <div class="fw-semibold">{{ $plan->name }}</div>
                                                    <div class="small text-muted">ID: #{{ $plan->id }}</div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">${{ number_format($plan->price_monthly, 2) }}</span>
                                                    <div class="small text-muted">/month</div>
                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill px-2" style="background:rgba(59,130,246,.12);color:#2563eb;">
                                                        {{ $plan->boxes_per_month ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 flex-wrap">
                                                        @if ($plan->express_shipping)
                                                            <span class="badge small" style="background:rgba(245,158,11,.15);color:#b45309;">
                                                                <i class="bi bi-lightning"></i>
                                                            </span>
                                                        @endif
                                                        @if ($plan->early_access)
                                                            <span class="badge small" style="background:rgba(59,130,246,.12);color:#2563eb;">
                                                                <i class="bi bi-clock"></i>
                                                            </span>
                                                        @endif
                                                        @if ($plan->vip_support)
                                                            <span class="badge small" style="background:rgba(16,185,129,.1);color:#059669;">
                                                                <i class="bi bi-star"></i>
                                                            </span>
                                                        @endif
                                                        @if (!$plan->express_shipping && !$plan->early_access && !$plan->vip_support)
                                                            <span class="small text-muted">No premium features</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.plans.delete', $plan->id) }}" method="POST" style="display:inline;"
                                                        onsubmit="return confirm('Are you sure you want to delete this plan?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete plan">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div style="width:80px;height:80px;background:rgba(16,185,129,.08);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                                    <i class="bi bi-inbox fs-3" style="color:#059669;"></i>
                                </div>
                                <p class="text-muted mb-0">No plans created yet. Create your first plan using the form on the left.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-box-seam-fill text-primary me-2"></i>SportBox</h5>
                    <p class="mb-3" style="font-size:.9rem;">Your Sport. Your Box. Delivered.</p>
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
                        <li><a href="{{ route('admin.reward') }}">Rewards</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="fw-bold mb-3">Account</h6>
                    <ul class="footer-list">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.plans') }}">Plans</a></li>
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
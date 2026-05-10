<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/subscription.css') }}">
</head>
<body>
    <x-navbar activePage="subscriptions"></x-navbar>

    <div class="page-hero text-center">
        <div class="container position-relative">
            <h1 class="display-5 fw-bold mb-3">Choose Your Plan</h1>
            <p class="lead mb-0" style="opacity:.88;">Plans are loaded from the database.</p>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="row g-4 justify-content-center align-items-stretch mb-5">
                @forelse ($plans as $plan)
                    <div class="col-lg-4 col-md-8">
                        <div class="plan-card {{ strtolower($plan->name) === 'pro' ? 'popular' : '' }}">
                            @if (strtolower($plan->name) === 'pro')
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge px-3 py-2 rounded-pill" style="background:var(--gradient);">Most Popular</span>
                                </div>
                            @endif
                            <div class="mb-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width:42px;height:42px;border-radius:10px;background:linear-gradient(135deg,rgba(16,185,129,.12),rgba(16,185,129,.06));display:flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-box text-primary fs-5"></i>
                                    </div>
                                    <h4 class="fw-bold mb-0">{{ $plan->name }}</h4>
                                </div>
                                <p class="text-muted small mb-0">{{ $plan->boxes_per_month }} box(es) per month</p>
                            </div>
                            <div class="mb-4">
                                <span class="display-5 fw-bold text-primary">${{ number_format($plan->price_monthly, 0) }}</span>
                                <span class="text-muted">/month</span>
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3 d-flex gap-2"><i class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>{{ $plan->boxes_per_month }} box(es) per month</span></li>
                                <li class="mb-3 d-flex gap-2"><i class="bi bi-check-circle-fill text-primary mt-1 flex-shrink-0"></i><span>{{ is_null($plan->swap_limit) ? 'Unlimited' : $plan->swap_limit }} item swaps</span></li>
                                <li class="mb-3 d-flex gap-2"><i class="bi {{ $plan->express_shipping ? 'bi-check-circle-fill text-primary' : 'bi-x-circle-fill text-muted' }} mt-1 flex-shrink-0"></i><span>Express shipping</span></li>
                                <li class="mb-3 d-flex gap-2"><i class="bi {{ $plan->early_access ? 'bi-check-circle-fill text-primary' : 'bi-x-circle-fill text-muted' }} mt-1 flex-shrink-0"></i><span>Early access</span></li>
                                <li class="d-flex gap-2"><i class="bi {{ $plan->vip_support ? 'bi-check-circle-fill text-primary' : 'bi-x-circle-fill text-muted' }} mt-1 flex-shrink-0"></i><span>VIP support</span></li>
                            </ul>
                            <form method="POST" action="{{ route('select.plan') }}">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="btn btn-outline-primary w-100 py-3 fw-semibold">
                                    Choose {{ $plan->name }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No plans are available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="footer py-5 mt-4">
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
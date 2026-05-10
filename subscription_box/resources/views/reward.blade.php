<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards - SportBox</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/reward.css') }}">
</head>
<body>
    <x-navbar activePage="reward"></x-navbar>
    @php($isAdminReward = ($rewardMode ?? 'customer') === 'admin')

    <div class="page-hero text-center">
        <div class="container position-relative">
            <h1 class="display-5 fw-bold mb-3"><i class="bi bi-gift me-3"></i>Referral &amp; Rewards</h1>
            <p class="lead mb-0" style="opacity:.88;">Rewards and admin-created themes from the database.</p>
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

            <div class="p-4 rounded-4 mb-5 text-white" style="background:var(--gradient);">
                <div class="row align-items-center g-3">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:60px;height:60px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-trophy-fill fs-3"></i>
                            </div>
                            <div>
                                <div class="display-6 fw-bold mb-0">{{ $rewardAccount->points ?? 0 }} Points</div>
                                <div style="opacity:.85;">{{ $rewardAccount->tier_name ?? 'Bronze' }} Tier</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="fw-bold fs-5">{{ auth()->user()?->boxOrders?->count() ?? 0 }}</div>
                        <div class="small" style="opacity:.8;">Boxes Received</div>
                    </div>
                </div>
            </div>

            @php($userPoints = $rewardAccount->points ?? 0)

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card border-0 rounded-4 shadow-sm">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(16,185,129,.08),rgba(15,118,110,.04));">
                            <h6 class="fw-bold mb-0"><i class="bi bi-gift text-primary me-2"></i>Current Themes</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex flex-column gap-3">
                                @forelse (($themes ?? []) as $theme)
                                    <div class="border rounded-4 p-3">
                                        <div class="d-flex justify-content-between align-items-start gap-3">
                                            <div>
                                                <div class="fw-semibold">{{ $theme->name }}</div>
                                                <div class="small text-muted">{{ $theme->description ?? 'Monthly SportBox theme' }}</div>
                                                <div class="small text-muted mt-1">{{ $theme->items->count() }} item(s) available</div>
                                            </div>
                                            <span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">Month {{ $theme->month }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted small">No themes are available yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 rounded-4 shadow-sm">
                        <div class="card-header border-0 py-3 px-4" style="background:linear-gradient(135deg,rgba(245,158,11,.08),rgba(217,119,6,.04));">
                            <h6 class="fw-bold mb-0"><i class="bi bi-star text-warning me-2"></i>Redeem Rewards</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex flex-column gap-3">
                                @forelse (($rewards ?? collect()) as $reward)
                                    <div class="border rounded-4 p-3">
                                        <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                            <div class="d-flex align-items-start gap-2 flex-grow-1">
                                                <div style="width:40px;height:40px;background:rgba(16,185,129,.12);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="bi {{ $reward->icon }} text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $reward->name }}</div>
                                                    <div class="small text-muted">{{ $reward->description }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="badge rounded-pill px-3 @if($userPoints >= $reward->points) bg-success @else bg-secondary @endif">
                                                <i class="bi bi-star-fill me-1"></i>{{ $reward->points }} pts
                                            </span>
                                            <form action="{{ route('reward.redeem', $reward->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm @if($userPoints >= $reward->points) btn-primary @else btn-secondary @endif" @if($userPoints < $reward->points) disabled @endif>
                                                    <i class="bi bi-check-circle me-1"></i>Redeem
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-muted small text-center py-3">No rewards available at the moment.</div>
                                @endforelse
                            </div>
                            <div class="mt-4 p-3 rounded-3" style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);">
                                <div class="small">
                                    <strong>Your Balance:</strong> <span class="text-primary fw-bold">{{ $userPoints }} Points</span>
                                </div>
                                <div class="small text-muted mt-1">Earn more points by referring friends and completing milestones.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
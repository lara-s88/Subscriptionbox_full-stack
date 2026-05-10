<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SportBox</title>
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
                    <i class="bi bi-shield-check fs-2 text-white"></i>
                </div>
                <div>
                    <p class="mb-0 small" style="opacity:.75;">Operations Admin</p>
                    <h3 class="mb-0 fw-bold">Admin Dashboard</h3>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="admin-badge">Admin account</span>
                <span class="admin-badge">Orders in view</span>
                <span class="admin-badge">Shipping batches</span>
            </div>
        </div>
    </div>

    <main class="py-5">
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

            <section id="adminDashboard">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card" style="border-left-color:var(--primary);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon" style="color:var(--primary);"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <div class="h4 fw-bold mb-0" style="color:var(--primary);">{{ count($users ?? []) }}</div>
                                    <div class="text-muted small">Customer Accounts</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card" style="border-left-color:#ef4444;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon" style="color:#ef4444;"><i class="bi bi-arrow-counterclockwise"></i></div>
                                <div>
                                    <div class="h4 fw-bold mb-0" style="color:#ef4444;">0</div>
                                    <div class="text-muted small">Returned Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                         <div class="stat-card" style="border-left-color:#f59e0b;">
                             <div class="d-flex align-items-center gap-3">
                                 <div class="stat-icon" style="color:#f59e0b;"><i class="bi bi-exclamation-triangle-fill"></i></div>
                                 <div>
                                     <div class="h4 fw-bold mb-0" style="color:#f59e0b;">{{ count($thresholdItems ?? []) }}</div>
                                     <div class="text-muted small">Low Stock Alerts</div>
                                 </div>
                             </div>
                         </div>
                     </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="stat-card" style="border-left-color:#3b82f6;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon" style="color:#3b82f6;"><i class="bi bi-diagram-3-fill"></i></div>
                                <div>
                                    <div class="h4 fw-bold mb-0" style="color:#3b82f6;">0</div>
                                    <div class="text-muted small">Shipping Batches</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-xl-8">
                        <!-- Inventory Management Section -->
                        <div class="content-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-box-seam text-primary me-2"></i>Inventory Items</h5>
                                <span class="badge rounded-pill" style="background:rgba(16,185,129,.1);color:#059669;">
                                    {{ count($items ?? []) }} Items
                                </span>
                            </div>
                            @if (isset($items) && count($items) > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                                <th class="fw-semibold">Item Name</th>
                                                <th class="fw-semibold">Category</th>
                                                <th class="fw-semibold">Price</th>
                                                <th class="fw-semibold">Stock</th>
                                                <th class="fw-semibold">Threshold</th>
                                                <th class="fw-semibold text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                                    <td>
                                                        <div class="fw-semibold">{{ $item->name }}</div>
                                                        <div class="small text-muted">ID: #{{ $item->id }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill px-2" style="background:rgba(59,130,246,.12);color:#2563eb;">
                                                            {{ $item->category }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold">${{ number_format($item->unit_price, 2) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill px-3 @if($item->stock_qty <= $item->safety_threshold) bg-warning text-dark @else @if($item->stock_qty > 20) bg-success @else bg-info @endif @endif">
                                                            {{ $item->stock_qty }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="small text-muted">{{ $item->safety_threshold ?? '-' }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#updateStockModal{{ $item->id }}" title="Update stock">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </button>
                                                        <form action="{{ route('admin.items.delete', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this item?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete item">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <!-- Update Stock Modal -->
                                                <div class="modal fade" id="updateStockModal{{ $item->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Stock - {{ $item->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('admin.items.updateStock', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Current Stock: <span class="badge bg-secondary">{{ $item->stock_qty }}</span></label>
                                                                        <input type="number" class="form-control" name="stock_qty" min="0" value="{{ $item->stock_qty }}" required>
                                                                        <small class="text-muted">Safety threshold: {{ $item->safety_threshold }}</small>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Update Stock</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-muted">No inventory items yet.</p>
                                </div>
                            @endif
                        </div>

                        <div class="content-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                 <h5 class="fw-bold mb-0"><i class="bi bi-people text-primary me-2"></i>Users Table</h5>
                                 <span class="small text-muted">{{ count($users ?? []) }} users</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse (($users ?? []) as $user)
                                            <tr>
                                                <td>#{{ $user->id }}</td>
                                                <td class="fw-semibold">
                                                    {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'N/A' }}
                                                </td>
                                                <td>{{ $user->email ?? 'N/A' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">No users found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="content-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-arrow-counterclockwise text-primary me-2"></i>Returned Orders</h5>
                                <span class="small text-muted">Customer return visibility for support follow-up</span>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold">Account name - Package name</div>
                                            <div class="small text-muted">Order ID - Tracking code</div>
                                        </div>
                                        <span class="badge rounded-pill px-3" style="background:rgba(239,68,68,.12);color:#dc2626;">Returned</span>
                                    </div>
                                    <div class="small text-muted mt-2">Reason: return reason goes here.</div>
                                </div>
                            </div>
                        </div>

                        <div class="content-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-diagram-3 text-primary me-2"></i>Shipping Package Batching</h5>
                                <span class="small text-muted">Grouped batches from the shipping system</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Batch</th>
                                            <th>Region</th>
                                            <th>Orders</th>
                                            <th>Warehouse State</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">Batch ID</td>
                                            <td>Region</td>
                                            <td>0</td>
                                            <td><span class="badge rounded-pill px-3" style="background:rgba(59,130,246,.12);color:#2563eb;">Warehouse state</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                         <div class="content-card p-4 mb-4">
                             <h5 class="fw-bold mb-2"><i class="bi bi-plus-circle text-primary me-2"></i>Add Inventory Item</h5>
                             <p class="text-muted small mb-4">Add a new item to your inventory.</p>
                             <form method="POST" action="{{ route('admin.items.add') }}">
                                 @csrf
                                 <div class="mb-3">
                                     <label class="form-label fw-semibold small">Item Name <span class="text-danger">*</span></label>
                                     <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="e.g., Sports Watch" required>
                                     @error('name')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label class="form-label fw-semibold small">Category <span class="text-danger">*</span></label>
                                     <input type="text" class="form-control @error('category') is-invalid @enderror" name="category" placeholder="e.g., Electronics" required>
                                     @error('category')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label class="form-label fw-semibold small">Unit Price <span class="text-danger">*</span></label>
                                     <div class="input-group">
                                         <span class="input-group-text">$</span>
                                         <input type="number" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" placeholder="25.99" step="0.01" min="0.01" required>
                                     </div>
                                     @error('unit_price')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label class="form-label fw-semibold small">Stock Quantity <span class="text-danger">*</span></label>
                                     <input type="number" class="form-control @error('stock_qty') is-invalid @enderror" name="stock_qty" placeholder="50" min="1" required>
                                     @error('stock_qty')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label class="form-label fw-semibold small">Weight (kg)</label>
                                     <input type="number" class="form-control @error('weight_kg') is-invalid @enderror" name="weight_kg" placeholder="0.5" step="0.01" min="0.01">
                                     @error('weight_kg')
                                         <div class="invalid-feedback d-block">{{ $message }}</div>
                                     @enderror
                                 </div>
                                 <button type="submit" class="btn btn-primary w-100"><i class="bi bi-plus-circle me-2"></i>Add Item</button>
                             </form>
                         </div>

                         <div class="content-card p-4 mb-4 upload-box">
                             <h5 class="fw-bold mb-2"><i class="bi bi-cloud-upload text-primary me-2"></i>Upload Themes</h5>
                            <p class="text-muted small mb-4">Create a new monthly theme for subscription boxes.</p>
                            <form method="POST" action="{{ route('admin.themes.create') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Theme Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="May Gadget Drop" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Month</label>
                                    <select class="form-control" name="month" required>
                                        <option value="">Select Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Describe the theme..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Image URL</label>
                                    <input type="url" class="form-control" name="image_url" placeholder="https://example.com/image.jpg">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Create Theme</button>
                            </form>
                        </div>

                        <div class="content-card p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                 <h5 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Stock Threshold</h5>
                                 <span class="badge rounded-pill" style="background:rgba(245,158,11,.15);color:#b45309;">
                                     {{ count($thresholdItems ?? []) }} Low
                                 </span>
                            </div>
                            @if (isset($thresholdItems) && count($thresholdItems) > 0)
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($thresholdItems as $item)
                                        <div class="border rounded-4 p-3">
                                            <div class="d-flex justify-content-between align-items-start gap-3">
                                                <div>
                                                    <div class="fw-semibold">{{ $item->name }}</div>
                                                    <div class="small text-muted">{{ $item->category }}</div>
                                                </div>
                                                <span class="badge rounded-pill px-3" style="background:rgba(245,158,11,.15);color:#b45309;">{{ $item->stock_qty }} in stock</span>
                                            </div>
                                            <div class="small text-muted mt-2">Threshold: {{ $item->safety_threshold }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-check-circle text-success" style="font-size:2rem;"></i>
                                    <p class="text-muted mt-2 mb-0">All items above threshold</p>
                                </div>
                            @endif
                        </div>

                        <div class="content-card p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-palette text-primary me-2"></i>Theme Library</h5>
                                <span class="small text-muted">Latest uploads</span>
                            </div>
                            <div class="d-flex flex-column gap-3">
                                <div class="border rounded-4 p-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold">Theme name</div>
                                            <div class="small text-muted">Month</div>
                                        </div>
                                        <span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">Status</span>
                                    </div>
                                    <div class="small text-muted mt-2">0 items</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1100">
        <div id="msg-toast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold" id="toast-text">Message</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

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
                        <li><a href="{{ route('login') }}" id="footer-login-link">Login</a></li>
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
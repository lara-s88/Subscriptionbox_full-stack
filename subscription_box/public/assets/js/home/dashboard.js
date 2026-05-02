
const SportBoxPortal = (() => {
    const DB_KEY = 'sportbox-db';
    const SESSION_KEY = 'sportbox-session';
    const seedDatabase = {
        admins: [{
            id: 'admin-1',
            name: 'Maya Carter',
            email: 'admin@sportbox.com',
            password: 'Admin123!',
            role: 'admin',
            title: 'Operations Admin'
        }],
        customers: [{
                id: 'cust-1',
                name: 'Alex Johnson',
                email: 'alex@sportbox.com',
                password: 'User123!',
                role: 'customer',
                tier: 'Pro',
                favoriteTheme: 'Football',
                points: 1240,
                memberSince: 'Aug 2023',
                nextBillingDate: '2026-04-27',
                nextDeliveryDate: '2026-04-28',
                boxCount: 8,
                daysToNextBox: 5,
                boxItems: ['Single-Origin Beans', 'Dark Roast', 'Filter Papers', 'Ceramic Mug',
                    'Mystery Item'
                ],
                orderHistory: [{
                        title: 'Football Pro Box',
                        date: 'Mar 20, 2026',
                        status: 'Delivered',
                        amount: '$49.99'
                    },
                    {
                        title: 'Gym Starter Box',
                        date: 'Feb 25, 2026',
                        status: 'Delivered',
                        amount: '$39.99'
                    },
                    {
                        title: 'Basketball Gear Pack',
                        date: 'Jan 28, 2026',
                        status: 'Returned',
                        amount: '$59.99'
                    },
                    {
                        title: 'Tennis Pro Kit',
                        date: 'Dec 30, 2025',
                        status: 'Delivered',
                        amount: '$64.99'
                    }
                ],
                delivery: {
                    state: 'Shipped',
                    trackingCode: 'SPX-789-XYZ',
                    stopsAway: 9
                },
                subscriptions: [{
                    id: 'sub-1',
                    name: 'Football Pro Box',
                    status: 'active',
                    nextBillingDate: '2026-04-27',
                    price: '$49 / month'
                }]
            },
            {
                id: 'cust-2',
                name: 'Nina Patel',
                email: 'nina@sportbox.com',
                password: 'User123!',
                role: 'customer',
                tier: 'VIP',
                favoriteTheme: 'Sustainable Beauty',
                points: 1980,
                memberSince: 'Jan 2024',
                nextBillingDate: '2026-04-29',
                nextDeliveryDate: '2026-05-02',
                boxCount: 14,
                daysToNextBox: 7,
                boxItems: ['Rose Cleanser', 'Travel Serum', 'Bamboo Pads', 'Night Balm'],
                orderHistory: [{
                    title: 'Beauty Ritual Box',
                    date: 'Apr 01, 2026',
                    status: 'Delivered',
                    amount: '$79.99'
                }],
                delivery: {
                    state: 'Packed',
                    trackingCode: 'SPX-442-NP',
                    stopsAway: 0
                },
                subscriptions: [{
                    id: 'sub-2',
                    name: 'Beauty Ritual Box',
                    status: 'active',
                    nextBillingDate: '2026-04-29',
                    price: '$79 / month'
                }]
            }
        ],
        adminData: {
            orders: [{
                    orderId: 'ORD-1001',
                    customerId: 'cust-1',
                    customerName: 'Alex Johnson',
                    accountEmail: 'alex@sportbox.com',
                    packageName: 'Football Pro Box',
                    trackingCode: 'SPX-789-XYZ',
                    deliveryState: 'Shipped',
                    points: 1240,
                    returned: true,
                    returnReason: 'Damaged bottle shaker',
                    batchId: 'BATCH-NORTH-12'
                },
                {
                    orderId: 'ORD-1002',
                    customerId: 'cust-2',
                    customerName: 'Nina Patel',
                    accountEmail: 'nina@sportbox.com',
                    packageName: 'Beauty Ritual Box',
                    trackingCode: 'SPX-442-NP',
                    deliveryState: 'Packed',
                    points: 1980,
                    returned: false,
                    returnReason: '',
                    batchId: 'BATCH-EAST-08'
                },
                {
                    orderId: 'ORD-1003',
                    customerId: 'cust-3',
                    customerName: 'Marcus Reed',
                    accountEmail: 'marcus@sportbox.com',
                    packageName: 'Gadget Drop Mini',
                    trackingCode: 'SPX-991-MR',
                    deliveryState: 'Out for Delivery',
                    points: 860,
                    returned: false,
                    returnReason: '',
                    batchId: 'BATCH-SOUTH-05'
                }
            ],
            stock: [{
                    item: 'Dark Roast',
                    stock: 8,
                    threshold: 10,
                    theme: 'Coffee Edit'
                },
                {
                    item: 'Ceramic Mug',
                    stock: 22,
                    threshold: 12,
                    theme: 'Coffee Edit'
                },
                {
                    item: 'Travel Serum',
                    stock: 6,
                    threshold: 8,
                    theme: 'Beauty Ritual'
                },
                {
                    item: 'Mini Drone',
                    stock: 14,
                    threshold: 10,
                    theme: 'Gadget Drop'
                }
            ],
            themes: [{
                    id: 'theme-1',
                    name: 'Coffee Edit',
                    month: 'May 2026',
                    status: 'Ready',
                    items: 5
                },
                {
                    id: 'theme-2',
                    name: 'Beauty Ritual',
                    month: 'May 2026',
                    status: 'Uploaded',
                    items: 4
                }
            ],
            shippingBatches: [{
                    batchId: 'BATCH-NORTH-12',
                    region: 'North',
                    orders: 28,
                    warehouseState: 'Picking'
                },
                {
                    batchId: 'BATCH-EAST-08',
                    region: 'East',
                    orders: 17,
                    warehouseState: 'Packed'
                },
                {
                    batchId: 'BATCH-SOUTH-05',
                    region: 'South',
                    orders: 21,
                    warehouseState: 'Shipped'
                }
            ],
            themeUploads: []
        }
    };

    function ensureDatabase() {
        if (!localStorage.getItem(DB_KEY)) {
            localStorage.setItem(DB_KEY, JSON.stringify(seedDatabase));
        }
    }

    function getDatabase() {
        ensureDatabase();
        return JSON.parse(localStorage.getItem(DB_KEY));
    }

    function saveDatabase(db) {
        localStorage.setItem(DB_KEY, JSON.stringify(db));
    }

    function getSession() {
        const raw = localStorage.getItem(SESSION_KEY);
        return raw ? JSON.parse(raw) : null;
    }

    function clearSession() {
        localStorage.removeItem(SESSION_KEY);
    }

    function getCurrentCustomer() {
        const session = getSession();
        if (!session || session.role !== 'customer') return null;
        return getDatabase().customers.find((customer) => customer.id === session.id) || null;
    }

    function getCurrentAdmin() {
        const session = getSession();
        if (!session || session.role !== 'admin') return null;
        return getDatabase().admins.find((admin) => admin.id === session.id) || null;
    }

    function addThemeUpload(theme) {
        const db = getDatabase();
        const entry = {
            id: `theme-upload-${Date.now()}`,
            name: theme.name,
            month: theme.month,
            items: Number(theme.items),
            status: 'Uploaded'
        };
        db.adminData.themes.unshift(entry);
        db.adminData.themeUploads.unshift({
            id: entry.id,
            uploadedAt: new Date().toISOString(),
            ...entry
        });
        saveDatabase(db);
        return entry;
    }

    function updateCustomerSubscriptionStatus(customerId, status) {
        const db = getDatabase();
        const customer = db.customers.find((item) => item.id === customerId);
        if (!customer || !customer.subscriptions.length) return;
        customer.subscriptions[0].status = status;
        saveDatabase(db);
    }

    ensureDatabase();
    return {
        getDatabase,
        getSession,
        clearSession,
        getCurrentCustomer,
        getCurrentAdmin,
        addThemeUpload,
        updateCustomerSubscriptionStatus
    };
})();

const deliverySteps = [{
        label: 'Pending',
        icon: 'bi-hourglass-split'
    },
    {
        label: 'Picking',
        icon: 'bi-basket'
    },
    {
        label: 'Packed',
        icon: 'bi-box2'
    },
    {
        label: 'Shipped',
        icon: 'bi-truck'
    },
    {
        label: 'Out for Delivery',
        icon: 'bi-geo-alt'
    },
    {
        label: 'Delivered',
        icon: 'bi-house-check-fill'
    }
];

let isSubscriptionPaused = false;

function toggleDarkMode() {
    const isDark = document.body.classList.toggle('dark-mode');
    localStorage.setItem('sportbox-dark', isDark ? '1' : '0');
    const icon = document.getElementById('darkModeToggle')?.querySelector('i');
    if (icon) icon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
}

(function() {
    if (localStorage.getItem('sportbox-dark') === '1') {
        document.body.classList.add('dark-mode');
        window.addEventListener('DOMContentLoaded', () => {
            const icon = document.getElementById('darkModeToggle')?.querySelector('i');
            if (icon) icon.className = 'bi bi-sun-fill';
        });
    }
})();

function showToast(msg, type = 'success') {
    const el = document.getElementById('mainToast');
    const msgEl = document.getElementById('toastMsg');
    if (msgEl) msgEl.textContent = msg;
    if (el) {
        el.className = `toast align-items-center border-0 text-bg-${type}`;
        new bootstrap.Toast(el, {
            delay: 3200
        }).show();
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}

function shouldSendFinalConfirmation(nextBillingDate) {
    const today = new Date();
    const target = new Date(nextBillingDate + 'T00:00:00');
    const diffDays = Math.ceil((target - today) / (24 * 3600 * 1000));
    return diffDays <= 3 && diffDays >= 0;
}

function shouldNotifyLastMile(stopsAway) {
    return stopsAway > 0 && stopsAway <= 10;
}

function handleLogout(event) {
    event.preventDefault();
    SportBoxPortal.clearSession();
    showToast('You have been logged out.', 'secondary');
    setTimeout(() => {
        window.location.href = '/login';
    }, 700);
}

function updateAuthAction() {
    const session = SportBoxPortal.getSession();
    const link = document.getElementById('authActionLink');
    const footerAuthLink = document.getElementById('footerAuthLink');
    const rewardNavItem = document.getElementById('rewardNavItem');
    const footerRewardItem = document.getElementById('footerRewardItem');
    const adminOnlyHiddenLinks = document.querySelectorAll(
        window.routeSelector('home', 'sports', 'subscriptions')
    );

    if (rewardNavItem) rewardNavItem.style.display = session ? '' : 'none';
    if (footerRewardItem) footerRewardItem.style.display = session ? '' : 'none';
    adminOnlyHiddenLinks.forEach((navLink) => {
        navLink.closest('.nav-item').style.display = session?.role === 'admin' ? 'none' : '';
    });

    if (!link) return;
    if (session) {
        link.textContent = 'Logout';
        link.href = '#';
        link.onclick = handleLogout;
        if (footerAuthLink) {
            footerAuthLink.textContent = 'Logout';
            footerAuthLink.href = '#';
            footerAuthLink.onclick = handleLogout;
        }
    } else {
        if (footerAuthLink) {
            footerAuthLink.textContent = 'Login';
            footerAuthLink.href = '/login';
            footerAuthLink.onclick = null;
        }
    }
}

function renderHeader(session, customer, admin) {
    const badges = document.getElementById('headerBadges');
    badges.innerHTML = '';

    if (!session) {
        document.getElementById('headerEyebrow').textContent = 'Portal access required';
        document.getElementById('headerName').textContent = 'Sign in to continue';
        document.getElementById('headerIcon').className = 'bi bi-shield-lock fs-2 text-white';
        return;
    }

    if (session.role === 'admin' && admin) {
        document.getElementById('headerEyebrow').textContent = admin.title;
        document.getElementById('headerName').textContent = admin.name;
        document.getElementById('headerIcon').className = 'bi bi-shield-check fs-2 text-white';
        [
            `Admin account`,
            `${SportBoxPortal.getDatabase().adminData.orders.length} orders in view`,
            `${SportBoxPortal.getDatabase().adminData.shippingBatches.length} shipping batches`
        ].forEach((text) => {
            const span = document.createElement('span');
            span.className = 'admin-pill';
            span.textContent = text;
            badges.appendChild(span);
        });
        return;
    }

    if (customer) {
        document.getElementById('headerEyebrow').textContent = 'Welcome back!';
        document.getElementById('headerName').textContent = customer.name;
        document.getElementById('headerIcon').className = 'bi bi-person-fill fs-2 text-white';
        [
            `${customer.tier} Plan`,
            customer.favoriteTheme,
            `Member since ${customer.memberSince}`
        ].forEach((text) => {
            const span = document.createElement('span');
            span.className = 'admin-pill';
            span.textContent = text;
            badges.appendChild(span);
        });
    }
}

function renderCustomerDashboard(customer) {
    document.getElementById('customerDashboard').style.display = 'block';

    const stats = [{
            label: 'Boxes Received',
            value: customer.boxCount,
            color: 'var(--primary)',
            icon: 'bi-box2-heart-fill'
        },
        {
            label: 'Reward Points',
            value: customer.points.toLocaleString(),
            color: '#f59e0b',
            icon: 'bi-stars'
        },
        {
            label: 'Days to Next Box',
            value: customer.daysToNextBox,
            color: '#06b6d4',
            icon: 'bi-truck'
        }
    ];
    document.getElementById('customerStats').innerHTML = stats.map((stat) => `
        <div class="col-sm-6 col-lg-4">
            <div class="stat-card" style="border-left-color:${stat.color};">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="color:${stat.color};"><i class="bi ${stat.icon}"></i></div>
                    <div><div class="h4 fw-bold mb-0" style="color:${stat.color};">${stat.value}</div><div class="text-muted small">${stat.label}</div></div>
                </div>
            </div>
        </div>
    `).join('');

    const subscription = customer.subscriptions[0];
    document.getElementById('customerDeliveryPill').textContent = customer.delivery.state;
    document.getElementById('customerPackageName').textContent = subscription.name;
    document.getElementById('customerTierBadge').textContent = customer.tier;
    document.getElementById('customerDeliveryDate').textContent = formatDate(customer.nextDeliveryDate);
    document.getElementById('customerTrackingCode').textContent = customer.delivery.trackingCode;
    document.getElementById('subscriptionTitle').textContent = `${customer.tier} Plan`;
    document.getElementById('subscriptionPrice').textContent = subscription.price;
    document.getElementById('subscriptionBillingDate').textContent = formatDate(subscription.nextBillingDate);
    document.getElementById('subscriptionMemberSince').textContent = customer.memberSince;
    document.getElementById('customerPoints').textContent = customer.points.toLocaleString();
    document.getElementById('pointsProgressLabel').textContent = `${customer.points.toLocaleString()} / 2,000`;
    document.getElementById('pointsProgressBar').style.width = `${Math.min((customer.points / 2000) * 100, 100)}%`;

    const contentsEl = document.getElementById('boxContents');
    contentsEl.innerHTML = '';
    customer.boxItems.forEach((item) => {
        const badge = document.createElement('span');
        badge.className = 'badge rounded-pill px-3 py-2';
        badge.style.cssText = 'background:rgba(16,185,129,.1);color:var(--primary);font-size:.8rem;';
        badge.textContent = item;
        contentsEl.appendChild(badge);
    });

    renderDeliveryTracker(customer.delivery.state);

    const historyTable = document.getElementById('orderHistory');
    historyTable.innerHTML = customer.orderHistory.map((order) => `
        <tr>
            <td class="ps-4 py-3 fw-semibold small">${order.title}</td>
            <td class="py-3 text-muted small">${order.date}</td>
            <td class="py-3 fw-semibold text-primary small">${order.amount}</td>
            <td class="py-3"><span class="badge rounded-pill px-3" style="background:${order.status === 'Returned' ? 'rgba(239,68,68,.12)' : 'rgba(16,185,129,.1)'};color:${order.status === 'Returned' ? '#dc2626' : '#059669'};">${order.status}</span></td>
            <td class="py-3"><button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="showToast('Reorder placed.', 'primary')"><i class="bi bi-arrow-repeat me-1"></i>Reorder</button></td>
        </tr>
    `).join('');

    if (shouldSendFinalConfirmation(subscription.nextBillingDate)) {
        showToast('Final confirmation: next renewal is within 3 days.', 'info');
    }
    if (shouldNotifyLastMile(customer.delivery.stopsAway)) {
        showToast(`Driver is ${customer.delivery.stopsAway} stops away.`, 'primary');
    }
}

function renderDeliveryTracker(activeLabel) {
    const tracker = document.getElementById('deliveryTracker');
    const progress = document.getElementById('trackerProgress');
    tracker.querySelectorAll('.tracker-step').forEach((step) => step.remove());
    const activeStep = Math.max(0, deliverySteps.findIndex((step) => step.label === activeLabel));

    deliverySteps.forEach((step, index) => {
        const div = document.createElement('div');
        div.className =
            `tracker-step${index < activeStep ? ' done' : ''}${index === activeStep ? ' active' : ''}`;
        div.innerHTML =
            `<div class="tracker-step-icon"><i class="bi ${index < activeStep ? 'bi-check-lg' : step.icon}"></i></div><div class="tracker-step-label">${step.label}</div>`;
        tracker.appendChild(div);
    });

    const pct = (activeStep / (deliverySteps.length - 1)) * 100;
    setTimeout(() => {
        progress.style.width = `${pct}%`;
    }, 250);
}

function renderAdminDashboard(admin) {
    const db = SportBoxPortal.getDatabase();
    const orders = db.adminData.orders;
    const returnedOrders = orders.filter((order) => order.returned);
    const lowStock = db.adminData.stock.filter((item) => item.stock <= item.threshold);
    const stats = [{
            label: 'Customer Accounts',
            value: db.customers.length,
            icon: 'bi-people-fill',
            color: 'var(--primary)'
        },
        {
            label: 'Returned Orders',
            value: returnedOrders.length,
            icon: 'bi-arrow-counterclockwise',
            color: '#ef4444'
        },
        {
            label: 'Low Stock Alerts',
            value: lowStock.length,
            icon: 'bi-exclamation-triangle-fill',
            color: '#f59e0b'
        },
        {
            label: 'Shipping Batches',
            value: db.adminData.shippingBatches.length,
            icon: 'bi-diagram-3-fill',
            color: '#3b82f6'
        }
    ];

    document.getElementById('adminDashboard').style.display = 'block';
    document.getElementById('adminStats').innerHTML = stats.map((stat) => `
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card" style="border-left-color:${stat.color};">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon" style="color:${stat.color};"><i class="bi ${stat.icon}"></i></div>
                    <div><div class="h4 fw-bold mb-0" style="color:${stat.color};">${stat.value}</div><div class="text-muted small">${stat.label}</div></div>
                </div>
            </div>
        </div>
    `).join('');

    document.getElementById('adminOrdersTable').innerHTML = orders.map((order) => `
        <tr>
            <td>
                <div class="fw-semibold">${order.customerName}</div>
                <div class="small text-muted">${order.accountEmail}</div>
            </td>
            <td>${order.packageName}</td>
            <td><span class="font-monospace text-primary">${order.trackingCode}</span></td>
            <td><span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">${order.deliveryState}</span></td>
            <td>${order.points}</td>
            <td><span class="badge rounded-pill px-3" style="background:${order.returned ? 'rgba(239,68,68,.12)' : 'rgba(59,130,246,.12)'};color:${order.returned ? '#dc2626' : '#2563eb'};">${order.returned ? 'Returned' : 'No return'}</span></td>
        </tr>
    `).join('');

    document.getElementById('returnedOrdersList').innerHTML = returnedOrders.length ?
        returnedOrders.map((order) => `
            <div class="border rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="fw-semibold">${order.customerName} - ${order.packageName}</div>
                        <div class="small text-muted">${order.orderId} · ${order.trackingCode}</div>
                    </div>
                    <span class="badge rounded-pill px-3" style="background:rgba(239,68,68,.12);color:#dc2626;">Returned</span>
                </div>
                <div class="small text-muted mt-2">Reason: ${order.returnReason || 'Pending review'}</div>
            </div>
        `).join('') :
        '<div class="text-muted small">No returned orders right now.</div>';

    document.getElementById('batchingTable').innerHTML = db.adminData.shippingBatches.map((batch) => `
        <tr>
            <td class="fw-semibold">${batch.batchId}</td>
            <td>${batch.region}</td>
            <td>${batch.orders}</td>
            <td><span class="badge rounded-pill px-3" style="background:rgba(59,130,246,.12);color:#2563eb;">${batch.warehouseState}</span></td>
        </tr>
    `).join('');

    document.getElementById('stockThresholdList').innerHTML = db.adminData.stock.map((item) => {
        const isLow = item.stock <= item.threshold;
        return `
            <div class="border rounded-4 p-3">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div>
                        <div class="fw-semibold">${item.item}</div>
                        <div class="small text-muted">${item.theme}</div>
                    </div>
                    <span class="badge rounded-pill px-3" style="background:${isLow ? 'rgba(245,158,11,.15)' : 'rgba(16,185,129,.1)'};color:${isLow ? '#b45309' : '#059669'};">${item.stock} in stock</span>
                </div>
                <div class="small text-muted mt-2">Threshold: ${item.threshold}</div>
            </div>
        `;
    }).join('');

    document.getElementById('themeLibrary').innerHTML = db.adminData.themes.map((theme) => `
        <div class="border rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <div class="fw-semibold">${theme.name}</div>
                    <div class="small text-muted">${theme.month}</div>
                </div>
                <span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">${theme.status}</span>
            </div>
            <div class="small text-muted mt-2">${theme.items} items</div>
        </div>
    `).join('');

    if (lowStock.length) {
        showToast(`Stock alert: ${lowStock[0].item} is below threshold.`, 'warning');
    }
    showToast(`Admin dashboard loaded for ${admin.name}.`, 'success');
}

function updatePauseResumeUI() {
    const icon = document.getElementById('pauseResumeIcon');
    const label = document.getElementById('pauseResumeLabel');
    if (!icon || !label) return;
    if (isSubscriptionPaused) {
        icon.className = 'bi bi-play-circle';
        icon.style.color = '#10b981';
        label.textContent = 'Resume';
    } else {
        icon.className = 'bi bi-pause-circle';
        icon.style.color = '#ef4444';
        label.textContent = 'Pause';
    }
}

function toggleSubscriptionState() {
    const customer = SportBoxPortal.getCurrentCustomer();
    if (!customer) return;
    isSubscriptionPaused = !isSubscriptionPaused;
    SportBoxPortal.updateCustomerSubscriptionStatus(customer.id, isSubscriptionPaused ? 'paused' : 'active');
    updatePauseResumeUI();
    showToast(isSubscriptionPaused ? 'Subscription paused. Click again to resume.' :
        'Subscription resumed successfully.', isSubscriptionPaused ? 'warning' : 'success');
}

function confirmPause(months) {
    isSubscriptionPaused = true;
    updatePauseResumeUI();
    showToast(`Subscription paused for ${months} month${months > 1 ? 's' : ''}.`, 'warning');
}

function handleThemeUpload(event) {
    event.preventDefault();
    const theme = SportBoxPortal.addThemeUpload({
        name: document.getElementById('themeName').value,
        month: document.getElementById('themeMonth').value,
        items: document.getElementById('themeItems').value
    });
    showToast(`Theme "${theme.name}" uploaded successfully.`, 'success');
    document.getElementById('themeName').value = '';
    document.getElementById('themeMonth').value = '';
    document.getElementById('themeItems').value = '';
    renderAdminDashboard(SportBoxPortal.getCurrentAdmin());
}

document.addEventListener('DOMContentLoaded', () => {
    updateAuthAction();
    const session = SportBoxPortal.getSession();
    const customer = SportBoxPortal.getCurrentCustomer();
    const admin = SportBoxPortal.getCurrentAdmin();
    renderHeader(session, customer, admin);

    if (!session) {
        document.getElementById('emptyState').style.display = 'block';
        return;
    }

    if (session.role === 'admin' && admin) {
        renderAdminDashboard(admin);
        return;
    }

    if (customer) {
        renderCustomerDashboard(customer);
        updatePauseResumeUI();
        return;
    }

    document.getElementById('emptyState').style.display = 'block';
});

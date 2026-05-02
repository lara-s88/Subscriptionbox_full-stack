
const SportBoxPortal = (() => {
const DB_KEY = 'sportbox-db';
const SESSION_KEY = 'sportbox-session';
const seedDatabase = {
    admins: [
        { id: 'admin-1', name: 'Maya Carter', email: 'admin@sportbox.com', password: 'Admin123!', role: 'admin', title: 'Operations Admin' }
    ],
    customers: [
        {
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
            boxItems: ['Single-Origin Beans', 'Dark Roast', 'Filter Papers', 'Ceramic Mug', 'Mystery Item'],
            orderHistory: [
                { title: 'Football Pro Box', date: 'Mar 20, 2026', status: 'Delivered', amount: '$49.99' },
                { title: 'Gym Starter Box', date: 'Feb 25, 2026', status: 'Delivered', amount: '$39.99' },
                { title: 'Basketball Gear Pack', date: 'Jan 28, 2026', status: 'Returned', amount: '$59.99' },
                { title: 'Tennis Pro Kit', date: 'Dec 30, 2025', status: 'Delivered', amount: '$64.99' }
            ],
            delivery: { state: 'Shipped', trackingCode: 'SPX-789-XYZ', stopsAway: 9 },
            subscriptions: [
                { id: 'sub-1', name: 'Football Pro Box', status: 'active', nextBillingDate: '2026-04-27', price: '$49 / month' }
            ]
        }
    ],
    adminData: {
        orders: [
            { orderId: 'ORD-1001', customerId: 'cust-1', customerName: 'Alex Johnson', accountEmail: 'alex@sportbox.com', packageName: 'Football Pro Box', trackingCode: 'SPX-789-XYZ', deliveryState: 'Shipped', points: 1240, returned: true, returnReason: 'Damaged bottle shaker', batchId: 'BATCH-NORTH-12' }
        ],
        stock: [
            { item: 'Dark Roast', stock: 8, threshold: 10, theme: 'Coffee Edit' }
        ],
        themes: [
            { id: 'theme-1', name: 'Coffee Edit', month: 'May 2026', status: 'Ready', items: 5 }
        ],
        shippingBatches: [
            { batchId: 'BATCH-NORTH-12', region: 'North', orders: 28, warehouseState: 'Picking' }
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

function normalizeEmail(email) {
    return (email || '').trim().toLowerCase();
}

function authenticate(email, password, role) {
    const db = getDatabase();
    const list = role === 'admin' ? db.admins : db.customers;
    const account = list.find((item) => item.email === normalizeEmail(email) && item.password === password);
    if (!account) {
        return { ok: false, message: `No ${role} account matches those credentials.` };
    }
    localStorage.setItem(SESSION_KEY, JSON.stringify({
        id: account.id,
        role: account.role,
        name: account.name,
        email: account.email
    }));
    return { ok: true, account };
}

function registerCustomer(payload) {
    const db = getDatabase();
    const email = normalizeEmail(payload.email);
    const exists = [...db.customers, ...db.admins].some((item) => item.email === email);
    if (exists) {
        return { ok: false, message: 'An account with this email already exists.' };
    }
    const customer = {
        id: `cust-${Date.now()}`,
        name: `${payload.firstName} ${payload.lastName}`.trim(),
        email,
        password: payload.password,
        role: 'customer',
        tier: 'Basic',
        favoriteTheme: payload.favoriteTheme || 'Starter Box',
        points: 150,
        memberSince: new Date().toLocaleDateString('en-US', { month: 'short', year: 'numeric' }),
        nextBillingDate: '2026-05-01',
        nextDeliveryDate: '2026-05-05',
        boxCount: 0,
        daysToNextBox: 11,
        boxItems: ['Starter Pick', 'Welcome Card', 'Surprise Add-on'],
        orderHistory: [],
        delivery: { state: 'Pending', trackingCode: 'Pending assignment', stopsAway: 0 },
        subscriptions: [
            { id: `sub-${Date.now()}`, name: `${payload.favoriteTheme || 'Starter'} Box`, status: 'active', nextBillingDate: '2026-05-01', price: '$29 / month' }
        ]
    };
    db.customers.push(customer);
    saveDatabase(db);
    localStorage.setItem(SESSION_KEY, JSON.stringify({
        id: customer.id,
        role: customer.role,
        name: customer.name,
        email: customer.email
    }));
    return { ok: true, account: customer };
}

ensureDatabase();
return { authenticate, registerCustomer };
})();

function toggleDarkMode() {
const isDark = document.body.classList.toggle('dark-mode');
localStorage.setItem('sportbox-dark', isDark ? '1' : '0');
const icon = document.getElementById('darkModeToggle')?.querySelector('i');
if (icon) icon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
}

(function () {
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
    new bootstrap.Toast(el, { delay: 3000 }).show();
}
}

function getPortalSession() {
const raw = localStorage.getItem('sportbox-session');
return raw ? JSON.parse(raw) : null;
}

function handleLogout(event) {
event.preventDefault();
localStorage.removeItem('sportbox-session');
window.location.href = '/login';
}

function updateAuthUI() {
const session = getPortalSession();
const rewardNavItem = document.getElementById('rewardNavItem');
const footerRewardItem = document.getElementById('footerRewardItem');
const footerAuthLink = document.getElementById('footerAuthLink');
const footerRegisterItem = document.getElementById('footerRegisterItem');
const adminOnlyHiddenLinks = document.querySelectorAll(window.routeSelector('home', 'sports', 'subscriptions'));

if (rewardNavItem) rewardNavItem.style.display = session ? '' : 'none';
if (footerRewardItem) footerRewardItem.style.display = session ? '' : 'none';
adminOnlyHiddenLinks.forEach((link) => {
    link.closest('.nav-item').style.display = session?.role === 'admin' ? 'none' : '';
});

if (session) {
    if (footerAuthLink) {
        footerAuthLink.textContent = 'Logout';
        footerAuthLink.href = '#';
        footerAuthLink.onclick = handleLogout;
    }
    if (footerRegisterItem) footerRegisterItem.style.display = 'none';
}
}

function switchTab(tab, btn) {
document.querySelectorAll('#authPageTabs > .auth-tab-btn').forEach((button) => button.classList.remove('active'));
btn.classList.add('active');
document.getElementById('loginForm').style.display = tab === 'login' ? 'block' : 'none';
document.getElementById('registerForm').style.display = tab === 'register' ? 'block' : 'none';
updateDivider();
}

function selectLoginRole(role, btn) {
document.querySelectorAll('[data-role-btn]').forEach((button) => button.classList.remove('active'));
btn.classList.add('active');
document.getElementById('loginRole').value = role;
}

function togglePwd(id, btn) {
const input = document.getElementById(id);
const icon = btn.querySelector('i');
if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'bi bi-eye-slash text-muted';
} else {
    input.type = 'password';
    icon.className = 'bi bi-eye text-muted';
}
}

function handleLogin(event) {
event.preventDefault();
const result = SportBoxPortal.authenticate(
    document.getElementById('loginEmail').value,
    document.getElementById('loginPwd').value,
    document.getElementById('loginRole').value
);

if (!result.ok) {
    showToast(result.message, 'danger');
    return;
}

showToast(`${result.account.role === 'admin' ? 'Admin' : 'Customer'} login successful. Redirecting...`, 'success');
setTimeout(() => {
    window.location.href = "/dashboard";
}, 1200);
}

function handleRegister(event) {
event.preventDefault();
const stateCode = (document.getElementById('regStateCode')?.value || '').toUpperCase();
const serviceable = ['NY', 'NJ', 'CT'];
if (!serviceable.includes(stateCode)) {
    showToast('Address is outside the current serviceable zone.', 'danger');
    return;
}

const result = SportBoxPortal.registerCustomer({
    firstName: document.getElementById('regFirstName').value,
    lastName: document.getElementById('regLastName').value,
    email: document.getElementById('regEmail').value,
    password: document.getElementById('regPwd').value,
    favoriteTheme: document.getElementById('regFavoriteSport').value
});

if (!result.ok) {
    showToast(result.message, 'danger');
    return;
}

showToast('Account created and saved in the app database.', 'success');
setTimeout(() => {
    window.location.href = '/dashboard';
}, 1200);
}

function socialLogin(provider) {
showToast(`Signing in with ${provider} is a UI placeholder for now.`, 'primary');
}

function updateDivider() {
const span = document.querySelector('.text-center.text-muted.small span[style]');
if (span) span.style.background = document.body.classList.contains('dark-mode') ? '#1e293b' : 'white';
}

document.addEventListener('DOMContentLoaded', () => {
updateAuthUI();
updateDivider();
});

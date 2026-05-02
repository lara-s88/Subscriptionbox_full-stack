
const addOnCatalog = ['Protein Sampler', 'Grip Gloves', 'Massage Roller', 'Vitamin Pack', 'Mystery Sticker Pack'];

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
function getPortalSession() {
const raw = localStorage.getItem('sportbox-session');
return raw ? JSON.parse(raw) : null;
}
function handleLogout(event) {
event.preventDefault();
localStorage.removeItem('sportbox-session');
window.location.href = sportBoxRoute('home');
}
function updateAuthUI() {
const session = getPortalSession();
const rewardNavItem = document.getElementById('rewardNavItem');
const authActionLink = document.getElementById('authActionLink');
const footerAuthLink = document.getElementById('footerAuthLink');
const adminOnlyHiddenLinks = document.querySelectorAll('.navbar .nav-link[href="index.html"], .navbar .nav-link[href="sports.html"], .navbar .nav-link[href="plans.html"]');
if (rewardNavItem) rewardNavItem.style.display = session ? '' : 'none';
adminOnlyHiddenLinks.forEach((link) => {
    link.closest('.nav-item').style.display = session?.role === 'admin' ? 'none' : '';
});
if (session) {
    if (authActionLink) {
        authActionLink.textContent = 'Logout';
        authActionLink.href = '#';
        authActionLink.onclick = handleLogout;
    }
    if (footerAuthLink) {
        footerAuthLink.textContent = 'Logout';
        footerAuthLink.href = '#';
        footerAuthLink.onclick = handleLogout;
    }
}
}
function showToast(msg, type = 'success') {
const el = document.getElementById('mainToast');
const msgEl = document.getElementById('toastMsg');
if (msgEl) msgEl.textContent = msg;
if (el) { el.className = `toast align-items-center border-0 text-bg-${type}`; new bootstrap.Toast(el, { delay: 3000 }).show(); }
}
function getCart() {
const session = getPortalSession();
if (!session || session.role !== 'customer') return [];
const allCarts = JSON.parse(localStorage.getItem('sportbox-cart-store') || '{}');
return allCarts[session.id] || [];
}
function saveCart(cart) {
const session = getPortalSession();
if (!session || session.role !== 'customer') return;
const allCarts = JSON.parse(localStorage.getItem('sportbox-cart-store') || '{}');
allCarts[session.id] = cart;
localStorage.setItem('sportbox-cart-store', JSON.stringify(allCarts));
}
function removeCartItem(cartId) {
const cart = getCart().filter((item) => item.cartId !== cartId);
saveCart(cart);
renderCart();
showToast('Item removed from cart.', 'warning');
}
function addAddOn(cartId, addOnName) {
const cart = getCart();
const item = cart.find((entry) => entry.cartId === cartId);
if (!item) return;
item.addOns = item.addOns || [];
if (!item.addOns.includes(addOnName)) {
    item.addOns.push(addOnName);
    saveCart(cart);
    renderCart();
    showToast(`${addOnName} added with no extra shipping fee.`, 'success');
}
}
function confirmShipping() {
const cart = getCart();
if (!cart.length) {
    showToast('Your cart is empty.', 'warning');
    return;
}
cart.forEach((item) => { item.shippingStatus = 'Shipping Confirmed'; });
saveCart(cart);
renderCart();
showToast('Shipping confirmed for the boxes in your cart.', 'success');
}
function renderCart() {
const session = getPortalSession();
const cartList = document.getElementById('cartList');
if (!session || session.role !== 'customer') {
    document.getElementById('guestState').style.display = 'block';
    document.getElementById('emptyState').style.display = 'none';
    cartList.innerHTML = '';
    document.getElementById('confirmShippingBtn').disabled = true;
    return;
}

const cart = getCart();
document.getElementById('guestState').style.display = 'none';
document.getElementById('emptyState').style.display = cart.length ? 'none' : 'block';
document.getElementById('confirmShippingBtn').disabled = !cart.length;
cartList.innerHTML = '';

cart.forEach((item) => {
    const availableAddOns = addOnCatalog.filter((addOn) => !(item.addOns || []).includes(addOn));
    const card = document.createElement('div');
    card.className = 'cart-card';
    card.innerHTML = `
        <div class="row g-3">
            <div class="col-md-4">
                <img src="${item.image}" alt="${item.title}" class="w-100 rounded-4" style="height:180px;object-fit:cover;">
            </div>
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                    <div>
                        <h5 class="fw-bold mb-1">${item.title}</h5>
                        <div class="text-muted small">${item.type} box · ${item.frequency || 'Monthly'} delivery</div>
                    </div>
                    <span class="badge rounded-pill px-3" style="background:${item.shippingStatus === 'Shipping Confirmed' ? 'rgba(16,185,129,.12)' : 'rgba(245,158,11,.16)'};color:${item.shippingStatus === 'Shipping Confirmed' ? '#059669' : '#b45309'};">${item.shippingStatus || 'Pending Confirmation'}</span>
                </div>
                <div class="small mb-2"><span class="text-muted">Size:</span> <span class="fw-semibold">${item.size || 'M'}</span></div>
                <div class="small mb-2"><span class="text-muted">Diet:</span> <span class="fw-semibold">${item.diet || 'Standard'}</span></div>
                <div class="small mb-3"><span class="text-muted">Items:</span> <span class="fw-semibold">${(item.items || []).join(', ')}</span></div>
                <div class="small fw-semibold mb-2">Add-ons for this shipment</div>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    ${(item.addOns || []).map((addOn) => `<span class="badge rounded-pill px-3 py-2" style="background:rgba(16,185,129,.1);color:var(--primary);">${addOn}</span>`).join('') || '<span class="text-muted small">No add-ons selected.</span>'}
                </div>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    ${availableAddOns.slice(0, 4).map((addOn) => `<button class="addon-chip" onclick="addAddOn('${item.cartId}', '${addOn}')"><i class="bi bi-plus me-1"></i>${addOn}</button>`).join('')}
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-primary fs-5">$${Number(item.price || 0).toFixed(2)}</span>
                    <button class="btn btn-outline-danger btn-sm" onclick="removeCartItem('${item.cartId}')"><i class="bi bi-trash me-1"></i>Remove</button>
                </div>
            </div>
        </div>
    `;
    cartList.appendChild(card);
});

const addOnCount = cart.reduce((sum, item) => sum + ((item.addOns || []).length), 0);
const total = cart.reduce((sum, item) => sum + Number(item.price || 0), 0);
document.getElementById('summaryCount').textContent = cart.length;
document.getElementById('summaryAddOns').textContent = addOnCount;
document.getElementById('summaryTotal').textContent = `$${total.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', () => {
updateAuthUI();
renderCart();
});

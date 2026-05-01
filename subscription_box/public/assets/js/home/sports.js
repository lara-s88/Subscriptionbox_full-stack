

/* ---- Dark Mode ---- */
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

function getPortalSession() {
const raw = localStorage.getItem('sportbox-session');
return raw ? JSON.parse(raw) : null;
}

function handleLogout(event) {
event.preventDefault();
localStorage.removeItem('sportbox-session');
window.location.href = 'index.html';
}

function updateAuthUI() {
const session = getPortalSession();
const rewardNavItem = document.getElementById('rewardNavItem');
const footerRewardItem = document.getElementById('footerRewardItem');
const authActionLink = document.getElementById('authActionLink');
const footerAuthLink = document.getElementById('footerAuthLink');
const adminOnlyHiddenLinks = document.querySelectorAll(
    '.navbar .nav-link[href="index.html"], .navbar .nav-link[href="sports.html"], .navbar .nav-link[href="plans.html"]'
);
if (rewardNavItem) rewardNavItem.style.display = session ? '' : 'none';
if (footerRewardItem) footerRewardItem.style.display = session ? '' : 'none';
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

function getCustomerCart() {
const session = getPortalSession();
if (!session || session.role !== 'customer') return [];
const allCarts = JSON.parse(localStorage.getItem('sportbox-cart-store') || '{}');
return allCarts[session.id] || [];
}

function saveCustomerCart(cart) {
const session = getPortalSession();
if (!session || session.role !== 'customer') return false;
const allCarts = JSON.parse(localStorage.getItem('sportbox-cart-store') || '{}');
allCarts[session.id] = cart;
localStorage.setItem('sportbox-cart-store', JSON.stringify(allCarts));
return true;
}

function upsertCartItem(item) {
const cart = getCustomerCart();
const index = cart.findIndex((entry) => entry.cartId === item.cartId);
if (index >= 0) cart[index] = item;
else cart.push(item);
return saveCustomerCart(cart);
}

/* ---- Toast ---- */
function showToast(msg, type = 'success') {
const el = document.getElementById('mainToast');
const msgEl = document.getElementById('toastMsg');
if (msgEl) msgEl.textContent = msg;
if (el) {
    el.className = `toast align-items-center border-0 text-bg-${type}`;
    new bootstrap.Toast(el, {
        delay: 3000
    }).show();
}
}

/* ---- State ---- */
let activeFilter = 'all';
let searchQuery = '';
let selectedBox = null;

const typeColors = {
clothing: '#3b82f6',
equipment: '#10b981',
diet: '#f59e0b'
};

/* ---- Build filter tabs from mock data ---- */
function initFilterTabs() {
const wrap = document.getElementById('filterTabsWrap');
mockData.sports.forEach(sport => {
    const btn = document.createElement('button');
    btn.className = 'filter-tab';
    btn.dataset.sport = sport.id;
    btn.textContent = sport.name;
    btn.onclick = () => filterSport(sport.id, btn);
    wrap.appendChild(btn);
});
}

/* ---- Filter handler ---- */
function filterSport(filter, btn) {
activeFilter = filter;
searchQuery = '';
const searchInput = document.getElementById('searchInput');
if (searchInput) searchInput.value = '';
document.querySelectorAll('#filterTabsWrap .filter-tab').forEach(b => b.classList.remove('active'));
if (btn) btn.classList.add('active');
renderGrid();
}

/* ---- Search handler ---- */
function handleSearch() {
searchQuery = (document.getElementById('searchInput')?.value || '').toLowerCase().trim();
renderGrid();
}

/* ---- Skeleton loader ---- */
function showSkeletons(count) {
const sg = document.getElementById('skeletonGrid');
sg.innerHTML = '';
sg.style.display = '';
document.getElementById('sports-grid').style.display = 'none';
for (let i = 0; i < count; i++) {
    sg.innerHTML += `
        <div class="col-md-6 col-lg-3">
            <div class="skeleton-card">
                <div class="skeleton" style="height:200px;border-radius:0;"></div>
                <div class="p-4">
                    <div class="skeleton mb-2" style="height:18px;width:65%;"></div>
                    <div class="skeleton mb-3" style="height:13px;width:90%;"></div>
                    <div class="skeleton" style="height:13px;width:40%;"></div>
                </div>
            </div>
        </div>`;
}
}

/* ---- Main render ---- */
function renderGrid() {
const grid = document.getElementById('sports-grid');
const skeleton = document.getElementById('skeletonGrid');
const empty = document.getElementById('emptyState');
const header = document.getElementById('sectionHeader');

grid.innerHTML = '';
empty.style.display = 'none';

if (activeFilter === 'all') {
    /* --- Sport overview cards --- */
    let sports = mockData.sports;
    if (searchQuery) {
        sports = sports.filter(s =>
            s.name.toLowerCase().includes(searchQuery) ||
            s.description.toLowerCase().includes(searchQuery)
        );
    }

    header.innerHTML =
        `
        <h4 class="fw-bold mb-1">All Sports</h4>
        <p class="text-muted small mb-0">${sports.length} sport${sports.length !== 1 ? 's' : ''} available</p>`;

    skeleton.style.display = 'none';

    if (sports.length === 0) {
        empty.style.display = 'block';
        return;
    }

    grid.style.display = '';
    sports.forEach(sport => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-3 animate-in';
        col.innerHTML = `
            <div class="sport-card h-100" style="cursor:pointer;"
                    onclick="filterSport(${sport.id}, document.querySelector('[data-sport=\\'${sport.id}\\']'))">
                <img src="${sport.image}" class="card-img-top" alt="${sport.name}" style="height:200px;object-fit:cover;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi ${sport.icon} text-primary fs-5"></i>
                        <h5 class="card-title fw-bold mb-0">${sport.name}</h5>
                    </div>
                    <p class="card-text text-muted small mb-3">${sport.description}</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small">${sport.boxes.length} boxes</span>
                        <span class="text-primary fw-semibold small">Browse <i class="bi bi-arrow-right ms-1"></i></span>
                    </div>
                </div>
            </div>`;
        grid.appendChild(col);
    });

} else {
    /* --- Box cards for selected sport --- */
    const sport = mockData.sports.find(s => s.id == activeFilter);
    if (!sport) return;

    let boxes = sport.boxes;
    if (searchQuery) {
        boxes = boxes.filter(b =>
            b.title.toLowerCase().includes(searchQuery) ||
            b.type.toLowerCase().includes(searchQuery)
        );
    }

    header.innerHTML =
        `
        <div class="d-flex align-items-center gap-3 mb-1 flex-wrap">
            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                    onclick="filterSport('all', document.querySelector('[data-sport=all]'))">
                <i class="bi bi-arrow-left me-1"></i>All Sports
            </button>
            <h4 class="fw-bold mb-0">${sport.name} Boxes</h4>
        </div>
        <p class="text-muted small mb-0">${boxes.length} box${boxes.length !== 1 ? 'es' : ''} available</p>`;

    skeleton.style.display = 'none';

    if (boxes.length === 0) {
        grid.style.display = 'none';
        empty.style.display = 'block';
        return;
    }

    grid.style.display = '';
    boxes.forEach(box => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4 animate-in';
        const color = typeColors[box.type] || '#10b981';
        col.innerHTML = `
            <div class="box-card h-100" style="cursor:pointer;" onclick="openBoxModal(${box.id})">
                <div class="overflow-hidden" style="height:190px;">
                    <img src="${box.image}" alt="${box.title}" class="box-card-img">
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0 flex-grow-1 pe-2">${box.title}</h6>
                        <span class="type-badge" style="background:${color}18;color:${color};">${box.type}</span>
                    </div>
                    <p class="text-muted small mb-3">${box.items.length} premium items included</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-primary fs-5">${box.price}</span>
                        <a href="customize.html?box=${box.id}" class="btn btn-primary btn-sm px-3"
                            onclick="event.stopPropagation()">
                            <i class="bi bi-pencil-square me-1"></i>Customize
                        </a>
                    </div>
                </div>
            </div>`;
        grid.appendChild(col);
    });
}
}

/* ---- Open box modal ---- */
function openBoxModal(boxId) {
const box = boxLookup[boxId];
if (!box) return;
selectedBox = box;

document.getElementById('modalTitle').textContent = box.sportName + ' Box';
document.getElementById('modalImage').src = box.image;
document.getElementById('modalImage').alt = box.title;
document.getElementById('modalBoxTitle').textContent = box.title;
document.getElementById('modalPrice').textContent = box.price;
document.getElementById('customizeBtn').href = `customize.html?box=${box.id}`;

const itemsEl = document.getElementById('modalItems');
itemsEl.innerHTML = '<p class="fw-semibold small mb-2">What\'s inside:</p>';
const wrap = document.createElement('div');
wrap.className = 'd-flex flex-wrap gap-2';
box.items.forEach(item => {
    const span = document.createElement('span');
    span.className = 'badge rounded-pill px-3 py-2';
    span.style.cssText = 'background:rgba(16,185,129,.1);color:var(--primary);font-size:.8rem;';
    span.textContent = item;
    wrap.appendChild(span);
});
itemsEl.appendChild(wrap);

new bootstrap.Modal(document.getElementById('boxModal')).show();
}

/* ---- Add to cart (demo) ---- */
function addToCart() {
const session = getPortalSession();
if (!session || session.role !== 'customer') {
    showToast('Please log in as a customer to add boxes to your cart.', 'warning');
    setTimeout(() => {
        window.location.href = 'auth.html';
    }, 900);
    return;
}
if (!selectedBox) return;
upsertCartItem({
    cartId: `box-${selectedBox.id}`,
    boxId: selectedBox.id,
    title: selectedBox.title,
    type: selectedBox.type,
    image: selectedBox.image,
    price: Number(selectedBox.price),
    items: [...selectedBox.items],
    size: 'M',
    diet: 'Standard',
    frequency: 'Monthly',
    addOns: [],
    shippingStatus: 'Pending Confirmation'
});
bootstrap.Modal.getInstance(document.getElementById('boxModal'))?.hide();
showToast('Added to cart. You can confirm shipping from the cart page.', 'success');
}

/* ---- Init ---- */
document.addEventListener('DOMContentLoaded', () => {
updateAuthUI();
initFilterTabs();
showSkeletons(4);
setTimeout(() => {
    document.getElementById('skeletonGrid').style.display = 'none';
    renderGrid();
}, 900);
});

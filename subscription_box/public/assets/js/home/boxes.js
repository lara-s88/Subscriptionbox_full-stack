
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
    window.location.href = 'index.html';
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
function showToast(msg, type = 'success') {
    const el = document.getElementById('mainToast');
    const msgEl = document.getElementById('toastMsg');
    if (msgEl) msgEl.textContent = msg;
    if (el) { el.className = `toast align-items-center border-0 text-bg-${type}`; new bootstrap.Toast(el, { delay: 3000 }).show(); }
}

const mockData = {
    sports: [
        { id: 1, name: 'Football', desc: 'Premium curated boxes for football enthusiasts', boxes: [
            { id: 1, title: 'Football Clothing Box', price: 49.99, image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'clothing', desc: 'Authentic jerseys, shorts and performance wear.', items: ['Jersey (S-XXL)', 'Training Shorts', 'Socks', 'Cap'] },
            { id: 2, title: 'Equipment Essentials', price: 69.99, image: 'https://images.pexels.com/photos/46798/the-ball-stadion-football-the-pitch-46798.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'equipment', desc: 'Everything you need on the training pitch.', items: ['Soccer Ball', 'Shin Guards', 'Training Cones', 'Water Bottle'] },
            { id: 3, title: 'Diet & Recovery', price: 39.99, image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'diet', desc: 'Fuel your performance and accelerate recovery.', items: ['Protein Powder', 'Energy Bars', 'Recovery Drink', 'Vitamin Pack'] }
        ]},
        { id: 2, name: 'Basketball', desc: 'Premium curated boxes for basketball players', boxes: [
            { id: 4, title: 'Basketball Gear Pack', price: 59.99, image: 'https://images.pexels.com/photos/1752757/pexels-photo-1752757.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'equipment', desc: 'Top gear for the court.', items: ['Basketball', 'Knee Pads', 'Grip Tape', 'Pump'] },
            { id: 5, title: 'Performance Apparel', price: 44.99, image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'clothing', desc: 'Breathable sportswear for peak performance.', items: ['Shooting Shirt', 'Basketball Shorts', 'Ankle Socks', 'Headband'] },
            { id: 6, title: 'Nutrition Starter', price: 34.99, image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'diet', desc: 'Nutrition essentials for athletes.', items: ['Whey Protein', 'Pre-Workout', 'BCAA Drink', 'Electrolytes'] }
        ]},
        { id: 3, name: 'Gym', desc: 'Premium curated boxes for gym lovers', boxes: [
            { id: 7, title: 'Strength Training Kit', price: 54.99, image: 'https://images.pexels.com/photos/416717/pexels-photo-416717.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'equipment', desc: 'Build power with premium training tools.', items: ['Resistance Bands', 'Jump Rope', 'Gloves', 'Chalk'] },
            { id: 8, title: 'Workout Apparel', price: 39.99, image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'clothing', desc: 'Flex in style with moisture-wicking apparel.', items: ['Gym Tank', 'Leggings', 'Sports Bra', 'Compression Sleeves'] },
            { id: 9, title: 'Muscle Builder Pack', price: 49.99, image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'diet', desc: 'Science-backed nutrition for gains.', items: ['Creatine', 'Mass Gainer', 'BCAAs', 'Test Booster'] }
        ]},
        { id: 4, name: 'Tennis', desc: 'Premium curated boxes for tennis players', boxes: [
            { id: 10, title: 'Tennis Pro Kit', price: 64.99, image: 'https://images.pexels.com/photos/209977/pexels-photo-209977.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'equipment', desc: 'Court-ready equipment for every level.', items: ['Tennis Racket', 'Pressure Balls', 'Overgrip', 'Vibration Dampener'] },
            { id: 11, title: 'Court Apparel', price: 42.99, image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'clothing', desc: 'Stylish and breathable court wear.', items: ['Polo Shirt', 'Tennis Shorts', 'Wristbands', 'Visor'] },
            { id: 12, title: 'Endurance Fuel', price: 37.99, image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=800', type: 'diet', desc: 'Stay hydrated and energized on the court.', items: ['Electrolyte Tabs', 'Energy Gels', 'Recovery Shake', 'Magnesium'] }
        ]}
    ]
};

const sportParam = new URLSearchParams(window.location.search).get('sport') || 'football';
const sportData = mockData.sports.find(s => s.name.toLowerCase() === sportParam.toLowerCase()) || mockData.sports[0];
let allBoxes = sportData.boxes;
let activeType = 'all', activePrice = 'all', searchQuery = '';

function init() {
    document.getElementById('sportTitle').textContent = sportData.name + ' Boxes';
    document.getElementById('sportDesc').textContent = sportData.desc;
    showSkeletons();
    setTimeout(() => { renderBoxes(); document.getElementById('skeletonGrid').style.display = 'none'; }, 1200);
}

function showSkeletons() {
    const grid = document.getElementById('skeletonGrid');
    grid.innerHTML = '';
    for (let i = 0; i < 3; i++) {
        grid.innerHTML += `<div class="col-md-6 col-lg-4"><div class="skeleton-card"><div class="skeleton" style="height:190px;border-radius:0;"></div><div class="p-3"><div class="skeleton mb-2" style="height:20px;width:70%;"></div><div class="skeleton mb-3" style="height:14px;width:40%;"></div><div class="skeleton" style="height:36px;border-radius:20px;"></div></div></div></div>`;
    }
}

function getFilteredBoxes() {
    return allBoxes.filter(b => {
        const matchType = activeType === 'all' || b.type === activeType;
        const matchPrice = activePrice === 'all' ||
            (activePrice === 'under40' && b.price < 40) ||
            (activePrice === '40to60' && b.price >= 40 && b.price <= 60) ||
            (activePrice === 'over60' && b.price > 60);
        const matchSearch = !searchQuery || b.title.toLowerCase().includes(searchQuery) || b.type.toLowerCase().includes(searchQuery);
        return matchType && matchPrice && matchSearch;
    });
}

function renderBoxes() {
    const grid = document.getElementById('boxGrid');
    const empty = document.getElementById('emptyState');
    const count = document.getElementById('resultsCount');
    const filtered = getFilteredBoxes();
    grid.style.display = filtered.length ? 'flex' : 'none';
    grid.className = 'row g-4';
    empty.style.display = filtered.length ? 'none' : 'block';
    count.textContent = `Showing ${filtered.length} box${filtered.length !== 1 ? 'es' : ''}`;
    grid.innerHTML = '';
    const typeColors = { clothing: '#3b82f6', equipment: '#10b981', diet: '#f59e0b' };
    filtered.forEach(b => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4 animate-in';
        col.innerHTML = `
            <div class="box-card h-100" onclick="openModal(${b.id})" style="cursor:pointer;">
                <div class="overflow-hidden" style="height:190px;">
                    <img src="${b.image}" alt="${b.title}" class="box-card-img">
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0 flex-grow-1 pe-2">${b.title}</h6>
                        <span class="type-badge" style="background:${typeColors[b.type]}18;color:${typeColors[b.type]};">${b.type}</span>
                    </div>
                    <p class="text-muted small mb-3" style="font-size:.82rem;">${b.desc}</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold text-primary fs-5">$${b.price}</span>
                        <a href="customize.html?box=${b.id}" class="btn btn-primary btn-sm px-3" onclick="event.stopPropagation()"><i class="bi bi-pencil-square me-1"></i>Customize</a>
                    </div>
                </div>
            </div>`;
        grid.appendChild(col);
    });
}

function filterType(type, btn) {
    activeType = type;
    document.querySelectorAll('#typeFilters .filter-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderBoxes();
}
function filterPrice(price, btn) {
    activePrice = price;
    document.querySelectorAll('#priceFilters .price-filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderBoxes();
}
function searchBoxes() {
    searchQuery = document.getElementById('searchInput').value.toLowerCase().trim();
    renderBoxes();
}
function resetFilters() {
    activeType = 'all'; activePrice = 'all'; searchQuery = '';
    document.getElementById('searchInput').value = '';
    document.querySelectorAll('.filter-tab')[0].click();
    document.querySelectorAll('.price-filter-btn')[0].click();
}

let selectedBox = null;
function openModal(id) {
    selectedBox = allBoxes.find(b => b.id === id);
    if (!selectedBox) return;
    document.getElementById('modalImg').src = selectedBox.image;
    document.getElementById('modalTitle').textContent = selectedBox.title;
    document.getElementById('modalPrice').textContent = '$' + selectedBox.price;
    document.getElementById('modalDesc').textContent = selectedBox.desc;
    const items = document.getElementById('modalItems');
    items.innerHTML = '';
    selectedBox.items.forEach(item => {
        const s = document.createElement('span');
        s.className = 'badge rounded-pill px-3 py-2';
        s.style.cssText = 'background:rgba(16,185,129,.1);color:var(--primary);font-size:.8rem;';
        s.textContent = item;
        items.appendChild(s);
    });
    new bootstrap.Modal(document.getElementById('boxModal')).show();
}

function addToCart() {
    const session = getPortalSession();
    if (!session || session.role !== 'customer') {
        showToast('Please log in as a customer to add boxes to your cart.', 'warning');
        setTimeout(() => { window.location.href = 'auth.html'; }, 900);
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

document.addEventListener('DOMContentLoaded', init);
document.addEventListener('DOMContentLoaded', updateAuthUI);

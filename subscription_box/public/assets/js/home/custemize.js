
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

// Mock box data
const boxes = {
    1: { title: 'Football Clothing Box', type: 'Clothing', image: 'https://images.pexels.com/photos/2294361/pexels-photo-2294361.jpeg?auto=compress&cs=tinysrgb&w=800', price: 49.99, items: ['Jersey (M)', 'Training Shorts', 'Socks', 'Cap'] },
    2: { title: 'Equipment Essentials', type: 'Equipment', image: 'https://images.pexels.com/photos/46798/the-ball-stadion-football-the-pitch-46798.jpeg?auto=compress&cs=tinysrgb&w=800', price: 69.99, items: ['Soccer Ball', 'Shin Guards', 'Training Cones', 'Water Bottle'] },
    3: { title: 'Diet & Recovery', type: 'Diet', image: 'https://images.pexels.com/photos/841130/pexels-photo-841130.jpeg?auto=compress&cs=tinysrgb&w=800', price: 39.99, items: ['Protein Powder', 'Energy Bars', 'Recovery Drink', 'Vitamin Pack'] },
};
const extras = {
    clothing: ['Extra Jersey', 'Compression Shorts', 'Sports Headband', 'Grip Gloves', 'Athletic Tape'],
    equipment: ['Resistance Band', 'Training Whistle', 'Speed Ladder', 'Foam Roller', 'Gym Bag'],
    diet: ['Multivitamins', 'Omega-3 Capsules', 'Electrolyte Sachets', 'Collagen Powder', 'Sleep Support'],
};

const boxId = parseInt(new URLSearchParams(window.location.search).get('box')) || 1;
const box = boxes[boxId] || boxes[1];
let currentItems = [...box.items];
let selectedSize = 'M', selectedDiet = 'Standard', selectedFreq = 'Monthly';
const allergyProfile = ['peanuts'];
const preferenceProfile = ['no spicy foods'];
const surpriseHistory = ['Mystery Item'];

function isSwapLocked(hoursUntilShip) { return hoursUntilShip <= 48; }
function hasAllergyConflict(itemIngredients, profile) {
    const text = itemIngredients.join(' ').toLowerCase();
    return profile.some((allergy) => text.includes(allergy));
}
function validateSwap(data) {
    if (data.itemWeight > data.maxWeight) return { ok: false, reason: 'Swap exceeds shipment weight cap' };
    if (!data.compatibilityTags.includes('allowed')) return { ok: false, reason: 'Swap dependency invalid' };
    return { ok: true };
}
function pickPersonalizedSurprise(candidates, preferences, history) {
    const filtered = candidates.filter((item) => !preferences.some((p) => item.toLowerCase().includes(p.replace('no ', ''))));
    return filtered.find((item) => !history.includes(item)) || filtered[0] || 'Surprise Sampler';
}
function addOnToNextBox(itemName, price) { return { itemName, price }; }

function init() {
    document.getElementById('boxTitle').textContent = 'Customize: ' + box.title;
    document.getElementById('boxSubtitle').textContent = box.type + ' Box — $' + box.price;
    document.getElementById('summaryTitle').textContent = box.title;
    document.getElementById('summaryType').textContent = box.type + ' Box';
    document.getElementById('summaryImg').src = box.image;
    document.getElementById('summaryPrice').textContent = '$' + box.price;
    renderItems();
    renderAvailable();
}

function renderItems() {
    const list = document.getElementById('itemsList');
    const count = document.getElementById('itemCount');
    const sumCount = document.getElementById('summaryCount');
    list.innerHTML = '';
    count.textContent = currentItems.length + ' item' + (currentItems.length !== 1 ? 's' : '');
    sumCount.textContent = currentItems.length + ' item' + (currentItems.length !== 1 ? 's' : '');

    currentItems.forEach((item, i) => {
        const div = document.createElement('div');
        div.className = 'item-row';
        div.draggable = true;
        div.innerHTML = `
            <i class="bi bi-grip-vertical item-drag fs-5"></i>
            <div class="flex-grow-1">
                <div class="fw-semibold small">${item}</div>
                <div class="text-muted" style="font-size:.75rem;">Included in your box</div>
            </div>
            <button class="btn btn-sm px-2" style="color:#ef4444;border:none;background:transparent;" onclick="removeItem(${i})" title="Remove">
                <i class="bi bi-x-circle fs-5"></i>
            </button>`;
        list.appendChild(div);
    });

    if (currentItems.length === 0) {
        list.innerHTML = '<div class="text-center py-4 text-muted"><i class="bi bi-inbox display-5 d-block mb-2"></i><span class="small">No items in box. Add some below!</span></div>';
    }
    renderAvailable();
}

function renderAvailable() {
    const avail = document.getElementById('availableItems');
    avail.innerHTML = '';
    const typeKey = box.type.toLowerCase();
    const pool = extras[typeKey] || extras.clothing;
    pool.filter(e => !currentItems.includes(e)).forEach(item => {
        const btn = document.createElement('button');
        btn.className = 'add-item-chip';
        btn.innerHTML = `<i class="bi bi-plus me-1"></i>${item}`;
        btn.onclick = () => addItem(item);
        avail.appendChild(btn);
    });
    if (avail.children.length === 0) {
        avail.innerHTML = '<span class="text-muted small">All available items added!</span>';
    }
}

function removeItem(i) {
    const removed = currentItems.splice(i, 1)[0];
    showToast(`"${removed}" removed from box`, 'warning');
    renderItems();
}

function addItem(item) {
    const lockIn = isSwapLocked(72);
    if (lockIn) {
        showToast('Swaps are locked 48 hours before shipping.', 'warning');
        return;
    }
    currentItems.push(item);
    showToast(`"${item}" added to box! 📦`, 'success');
    renderItems();
}

function selectSize(btn) {
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedSize = btn.textContent.trim();
    document.getElementById('summarySize').textContent = selectedSize;
}

function selectPref(group, btn) {
    btn.closest('.d-flex').querySelectorAll('.pref-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const val = btn.textContent.trim();
    if (group === 'diet') { selectedDiet = val; document.getElementById('summaryDiet').textContent = val; }
    if (group === 'freq') { selectedFreq = val; document.getElementById('summaryFreq').textContent = val; }
}

function confirmSelection() {
    const session = getPortalSession();
    if (!session || session.role !== 'customer') {
        showToast('Please log in as a customer to save this box to your cart.', 'warning');
        setTimeout(() => { window.location.href = 'auth.html'; }, 900);
        return;
    }
    if (currentItems.length === 0) { showToast('Please add at least one item to your box!', 'warning'); return; }
    const allergyConflict = hasAllergyConflict(['coffee beans', 'peanuts'], allergyProfile);
    if (allergyConflict) {
        showToast('Allergy profile conflict detected. Please remove restricted items.', 'danger');
        return;
    }
    const swapCheck = validateSwap({
        boxSize: 'medium',
        itemWeight: 1.5,
        maxWeight: 5,
        compatibilityTags: ['allowed']
    });
    if (!swapCheck.ok) {
        showToast(swapCheck.reason, 'danger');
        return;
    }
    const surprise = pickPersonalizedSurprise(
        ['Citrus Roast', 'Mystery Item', 'No Spicy Blend'],
        preferenceProfile,
        surpriseHistory
    );
    const addOn = addOnToNextBox('Reusable Filter Set', 9.99);
    upsertCartItem({
        cartId: `box-${boxId}`,
        boxId,
        title: box.title,
        type: box.type,
        image: box.image,
        price: Number(box.price),
        items: [...currentItems],
        size: selectedSize,
        diet: selectedDiet,
        frequency: selectedFreq,
        addOns: [addOn.itemName],
        shippingStatus: 'Pending Confirmation',
        surprise
    });
    showToast('Saved to cart. Your add-on will ship with the same box at no extra shipping fee.', 'success');
    new bootstrap.Modal(document.getElementById('successModal')).show();
}

document.addEventListener('DOMContentLoaded', () => {
    updateAuthUI();
    init();
});

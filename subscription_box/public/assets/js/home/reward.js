
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
const footerRewardItem = document.getElementById('footerRewardItem');
const authActionLink = document.getElementById('authActionLink');
const footerAuthLink = document.getElementById('footerAuthLink');
const adminOnlyHiddenLinks = document.querySelectorAll('.navbar .nav-link[href="index.html"], .navbar .nav-link[href="sports.html"], .navbar .nav-link[href="plans.html"]');
if (!session) {
    window.location.href = sportBoxRoute('login');
    return false;
}
if (rewardNavItem) rewardNavItem.style.display = '';
if (footerRewardItem) footerRewardItem.style.display = '';
adminOnlyHiddenLinks.forEach((link) => {
    link.closest('.nav-item').style.display = session.role === 'admin' ? 'none' : '';
});
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
return true;
}
function getRewardDatabase() {
const raw = localStorage.getItem('sportbox-db');
return raw ? JSON.parse(raw) : { customers: [] };
}
function showToast(msg, type = 'success') {
const el = document.getElementById('mainToast');
const msgEl = document.getElementById('toastMsg');
if (msgEl) msgEl.textContent = msg;
if (el) { el.className = `toast align-items-center border-0 text-bg-${type}`; new bootstrap.Toast(el, { delay: 3000 }).show(); }
}

// Mock Data
const friends = [
{ name: 'Jordan Lee', date: 'Mar 10, 2024', points: 200, avatar: 'https://i.pravatar.cc/44?u=jordan' },
{ name: 'Sam Rivera', date: 'Feb 5, 2024', points: 200, avatar: 'https://i.pravatar.cc/44?u=sam' },
{ name: 'Taylor Kim', date: 'Jan 18, 2024', points: 200, avatar: 'https://i.pravatar.cc/44?u=taylor' },
];
const tiers = [
{ name: 'Bronze', icon: '🥉', min: 0, max: 500, color: '#cd7f32' },
{ name: 'Silver', icon: '🥈', min: 500, max: 2000, color: '#9ca3af', current: true },
{ name: 'Gold', icon: '🥇', min: 2000, max: 5000, color: '#f59e0b' },
{ name: 'Platinum', icon: '💎', min: 5000, max: null, color: '#8b5cf6' },
];
const rewards = [
{ title: '10% Off Next Box', pts: 300, icon: 'bi-percent', color: '#10b981', available: true },
{ title: 'Free Item Upgrade', pts: 500, icon: 'bi-arrow-up-circle', color: '#3b82f6', available: true },
{ title: 'Bonus Mystery Item', pts: 800, icon: 'bi-question-circle', color: '#f59e0b', available: false },
{ title: 'Free Month Pro', pts: 1500, icon: 'bi-star', color: '#8b5cf6', available: false },
];
const referralCode = 'SUBBOX123';
let userPoints = 1240;

function getTierLabel(points) {
if (points >= 5000) return 'Platinum';
if (points >= 2000) return 'Gold';
if (points >= 500) return 'Silver';
return 'Bronze';
}

function renderAdminRewards() {
const db = getRewardDatabase();
const customers = db.customers || [];
document.getElementById('customerRewardsView').style.display = 'none';
document.getElementById('adminRewardsView').style.display = 'block';

const totalPoints = customers.reduce((sum, customer) => sum + (customer.points || 0), 0);
const topCustomer = customers.slice().sort((a, b) => (b.points || 0) - (a.points || 0))[0];
document.getElementById('adminRewardsCount').textContent = `${customers.length} Accounts`;
document.getElementById('adminRewardStats').innerHTML = `
    <div class="col-md-4"><div class="stat-card"><div class="h4 fw-bold text-primary mb-1">${customers.length}</div><div class="text-muted small">Tracked customers</div></div></div>
    <div class="col-md-4"><div class="stat-card"><div class="h4 fw-bold text-primary mb-1">${totalPoints.toLocaleString()}</div><div class="text-muted small">Total reward points</div></div></div>
    <div class="col-md-4"><div class="stat-card"><div class="h4 fw-bold text-primary mb-1">${topCustomer ? topCustomer.name : 'N/A'}</div><div class="text-muted small">Top reward balance</div></div></div>
`;
document.getElementById('adminRewardsTable').innerHTML = customers.map((customer) => `
    <tr>
        <td class="fw-semibold">${customer.name}</td>
        <td>${customer.email}</td>
        <td>${customer.tier || 'Basic'}</td>
        <td class="text-primary fw-semibold">${(customer.points || 0).toLocaleString()}</td>
        <td><span class="badge rounded-pill px-3" style="background:rgba(16,185,129,.1);color:#059669;">${getTierLabel(customer.points || 0)}</span></td>
    </tr>
`).join('');
}

function init() {
// Friends
const fl = document.getElementById('friendsList');
friends.forEach(f => {
    const div = document.createElement('div');
    div.className = 'friend-item';
    div.innerHTML = `
        <img src="${f.avatar}" alt="${f.name}" class="friend-avatar">
        <div class="flex-grow-1">
            <div class="fw-semibold small">${f.name}</div>
            <div class="text-muted" style="font-size:.8rem;">${f.date}</div>
        </div>
        <span class="badge rounded-pill" style="background:rgba(16,185,129,.1);color:var(--primary);">+${f.points} pts</span>`;
    fl.appendChild(div);
});

// Tiers
const tl = document.getElementById('tierList');
tiers.forEach(t => {
    const userPts = 1240;
    const pct = t.max ? Math.min(100, Math.max(0, ((userPts - t.min) / (t.max - t.min)) * 100)) : 100;
    const achieved = userPts >= t.min;
    const div = document.createElement('div');
    div.className = `reward-tier-card${t.current ? ' current' : ''}`;
    div.style.borderLeftColor = t.color;
    div.innerHTML = `
        <div class="d-flex align-items-center gap-3">
            <span style="font-size:1.5rem;">${t.icon}</span>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between mb-1">
                    <span class="fw-semibold">${t.name} ${t.current ? '<span class="badge bg-primary ms-1 rounded-pill" style="font-size:.65rem;">Current</span>' : ''}</span>
                    <span class="small text-muted">${t.max ? t.min + '–' + t.max + ' pts' : t.min + '+ pts'}</span>
                </div>
                <div class="progress" style="height:5px;border-radius:3px;">
                    <div class="progress-bar" style="width:${pct}%;background:${t.color};border-radius:3px;"></div>
                </div>
            </div>
            ${achieved ? '<i class="bi bi-check-circle-fill" style="color:' + t.color + ';font-size:1.1rem;"></i>' : '<i class="bi bi-lock" style="color:#d1d5db;"></i>'}
        </div>`;
    tl.appendChild(div);
});

// Rewards
const rl = document.getElementById('rewardsList');
rewards.forEach(r => {
    const userPts = 1240;
    const canRedeem = userPts >= r.pts;
    const div = document.createElement('div');
    div.className = 'reward-item';
    div.innerHTML = `
        <div class="d-flex align-items-center gap-3">
            <div style="width:46px;height:46px;border-radius:12px;background:${r.color}18;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi ${r.icon} fs-5" style="color:${r.color};"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-semibold small">${r.title}</div>
                <div class="small text-muted">${r.pts} points required</div>
            </div>
            <button class="btn btn-sm rounded-pill px-3 ${canRedeem ? 'btn-primary' : 'btn-outline-secondary'}" ${canRedeem ? '' : 'disabled'} onclick="redeemReward('${r.title}', ${r.pts})">
                ${canRedeem ? 'Redeem' : 'Locked'}
            </button>
        </div>`;
    rl.appendChild(div);
});
}

function copyCode() {
navigator.clipboard.writeText(referralCode).then(() => showToast('Referral code copied! 📋', 'success')).catch(() => showToast(`${referralCode} — copy it!`, 'primary'));
}
function copyLink() {
navigator.clipboard.writeText(`https://subbox.example/ref/${referralCode}`).then(() => showToast('Referral link copied! 🔗', 'success')).catch(() => showToast('Link ready!', 'primary'));
}
function shareOn(platform) { showToast(`Sharing on ${platform}... +50 points! 🎉`, 'success'); }
function redeemReward(title, pts) {
if (userPoints < pts) {
    showToast('Not enough points to redeem this reward.', 'warning');
    return;
}
userPoints -= pts;
showToast(`"${title}" redeemed! ${pts} points deducted. ✅`, 'success');
}

document.addEventListener('DOMContentLoaded', () => {
if (!updateAuthUI()) return;
const session = getPortalSession();
if (session.role === 'admin') {
    document.querySelector('.hero-section-sm h1').innerHTML = '<i class="bi bi-award me-3"></i>Customer Rewards Monitor';
    document.querySelector('.hero-section-sm p').textContent = 'Admin view of each customer account and its current reward points.';
    renderAdminRewards();
    return;
}
init();
});

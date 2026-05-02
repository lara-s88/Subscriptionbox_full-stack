
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
    window.location.href = '/';
}

function updateAuthUI() {
    const session = getPortalSession();
    const rewardNavItem = document.getElementById('rewardNavItem');
    const footerRewardItem = document.getElementById('footerRewardItem');
    const authActionLink = document.getElementById('authActionLink');
    const footerAuthLink = document.getElementById('footerAuthLink');
    const footerRegisterItem = document.getElementById('footerRegisterItem');
    const adminOnlyHiddenLinks = document.querySelectorAll(
        window.routeSelector('home', 'sports', 'subscriptions')
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
        if (footerRegisterItem) footerRegisterItem.style.display = 'none';
    }
}

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

let isAnnual = false;

function toggleBilling() {
    isAnnual = document.getElementById('billingToggle').checked;
    document.getElementById('lblMonthly').style.color = isAnnual ? '' : 'var(--primary)';
    document.getElementById('lblAnnual').style.color = isAnnual ? 'var(--primary)' : '';
    document.querySelectorAll('.price-val').forEach(el => {
        el.textContent = isAnnual ? el.dataset.annual : el.dataset.monthly;
    });
    document.querySelectorAll('.annual-note').forEach(el => {
        el.style.display = isAnnual ? 'block' : 'none';
    });
}

function choosePlan(plan) {
    const currentTier = 'Pro';
    const priceMap = {
        Basic: 29,
        Pro: 49,
        VIP: 89
    };
    const remainingRatio = (30 - 12) / 30;
    const delta = (priceMap[plan] - (priceMap[currentTier] || 49)) * remainingRatio;
    const rec = {
        proratedCharge: delta > 0 ? Number(delta.toFixed(2)) : 0,
        proratedCredit: delta < 0 ? Number(Math.abs(delta).toFixed(2)) : 0
    };
    const benefits = {
        Basic: {
            shipping: 'Standard'
        },
        Pro: {
            shipping: 'Express'
        },
        VIP: {
            shipping: 'Priority + Concierge'
        }
    } [plan];
    const deltaMsg = rec.proratedCharge ?
        `Prorated charge: $${rec.proratedCharge}` :
        rec.proratedCredit ?
        `Prorated credit: $${rec.proratedCredit}` :
        'No prorated adjustment';
    showToast(`${plan} selected (${benefits.shipping}). ${deltaMsg}`, 'success');
    setTimeout(() => {
        window.location.href = '/login';
    }, 1800);
}
document.addEventListener('DOMContentLoaded', updateAuthUI);

/* --- Dark Mode --- */
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
    window.location.href = "/login";
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

/* --- Toast --- */
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

/* --- Render Sports Grid --- */
function renderSports() {
    const grid = document.getElementById('sports-grid');
    if (!grid) return;
    grid.innerHTML = '';
    mockData.sports.forEach(sport => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-3 animate-in';
        col.innerHTML = `
                    <a href="/boxes?sport=${encodeURIComponent(sport.name)}" class="text-decoration-none">
                        <div class="sport-card h-100">
                            <img src="${sport.image}" class="card-img-top" alt="${sport.name}" style="height:200px;object-fit:cover;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi ${sport.icon} text-primary fs-5"></i>
                                    <h5 class="card-title fw-bold mb-0">${sport.name}</h5>
                                </div>
                                <p class="card-text text-muted small mb-3">${sport.description}</p>
                                <span class="text-primary fw-semibold small">Explore boxes <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </div>
                    </a>`;
        grid.appendChild(col);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    updateAuthUI();
    renderSports();
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const menuButton = document.getElementById('mobileMenuBtn');
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileMenuOverlay');
    const closeButton = document.getElementById('mobileMenuClose');
    const transition = document.getElementById('pageTransition');

    const closeMenu = () => {
        if (!menu) return;
        menu.classList.remove('show');
        overlay?.classList.remove('show');
        menu.setAttribute('aria-hidden', 'true');
        menuButton?.classList.remove('is-open');
        menuButton?.setAttribute('aria-expanded', 'false');
        body.classList.remove('menu-open');
    };

    const openMenu = () => {
        if (!menu) return;
        menu.classList.add('show');
        overlay?.classList.add('show');
        menu.setAttribute('aria-hidden', 'false');
        menuButton?.classList.add('is-open');
        menuButton?.setAttribute('aria-expanded', 'true');
        body.classList.add('menu-open');
    };

    menuButton?.addEventListener('click', () => {
        menu?.classList.contains('show') ? closeMenu() : openMenu();
    });
    closeButton?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeMenu();
    });

    // Smooth, consistent password visibility controls across auth pages.
    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-password-toggle]');
        if (!button) return;
        const input = document.getElementById(button.dataset.passwordToggle);
        if (!input) return;

        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(show));
        button.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        const icon = button.querySelector('i');
        icon?.classList.toggle('fa-eye', !show);
        icon?.classList.toggle('fa-eye-slash', show);
    });

    // Lightweight page transition for same-origin navigation. Forms and downloads are untouched.
    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[data-nav-link]');
        if (!link || !transition) return;
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        if (link.target === '_blank' || link.hasAttribute('download')) return;

        let url;
        try { url = new URL(link.href, window.location.href); } catch { return; }
        if (url.origin !== window.location.origin) return;

        // Hash-only jumps should remain instant and native.
        if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return;

        event.preventDefault();
        closeMenu();
        transition.classList.add('is-leaving');
        window.setTimeout(() => { window.location.href = url.href; }, 180);
    });

    // Close the drawer after browser back/forward restores the page.
    window.addEventListener('pageshow', () => {
        transition?.classList.remove('is-leaving');
        closeMenu();
    });
});

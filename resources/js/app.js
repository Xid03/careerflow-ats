import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const root = document.documentElement;

const hideLoadingScreen = () => {
    root.classList.remove('cf-loading');
};

const showLoadingScreen = () => {
    root.classList.add('cf-loading');
};

const makeVisible = (element) => {
    element.classList.add('is-visible');
};

const applyMotionDelay = (element) => {
    const delay = element.dataset.motionDelay;

    if (delay) {
        element.style.setProperty('--motion-delay', `${delay}ms`);
    }
};

window.addEventListener('DOMContentLoaded', () => {
    const revealElements = document.querySelectorAll('.motion-reveal');

    revealElements.forEach((element) => applyMotionDelay(element));

    if (prefersReducedMotion) {
        revealElements.forEach((element) => makeVisible(element));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    makeVisible(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.16,
            rootMargin: '0px 0px -8% 0px',
        },
    );

    revealElements.forEach((element) => {
        if (element.dataset.motion === 'hero') {
            requestAnimationFrame(() => makeVisible(element));
            return;
        }

        observer.observe(element);
    });

    document.addEventListener('submit', (event) => {
        if (! (event.target instanceof HTMLFormElement)) {
            return;
        }

        if (event.defaultPrevented || !event.target.matches('[data-confirm-delete]') || event.target.dataset.confirmed === 'true') {
            return;
        }

        event.preventDefault();

        window.dispatchEvent(new CustomEvent('cf-confirm-delete', {
            detail: {
                form: event.target,
                title: event.target.dataset.confirmTitle,
                message: event.target.dataset.confirmMessage,
                button: event.target.dataset.confirmButton,
                label: event.target.dataset.confirmLabel,
            },
        }));
    }, true);

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');

        if (!link || event.defaultPrevented) {
            return;
        }

        const href = link.getAttribute('href');

        if (!href || href.startsWith('#') || link.target === '_blank' || link.hasAttribute('download')) {
            return;
        }

        const url = new URL(link.href, window.location.href);

        if (url.origin !== window.location.origin) {
            return;
        }

        if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) {
            return;
        }

        showLoadingScreen();
    }, true);

    document.addEventListener('submit', (event) => {
        if (event.target instanceof HTMLFormElement && !event.defaultPrevented) {
            showLoadingScreen();
        }
    }, true);
});

window.addEventListener('load', () => {
    window.setTimeout(hideLoadingScreen, prefersReducedMotion ? 40 : 260);
});

window.addEventListener('pageshow', hideLoadingScreen);

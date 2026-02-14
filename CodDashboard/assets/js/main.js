document.addEventListener('DOMContentLoaded', function () {

    /* ===== MARK ITEMS WITH CHILDREN =====
       Ilch sets li-class-root and li-class-child as SEPARATE classes.
       So we look for any <li> that directly contains a .cod-sidebar__sublist */
    document.querySelectorAll('.cod-sidebar__list > li').forEach(function (li) {
        var sublist = li.querySelector(':scope > .cod-sidebar__sublist');
        if (sublist) {
            li.classList.add('cod-sidebar__item--has-children');

            /* Auto-expand if any child is active */
            if (sublist.querySelector('.cod-sidebar__item--active')) {
                li.classList.add('is-expanded');
            }
        }
    });

    /* ===== MOBILE: CLICK TOGGLE FOR SUBMENUS ===== */
    document.querySelectorAll('.cod-sidebar__item--has-children > .cod-sidebar__link').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth < 992) {
                var parentItem = this.parentElement;
                parentItem.classList.toggle('is-expanded');
                e.preventDefault();
            }
        });
    });

    /* ===== MOBILE SIDEBAR TOGGLE ===== */
    var mobileToggle = document.getElementById('codMobileToggle');
    var sidebar = document.getElementById('codSidebar');

    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function () {
            var isOpen = sidebar.classList.toggle('is-open');
            mobileToggle.classList.toggle('is-active', isOpen);
            mobileToggle.setAttribute('aria-expanded', isOpen);
        });

        document.addEventListener('click', function (e) {
            if (window.innerWidth < 992) {
                if (!e.target.closest('.cod-sidebar') && !e.target.closest('.cod-mobile-toggle')) {
                    sidebar.classList.remove('is-open');
                    mobileToggle.classList.remove('is-active');
                    mobileToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

    /* ===== LIVE CLOCK ===== */
    var clockEl = document.getElementById('codClock');
    if (clockEl) {
        setInterval(function () {
            var now = new Date();
            var h = String(now.getHours()).padStart(2, '0');
            var m = String(now.getMinutes()).padStart(2, '0');
            var s = String(now.getSeconds()).padStart(2, '0');
            clockEl.textContent = h + ':' + m + ':' + s;
        }, 1000);
    }

    /* ===== RANDOM GLITCH EFFECT ===== */
    var glitchEl = document.querySelector('.cod-header__subtitle');
    if (glitchEl) {
        setInterval(function () {
            if (Math.random() > 0.85) {
                glitchEl.style.animation = 'none';
                void glitchEl.offsetWidth;
                glitchEl.style.animation = 'glitchText 0.4s ease-in-out';
            }
        }, 4000);
    }

    /* ===== INTERSECTION OBSERVER FOR WIDGETS ===== */
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, {threshold: 0.1});

        document.querySelectorAll('.cod-widget').forEach(function (el) {
            observer.observe(el);
        });
    }
});
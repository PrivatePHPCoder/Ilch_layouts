document.addEventListener('DOMContentLoaded', function() {
    var toggleLeft = document.getElementById('toggleWidgetsLeft');
    var toggleRight = document.getElementById('toggleWidgetsRight');
    var widgetsLeft = document.getElementById('floatingWidgetsLeft');
    var widgetsRight = document.getElementById('floatingWidgetsRight');

    /* Closes one widget column and keeps its toggle button in sync. */
    function closeWidgets(widgets, toggle) {
        if (widgets) {
            widgets.classList.remove('is-open');
        }
        if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
        }
    }

    /* Opens one column and closes the opposite one, if it exists. */
    function bindToggle(toggle, widgets, otherWidgets, otherToggle) {
        if (!toggle || !widgets) {
            return;
        }

        toggle.addEventListener('click', function() {
            var isOpen = widgets.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen);
            closeWidgets(otherWidgets, otherToggle);
        });
    }

    bindToggle(toggleLeft, widgetsLeft, widgetsRight, toggleRight);
    bindToggle(toggleRight, widgetsRight, widgetsLeft, toggleLeft);

    document.addEventListener('click', function(e) {
        if (!e.target || !e.target.closest) {
            return;
        }

        if (!e.target.closest('.floating-widgets') && !e.target.closest('.widget-toggle')) {
            closeWidgets(widgetsLeft, toggleLeft);
            closeWidgets(widgetsRight, toggleRight);
        }
    });

    /* ===== SCROLL REVEAL =====
       The widgets start at opacity 0, so without an observer they have to be
       revealed right away - otherwise they would stay invisible. */
    var revealTargets = document.querySelectorAll('.wow-content, .fw-widget');

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.1 });

        revealTargets.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        revealTargets.forEach(function(el) {
            el.classList.add('is-visible');
        });
    }

    /* ===== HERO PARALLAX =====
       Throttled via requestAnimationFrame and skipped for visitors who asked
       for reduced motion. */
    var hero = document.querySelector('.wow-hero__image');
    var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (hero && !reducedMotion) {
        var ticking = false;

        window.addEventListener('scroll', function() {
            if (ticking) {
                return;
            }

            ticking = true;
            window.requestAnimationFrame(function() {
                var scrolled = window.pageYOffset;

                if (scrolled < 800) {
                    hero.style.transform = 'scale(1.1) translateY(' + (scrolled * 0.3) + 'px)';
                }

                ticking = false;
            });
        }, { passive: true });
    }
});

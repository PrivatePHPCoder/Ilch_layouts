document.addEventListener('DOMContentLoaded', function() {
    var toggleLeft = document.getElementById('toggleWidgetsLeft');
    var toggleRight = document.getElementById('toggleWidgetsRight');
    var widgetsLeft = document.getElementById('floatingWidgetsLeft');
    var widgetsRight = document.getElementById('floatingWidgetsRight');

    if (toggleLeft && widgetsLeft) {
        toggleLeft.addEventListener('click', function() {
            var isOpen = widgetsLeft.classList.toggle('is-open');
            toggleLeft.setAttribute('aria-expanded', isOpen);
            widgetsRight.classList.remove('is-open');
            toggleRight.setAttribute('aria-expanded', 'false');
        });
    }

    if (toggleRight && widgetsRight) {
        toggleRight.addEventListener('click', function() {
            var isOpen = widgetsRight.classList.toggle('is-open');
            toggleRight.setAttribute('aria-expanded', isOpen);
            widgetsLeft.classList.remove('is-open');
            toggleLeft.setAttribute('aria-expanded', 'false');
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.floating-widgets') && !e.target.closest('.widget-toggle')) {
            widgetsLeft.classList.remove('is-open');
            widgetsRight.classList.remove('is-open');
            toggleLeft.setAttribute('aria-expanded', 'false');
            toggleRight.setAttribute('aria-expanded', 'false');
        }
    });

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.wow-content, .fw-widget').forEach(function(el) {
        observer.observe(el);
    });

    window.addEventListener('scroll', function() {
        var scrolled = window.pageYOffset;
        var hero = document.querySelector('.wow-hero__image');
        if (hero && scrolled < 800) {
            hero.style.transform = 'scale(1.1) translateY(' + (scrolled * 0.3) + 'px)';
        }
    });
});
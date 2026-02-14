document.addEventListener('DOMContentLoaded', function () {

    /* ===== MARK SIDEBAR ITEMS WITH CHILDREN =====
       Ilch uses separate classes for root and child li's.
       We detect any li that directly contains a submenu ul. */
    document.querySelectorAll('.mc-widget-nav').forEach(function (nav) {
        nav.querySelectorAll(':scope > li').forEach(function (li) {
            var sublist = li.querySelector(':scope > .mc-widget-nav__sub');
            if (sublist) {
                li.classList.add('mc-widget-nav__item--has-children');
            }
        });
    });

    /* ===== WIDGET ENTRANCE ANIMATION ===== */
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.mc-widget').forEach(function (el) {
            observer.observe(el);
        });
    }
});
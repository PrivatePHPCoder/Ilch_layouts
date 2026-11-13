<?php

/**
 * Ilch.de Layout - Standard-Layout (bis zu 3 Spalten).
 * index_full.php nutzt diese Datei mit $ilchFull = true (ohne rechte Spalte).
 *
 * Menüpositionen: 1 = Hauptnavigation (oben, nur Menüpunkte), 2 = linke Spalte, 3 = rechte Spalte (optional).
 *
 * @var $this \Ilch\Layout\Frontend
 */

$ilchFull = !empty($ilchFull);

// --- Hilfsfunktionen --------------------------------------------------------

/** Liefert einen gültigen #rrggbb-Wert (Fallback bei ungültiger Eingabe). */
$color = static function (string $value, string $fallback): string {
    if (!preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $value)) {
        return $fallback;
    }
    if (strlen($value) === 4) {
        $value = '#' . $value[1] . $value[1] . $value[2] . $value[2] . $value[3] . $value[3];
    }
    return strtolower($value);
};

/** "#rrggbb" => "r, g, b" (für rgba()-Verwendung in CSS). */
$rgb = static function (string $hex): string {
    return hexdec(substr($hex, 1, 2)) . ', ' . hexdec(substr($hex, 3, 2)) . ', ' . hexdec(substr($hex, 5, 2));
};

/** Lässt nur http(s), mailto, relative Links und Anker zu. */
$safeUrl = static function (string $url): string {
    $url = trim($url);
    return preg_match('#^(https?://|mailto:|/|\#|[a-z0-9_./-]+$)#i', $url) ? $url : '';
};

// --- Einstellungen ----------------------------------------------------------

$accent = $color($this->getLayoutSetting('accentcolor'), '#cc0101');
$ilchVersion = defined('VERSION') ? VERSION : '';
$siteTitle = $this->getConfigKey('page_title');
$logoUrl = $this->getBaseUrl($this->getLayoutSetting('logo'));
$featherUrl = $this->getLayoutUrl('img/feather.png');
$user = $this->getUser();

$downloadUrl = $safeUrl($this->getLayoutSetting('downloadurl'));
$showDownload = $this->getLayoutSetting('hidedownload') !== '1' && $downloadUrl !== '';

// --- Menüs ------------------------------------------------------------------
// Nur rendern, wenn die Menüposition existiert (sonst fällt Ilch auf Menü 1 zurück).

$menuMapper = new \Modules\Admin\Mappers\Menu();
$hasMenu = static function (int $position) use ($menuMapper): bool {
    return (bool) $menuMapper->getMenuIdForPosition($position);
};

/**
 * Seitenmenü (linke / rechte Spalte) wie auf ilch.de ausgeben:
 *  - Menü-Listen (Menüpunkte): schlichte Box mit Pfeil-Liste, OHNE den Namen des Menüs.
 *  - Boxen (Module wie Login/Archiv oder eigene Boxen): Box MIT ihrem Titel.
 * Unterschieden wird am Inhalt: Menü-Listen beginnen mit <ul>, Boxen nicht.
 */
$renderSideMenu = function (int $position) use ($hasMenu): string {
    if (!$hasMenu($position)) {
        return '';
    }

    $raw = $this->getMenu(
        $position,
        '<!--il-item--><!--il-title-->%s<!--/il-title--><!--il-content-->%c<!--/il-content--><!--/il-item-->',
        [
            'menus' => [
                'ul-class-root' => 'il-list',
                'ul-class-child' => 'il-list il-list-child',
                'li-class-active' => 'is-active',
            ],
        ]
    );

    $html = '';
    if (preg_match_all('/<!--il-item--><!--il-title-->(.*?)<!--\/il-title--><!--il-content-->(.*?)<!--\/il-content--><!--\/il-item-->/s', $raw, $items, PREG_SET_ORDER)) {
        foreach ($items as $item) {
            $title = trim($item[1]);
            $content = trim($item[2]);
            if ($content === '') {
                continue;
            }

            if (strncmp($content, '<ul', 3) === 0) {
                $html .= '<section class="il-box il-box--menu"><div class="il-box-body">' . $content . '</div></section>';
            } else {
                $html .= '<section class="il-box">'
                    . ($title !== '' ? '<h2 class="il-box-title">' . $title . '</h2>' : '')
                    . '<div class="il-box-body">' . $content . '</div></section>';
            }
        }
    }

    return $html;
};

/**
 * Menü als reine Liste ausgeben (für Hauptnavigation und Leistenmenü).
 * Jeder Eintrag der obersten Ebene wird markiert, damit nur echte Menüpunkt-Listen (<ul>) übernommen
 * werden. Boxen (z. B. Login), die jemand in so ein Menü legt, gehören nicht dorthin und werden
 * verworfen. Mehrere Menü-Container werden zu EINER Liste zusammengefasst.
 *
 * @return string die <li>-Elemente (ohne umschließendes <ul>) oder ''
 */
$renderMenuItems = function (int $position, array $menuOptions) use ($hasMenu): string {
    if (!$hasMenu($position)) {
        return '';
    }

    $raw = $this->getMenu($position, '<!--il-item-->%c<!--/il-item-->', ['menus' => $menuOptions]);

    $items = '';
    if (preg_match_all('/<!--il-item-->(.*?)<!--\/il-item-->/s', $raw, $parts)) {
        foreach ($parts[1] as $part) {
            if (preg_match('/^\s*<ul[^>]*>(.*)<\/ul>\s*$/s', $part, $list)) {
                $items .= $list[1];
            }
        }
    }

    return trim($items) !== '' ? $items : '';
};

// Menü 1: Hauptnavigation im dunklen Band (mit Dropdown-Untermenüs)
$navItems = $renderMenuItems(1, [
    'ul-class-root' => 'il-nav',
    'ul-class-child' => 'il-nav-sub',
    'li-class-root' => 'il-nav-item',
    'li-class-child' => 'il-nav-item',
    'li-class-root-nesting' => 'has-sub',
    'li-class-active' => 'is-active',
]);
$mainNav = $navItems !== '' ? '<ul class="il-nav">' . $navItems . '</ul>' : '';

// Menü 3: einzeilige Menüleiste im roten Brotkrumen-Streifen (klappt wie bei ilch.de per Pfeil-Reiter auf)
$crumbItems = $renderMenuItems(3, [
    'ul-class-root' => 'il-submenu-list',
    'ul-class-child' => 'il-submenu-list',
    'li-class-active' => 'is-active',
    'allow-nesting' => false,
]);
$crumbMenu = $crumbItems !== '' ? '<ul class="il-submenu-list">' . $crumbItems . '</ul>' : '';

// Menü 2: linke Spalte, Menü 4: rechte Spalte (optional)
$leftMenu = $renderSideMenu(2);
$rightMenu = $ilchFull ? '' : $renderSideMenu(4);

$hasLeft = $showDownload || $leftMenu !== '';
$hasRight = $rightMenu !== '';
$layoutClass = $ilchFull ? 'il-layout-full' : ($hasRight ? 'il-layout-3col' : 'il-layout-2col');

$breadcrumb = trim((string) $this->getHmenu());
$showCrumb = $breadcrumb !== '' || $crumbMenu !== '';
?>
<!DOCTYPE html>
<html lang="<?=$this->escape(substr($this->getTranslator()->getLocale(), 0, 2)) ?>" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#161617">
        <script>
            /* Farbschema (hell / dunkel / automatisch) vor dem ersten Rendern setzen. */
            (function () {
                var stored = null;
                try { stored = localStorage.getItem('ilchde-theme'); } catch (e) {}
                var mode = stored || 'auto';
                var dark = mode === 'dark' || (mode === 'auto' && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-il-mode', mode);
            })();
        </script>
        <?=$this->getHeader() ?>
        <link href="<?=$this->getVendorUrl('twbs/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?=$this->getLayoutUrl('style.css') ?>" rel="stylesheet">
        <style>:root { --il-accent: <?=$accent ?>; --il-accent-rgb: <?=$rgb($accent) ?>; }</style>
        <?=$this->getCustomCSS() ?>
        <script src="<?=$this->getVendorUrl('twbs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    </head>
    <body class="<?=$layoutClass ?>" id="top">
        <a class="il-skip" href="#il-content"><?=$this->getTrans('skipToContent') ?></a>

        <header class="il-header">
            <div class="il-topbar">
                <div class="il-wrap il-topbar-inner">
                    <div class="dropdown">
                        <button type="button" class="il-iconbtn" data-bs-toggle="dropdown" aria-expanded="false" title="<?=$this->getTrans('toggleTheme') ?>" aria-label="<?=$this->getTrans('toggleTheme') ?>">
                            <i class="fa-solid fa-sun il-theme-icon-light" aria-hidden="true"></i>
                            <i class="fa-solid fa-moon il-theme-icon-dark" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end il-dropdown">
                            <li><button class="dropdown-item" type="button" data-il-theme="light"><i class="fa-solid fa-sun fa-fw me-2" aria-hidden="true"></i><?=$this->getTrans('themeLight') ?></button></li>
                            <li><button class="dropdown-item" type="button" data-il-theme="dark"><i class="fa-solid fa-moon fa-fw me-2" aria-hidden="true"></i><?=$this->getTrans('themeDark') ?></button></li>
                            <li><button class="dropdown-item" type="button" data-il-theme="auto"><i class="fa-solid fa-circle-half-stroke fa-fw me-2" aria-hidden="true"></i><?=$this->getTrans('themeAuto') ?></button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="il-navband">
                <div class="il-wrap il-navwrap">
                    <a class="il-logo" href="<?=$this->getUrl() ?>" title="<?=$this->escape($siteTitle) ?>">
                        <img src="<?=$this->escape($logoUrl) ?>" alt="<?=$this->escape($siteTitle) ?>">
                    </a>

                    <nav class="il-mainnav collapse" id="il-mainnav" aria-label="<?=$this->getTrans('navigation') ?>">
                        <?=$mainNav ?>
                    </nav>

                    <div class="dropdown il-user">
                        <button type="button" class="il-userbtn" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-label="<?=$this->getTrans($user !== null ? 'account' : 'login') ?>">
                            <?php if ($user !== null) : ?>
                                <i class="fa-solid fa-user-check" aria-hidden="true"></i>
                                <span class="il-userbtn-label"><?=$this->escape((string) $user->getName()) ?></span>
                            <?php else : ?>
                                <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
                                <span class="il-userbtn-label"><?=$this->getTrans('login') ?></span>
                            <?php endif; ?>
                            <i class="il-caret" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end il-usermenu" data-bs-theme="dark">
                            <?=$this->getBox('user', 'login') ?>
                        </div>
                    </div>

                    <button class="il-burger" type="button" data-bs-toggle="collapse" data-bs-target="#il-mainnav" aria-controls="il-mainnav" aria-expanded="false" aria-label="<?=$this->getTrans('togglenavigation') ?>">
                        <i class="fa-solid fa-bars" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </header>

        <div class="il-stage">
            <div class="il-wrap">
                <div class="il-sheet">
                    <div class="il-grid">
                        <?php if ($showCrumb) : ?>
                            <div class="il-crumb">
                                <div class="il-crumb-path"><?=$breadcrumb ?></div>
                                <?php if ($crumbMenu !== '') : ?>
                                    <button type="button" class="il-crumb-toggle" id="il-submenu-toggle" aria-expanded="false" aria-controls="il-submenu" aria-label="<?=$this->getTrans('moreLinks') ?>" title="<?=$this->getTrans('moreLinks') ?>">
                                        <i class="il-caret" aria-hidden="true"></i>
                                    </button>
                                    <nav class="il-submenu" id="il-submenu" aria-label="<?=$this->getTrans('moreLinks') ?>">
                                        <?=$crumbMenu ?>
                                    </nav>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php // Die linke Spalte bleibt auf dem Desktop immer reserviert (Platz unter der Logo-Karte). ?>
                        <aside class="il-side il-side-left<?=$hasLeft ? '' : ' is-empty' ?>">
                            <?php if ($showDownload) : ?>
                                <a class="il-download" href="<?=$this->escape($downloadUrl) ?>">
                                    <span class="il-download-icon"><i class="fa-solid fa-download" aria-hidden="true"></i></span>
                                    <span class="il-download-text">
                                        <strong><?=$this->escape($this->getLayoutSetting('downloadtitle')) ?></strong>
                                        <em><?=$this->escape($this->getLayoutSetting('downloadsubtitle')) ?></em>
                                    </span>
                                </a>
                            <?php endif; ?>
                            <?=$leftMenu ?>
                        </aside>

                        <main class="il-main" id="il-content">
                            <div class="il-content">
                                <?=$this->getContent() ?>
                            </div>
                        </main>

                        <?php if ($hasRight) : ?>
                            <aside class="il-side il-side-right">
                                <?=$rightMenu ?>
                            </aside>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <footer class="il-footer">
            <div class="il-wrap il-footer-inner">
                <span class="il-feather" style="background-image: url('<?=$this->escape($featherUrl) ?>')" aria-hidden="true"></span>
                <div class="il-footer-text">
                    <nav class="il-footer-nav" aria-label="Footer">
                        <a href="<?=$this->getUrl() ?>"><?=$this->getTrans('home') ?></a>
                        <a href="<?=$this->getUrl(['module' => 'contact', 'controller' => 'index', 'action' => 'index']) ?>"><?=$this->getTrans('contact') ?></a>
                        <a href="<?=$this->getUrl(['module' => 'imprint', 'controller' => 'index', 'action' => 'index']) ?>"><?=$this->getTrans('imprint') ?></a>
                        <a href="<?=$this->getUrl(['module' => 'privacy', 'controller' => 'index', 'action' => 'index']) ?>"><?=$this->getTrans('privacy') ?></a>
                    </nav>
                    <div class="il-footer-copy">Copyright &copy; <?=date('Y') ?> <?=$this->escape($this->getLayoutSetting('footertext')) ?></div>
                    <div class="il-footer-copy"><?=$this->getTrans('poweredBy') ?> <a href="https://www.ilch.de/" rel="noopener">Ilch <?=$this->escape($ilchVersion) ?></a></div>
                </div>
                <div class="il-social">
                    <?php if ($safeUrl($this->getLayoutSetting('githuburl')) !== '') : ?>
                        <a href="<?=$this->escape($safeUrl($this->getLayoutSetting('githuburl'))) ?>" target="_blank" rel="noopener" aria-label="GitHub" title="GitHub"><i class="fa-brands fa-github" aria-hidden="true"></i></a>
                    <?php endif; ?>
                    <?php if ($safeUrl($this->getLayoutSetting('facebookurl')) !== '') : ?>
                        <a href="<?=$this->escape($safeUrl($this->getLayoutSetting('facebookurl'))) ?>" target="_blank" rel="noopener" aria-label="Facebook" title="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </footer>

        <a href="#top" class="il-to-top" id="il-to-top" aria-label="<?=$this->getTrans('backToTop') ?>" title="<?=$this->getTrans('backToTop') ?>">
            <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
        </a>

        <?=$this->getFooter() ?>
        <script>
            (function () {
                var root = document.documentElement;
                var media = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

                /* Farbschema: hell / dunkel / automatisch */
                function apply(mode) {
                    var dark = mode === 'dark' || (mode === 'auto' && media && media.matches);
                    root.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
                    root.setAttribute('data-il-mode', mode);
                    document.querySelectorAll('[data-il-theme]').forEach(function (el) {
                        el.classList.toggle('active', el.getAttribute('data-il-theme') === mode);
                    });
                }

                var current = root.getAttribute('data-il-mode') || 'auto';
                apply(current);

                document.querySelectorAll('[data-il-theme]').forEach(function (el) {
                    el.addEventListener('click', function () {
                        current = el.getAttribute('data-il-theme');
                        try { localStorage.setItem('ilchde-theme', current); } catch (e) {}
                        apply(current);
                    });
                });

                if (media && media.addEventListener) {
                    media.addEventListener('change', function () {
                        if (current === 'auto') { apply('auto'); }
                    });
                }

                /* Untermenüs der Hauptnavigation: per Tippen (Touch) und Escape bedienbar, ARIA-Status */
                var subItems = document.querySelectorAll('.il-nav .has-sub');
                var canHover = window.matchMedia ? window.matchMedia('(hover: hover) and (pointer: fine)').matches : true;
                var isDesktopNav = function () { return window.innerWidth >= 992; };

                function closeSubs(except) {
                    subItems.forEach(function (li) {
                        if (li === except) { return; }
                        li.classList.remove('is-open');
                        li.firstElementChild.setAttribute('aria-expanded', 'false');
                    });
                }

                subItems.forEach(function (li) {
                    var link = li.firstElementChild;
                    link.setAttribute('aria-haspopup', 'true');
                    link.setAttribute('aria-expanded', 'false');
                    link.addEventListener('click', function (e) {
                        if (canHover || !isDesktopNav()) { return; }
                        if (!li.classList.contains('is-open')) {
                            e.preventDefault();
                            closeSubs(li);
                            li.classList.add('is-open');
                            link.setAttribute('aria-expanded', 'true');
                        }
                    });
                });

                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.il-nav')) { closeSubs(null); }
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') { closeSubs(null); }
                });

                /* Leistenmenü (Menü 3): Pfeil-Reiter klappt die Linkleiste auf, Zustand bleibt gemerkt (wie ilch.de) */
                var subToggle = document.getElementById('il-submenu-toggle');
                var subMenu = document.getElementById('il-submenu');
                if (subToggle && subMenu) {
                    var setSubMenu = function (open, save) {
                        subMenu.classList.toggle('is-open', open);
                        subToggle.classList.toggle('is-open', open);
                        subToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                        if (save) {
                            try { localStorage.setItem('ilchde-submenu', open ? 'open' : 'closed'); } catch (e) {}
                        }
                    };
                    var storedSub = null;
                    try { storedSub = localStorage.getItem('ilchde-submenu'); } catch (e) {}
                    setSubMenu(storedSub === 'open', false);
                    subToggle.addEventListener('click', function () {
                        setSubMenu(!subMenu.classList.contains('is-open'), true);
                    });
                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape' && subMenu.classList.contains('is-open')) {
                            setSubMenu(false, true);
                            subToggle.focus();
                        }
                    });
                }

                /* Nach-oben-Button */
                var toTop = document.getElementById('il-to-top');
                var onScroll = function () { toTop.classList.toggle('is-visible', window.scrollY > 400); };
                window.addEventListener('scroll', onScroll, { passive: true });
                onScroll();
                toTop.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            })();
        </script>
    </body>
</html>

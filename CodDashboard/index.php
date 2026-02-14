<?php /** @var $this \Ilch\Layout\Frontend */ ?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=$this->getHeader() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Teko:wght@400;500;600;700&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link href="<?=$this->getLayoutUrl('assets/css/style.css') ?>" rel="stylesheet">
    <?=$this->getCustomCSS() ?>
</head>
<body>

<!-- ===== SCANLINE OVERLAY ===== -->
<div class="cod-scanlines" aria-hidden="true"></div>

<!-- ===== TACTICAL HEADER STRIP ===== -->
<header class="cod-header">
    <div class="cod-header__bg" style="background-image: url('<?=$this->getBaseUrl($this->getLayoutSetting('heroimage')) ?>');" aria-hidden="true"></div>
    <div class="cod-header__top-bar">
        <div class="cod-header__left">
            <span class="cod-header__status">
                <span class="cod-header__status-dot"></span>
                ONLINE
            </span>
        </div>
        <div class="cod-header__right">
            <span class="cod-header__coords"><?=date('d.m.Y') ?></span>
            <span class="cod-header__separator">|</span>
            <span class="cod-header__coords cod-header__clock" id="codClock"><?=date('H:i:s') ?></span>
        </div>
    </div>
    <div class="cod-header__inner">
        <span class="cod-header__callsign"><?=$this->getLayoutSetting('headertext') ?></span>
        <div class="cod-header__center">
            <span class="cod-header__subtitle" data-glitch="<?=$this->getLayoutSetting('headersubtext') ?>">
                <?=$this->getLayoutSetting('headersubtext') ?>
            </span>
        </div>
    </div>
    <div class="cod-header__border"></div>
</header>

<!-- ===== MOBILE NAVIGATION TOGGLE ===== -->
<button class="cod-mobile-toggle d-lg-none" type="button" id="codMobileToggle"
        aria-label="<?=$this->getTrans('togglenavigation') ?>"
        aria-expanded="false" aria-controls="codSidebar">
    <span class="cod-mobile-toggle__bar"></span>
    <span class="cod-mobile-toggle__bar"></span>
    <span class="cod-mobile-toggle__bar"></span>
</button>

<!-- ===== LAYOUT WRAPPER ===== -->
<div class="cod-layout">

    <!-- ===== VERTICAL SIDEBAR NAV ===== -->
    <nav class="cod-sidebar" id="codSidebar" role="navigation" aria-label="<?=$this->getTrans('navigation') ?>">
        <div class="cod-sidebar__inner">
            <!-- Emblem / Logo -->
            <div class="cod-sidebar__emblem">
                <div class="cod-sidebar__emblem-icon">&#9733;</div>
                <span class="cod-sidebar__emblem-text">HQ</span>
            </div>

            <!-- Navigation Links -->
            <div class="cod-sidebar__nav">
                <?=$this->getMenu(
                    1,
                    '<div class="cod-sidebar__group">
                        <div class="cod-sidebar__group-label">%s</div>
                        %c
                    </div>', [
                        'menus' => [
                            'ul-class-root'   => 'cod-sidebar__list',
                            'ul-class-child'  => 'cod-sidebar__sublist',
                            'li-class-root'   => 'cod-sidebar__item',
                            'li-class-child'  => 'cod-sidebar__item--child',
                            'li-class-active' => 'cod-sidebar__item--active',
                            'a-class'         => 'cod-sidebar__link',
                            'span-class'      => 'cod-sidebar__text',
                            'allow-nesting'   => true,
                        ],
                        'boxes' => [
                            'render' => false,
                        ],
                    ]
                ); ?>
            </div>

            <!-- Sidebar Footer -->
            <div class="cod-sidebar__footer">
                <div class="cod-sidebar__version">v1.0</div>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN AREA ===== -->
    <div class="cod-main">

        <!-- Breadcrumb / HMenu -->
        <div class="cod-main__hmenu">
            <?=$this->getHmenu() ?>
        </div>

        <!-- Content Area -->
        <div class="cod-content">
            <div class="cod-content__hud cod-content__hud--tl"></div>
            <div class="cod-content__hud cod-content__hud--tr"></div>
            <div class="cod-content__hud cod-content__hud--bl"></div>
            <div class="cod-content__hud cod-content__hud--br"></div>

            <div class="cod-content__inner">
                <?=$this->getContent() ?>
            </div>
        </div>

        <!-- Widget Grid -->
        <div class="cod-widgets">
            <?=$this->getMenu(
                2,
                '<div class="cod-widget">
                    <div class="cod-widget__hud cod-widget__hud--tl"></div>
                    <div class="cod-widget__hud cod-widget__hud--tr"></div>
                    <div class="cod-widget__hud cod-widget__hud--bl"></div>
                    <div class="cod-widget__hud cod-widget__hud--br"></div>
                    <div class="cod-widget__header">
                        <span class="cod-widget__header-icon">&#9670;</span>
                        <span class="cod-widget__header-text">%s</span>
                    </div>
                    <div class="cod-widget__body">%c</div>
                </div>', [
                    'menus' => [
                        'ul-class-root'   => 'cod-widget-nav',
                        'ul-class-child'  => 'cod-widget-nav__sub',
                        'li-class-root'   => 'cod-widget-nav__item',
                        'li-class-child'  => 'cod-widget-nav__item--child',
                        'li-class-active' => 'cod-widget-nav__item--active',
                        'a-class'         => 'cod-widget-nav__link',
                        'span-class'      => 'cod-widget-nav__text',
                        'allow-nesting'   => true,
                    ],
                    'boxes' => [
                        'render' => true,
                    ],
                ]
            ); ?>
        </div>

        <!-- Footer -->
        <footer class="cod-footer">
            <div class="cod-footer__border"></div>
            <div class="cod-footer__content">
                <div class="cod-footer__links">
                    <a href="<?=$this->getUrl() ?>"><?=$this->getTrans('home') ?></a>
                    <span class="cod-footer__sep">//</span>
                    <a href="<?=$this->getUrl(['module'=>'contact', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('contact') ?></a>
                    <span class="cod-footer__sep">//</span>
                    <a href="<?=$this->getUrl(['module'=>'imprint', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('imprint') ?></a>
                    <span class="cod-footer__sep">//</span>
                    <a href="<?=$this->getUrl(['module'=>'privacy', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('privacy') ?></a>
                </div>
                <div class="cod-footer__copyright">
                    &copy; <?=date('Y') ?> <?=$this->getLayoutSetting('headertext') ?> | CMS by <a href="https://www.ilch.de/">Ilch</a>
                </div>
            </div>
        </footer>

    </div>
</div>

<!-- ===== SMOKE PARTICLES ===== -->
<div class="cod-particles" aria-hidden="true">
    <div class="cod-particle cod-particle--1"></div>
    <div class="cod-particle cod-particle--2"></div>
    <div class="cod-particle cod-particle--3"></div>
    <div class="cod-particle cod-particle--4"></div>
    <div class="cod-particle cod-particle--5"></div>
</div>

<script src="<?=$this->getLayoutUrl('assets/js/main.js') ?>"></script>
</body>
</html>
<?php /** @var $this \Ilch\Layout\Frontend */ ?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=$this->getHeader() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="<?=$this->getLayoutUrl('assets/css/style.css') ?>" rel="stylesheet">
    <?=$this->getCustomCSS() ?>
</head>
<body>

<!-- ===== NAVIGATION ===== -->
<header class="mc-header">
    <!-- Desktop Navigation -->
    <nav class="mc-nav d-none d-lg-flex" role="navigation" aria-label="<?=$this->getTrans('navigation') ?>">
        <div class="mc-nav__inner">
            <a href="<?=$this->getUrl() ?>" class="mc-nav__brand">
                <span class="mc-nav__brand-icon">&#9878;</span>
                <span class="mc-nav__brand-text"><?=$this->getLayoutSetting('headertext') ?></span>
            </a>
            <div class="mc-nav__links">
                <?=$this->getMenu(
                    1,
                    '<div class="mc-nav__group">
                        <span class="mc-nav__group-title">%s</span>
                        %c
                    </div>', [
                        'menus' => [
                            'ul-class-root'   => 'mc-nav__list',
                            'ul-class-child'  => 'mc-nav__dropdown',
                            'li-class-root'   => 'mc-nav__item',
                            'li-class-child'  => 'mc-nav__item--child',
                            'li-class-active' => 'mc-nav__item--active',
                            'a-class'         => 'mc-nav__link',
                            'span-class'      => 'mc-nav__text',
                            'allow-nesting'   => true,
                        ],
                        'boxes' => [
                            'render' => false,
                        ],
                    ]
                ); ?>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    <nav class="mc-nav-mobile d-lg-none" role="navigation" aria-label="<?=$this->getTrans('navigation') ?>">
        <div class="mc-nav-mobile__bar">
            <a href="<?=$this->getUrl() ?>" class="mc-nav-mobile__brand"><?=$this->getLayoutSetting('headertext') ?></a>
            <button class="mc-nav-mobile__toggle" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mcMobileNav"
                    aria-controls="mcMobileNav" aria-expanded="false"
                    aria-label="<?=$this->getTrans('togglenavigation') ?>">
                <span class="mc-nav-mobile__icon"></span>
            </button>
        </div>
        <div class="collapse" id="mcMobileNav">
            <div class="mc-nav-mobile__menu">
                <?=$this->getMenu(
                    1,
                    '<div class="mc-nav-mobile__group">
                        <div class="mc-nav-mobile__group-title">%s</div>
                        %c
                    </div>', [
                        'menus' => [
                            'ul-class-root'   => 'mc-nav-mobile__list',
                            'ul-class-child'  => 'mc-nav-mobile__sub',
                            'li-class-root'   => 'mc-nav-mobile__item',
                            'li-class-child'  => 'mc-nav-mobile__item--child',
                            'li-class-active' => 'mc-nav-mobile__item--active',
                            'a-class'         => 'mc-nav-mobile__link',
                            'span-class'      => 'mc-nav-mobile__text',
                            'allow-nesting'   => true,
                        ],
                        'boxes' => [
                            'render' => false,
                        ],
                    ]
                ); ?>
            </div>
        </div>
    </nav>
</header>

<!-- ===== HERO BANNER with Day/Night Sky ===== -->
<section class="mc-hero">
    <div class="mc-hero__sky" aria-hidden="true">
        <div class="mc-hero__sun"></div>
        <div class="mc-hero__moon"></div>
        <div class="mc-hero__stars">
            <span class="mc-star" style="top:12%;left:8%"></span>
            <span class="mc-star" style="top:25%;left:22%"></span>
            <span class="mc-star" style="top:8%;left:45%"></span>
            <span class="mc-star" style="top:18%;left:67%"></span>
            <span class="mc-star" style="top:30%;left:80%"></span>
            <span class="mc-star" style="top:10%;left:92%"></span>
            <span class="mc-star" style="top:35%;left:35%"></span>
            <span class="mc-star" style="top:5%;left:55%"></span>
        </div>
    </div>
    <img class="mc-hero__image" src="<?=$this->getBaseUrl($this->getLayoutSetting('heroimage')) ?>" alt="<?=$this->getTrans('heroimage') ?>">
    <div class="mc-hero__overlay"></div>
    <div class="mc-hero__content">
        <h1 class="mc-hero__title"><?=$this->getLayoutSetting('headertext') ?></h1>
        <p class="mc-hero__subtitle"><?=$this->getLayoutSetting('headersubtext') ?></p>
    </div>
    <!-- Grass/Dirt Border -->
    <div class="mc-hero__ground" aria-hidden="true">
        <div class="mc-hero__grass"></div>
        <div class="mc-hero__dirt"></div>
    </div>
</section>

<!-- ===== MAIN 3-COLUMN LAYOUT ===== -->
<main class="mc-main">
    <div class="container-xl">
        <div class="mc-layout">

            <!-- LEFT SIDEBAR (Menu 1) -->
            <aside class="mc-sidebar mc-sidebar--left">
                <?=$this->getMenu(
                    1,
                    '<div class="mc-widget">
                        <div class="mc-widget__header">%s</div>
                        <div class="mc-widget__body">%c</div>
                    </div>', [
                        'menus' => [
                            'ul-class-root'   => 'mc-widget-nav',
                            'ul-class-child'  => 'mc-widget-nav__sub',
                            'li-class-root'   => 'mc-widget-nav__item',
                            'li-class-child'  => 'mc-widget-nav__item--child',
                            'li-class-active' => 'mc-widget-nav__item--active',
                            'a-class'         => 'mc-widget-nav__link',
                            'span-class'      => 'mc-widget-nav__text',
                            'allow-nesting'   => true,
                        ],
                        'boxes' => [
                            'render' => false,
                        ],
                    ]
                ); ?>
            </aside>

            <!-- CONTENT -->
            <div class="mc-content">
                <div class="mc-content__panel">
                    <?=$this->getHmenu() ?>
                    <div class="mc-content__inner">
                        <?=$this->getContent() ?>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR (Menu 2 + Boxes) -->
            <aside class="mc-sidebar mc-sidebar--right">
                <?=$this->getMenu(
                    2,
                    '<div class="mc-widget">
                        <div class="mc-widget__header">%s</div>
                        <div class="mc-widget__body">%c</div>
                    </div>', [
                        'menus' => [
                            'ul-class-root'   => 'mc-widget-nav',
                            'ul-class-child'  => 'mc-widget-nav__sub',
                            'li-class-root'   => 'mc-widget-nav__item',
                            'li-class-child'  => 'mc-widget-nav__item--child',
                            'li-class-active' => 'mc-widget-nav__item--active',
                            'a-class'         => 'mc-widget-nav__link',
                            'span-class'      => 'mc-widget-nav__text',
                            'allow-nesting'   => true,
                        ],
                        'boxes' => [
                            'render' => true,
                        ],
                    ]
                ); ?>
            </aside>

        </div>
    </div>
</main>

<!-- ===== FOOTER ===== -->
<footer class="mc-footer">
    <div class="mc-footer__ground" aria-hidden="true">
        <div class="mc-footer__grass"></div>
        <div class="mc-footer__dirt"></div>
    </div>
    <div class="mc-footer__stone">
        <div class="container-xl">
            <div class="mc-footer__content">
                <div class="mc-footer__links">
                    <a href="<?=$this->getUrl() ?>"><?=$this->getTrans('home') ?></a>
                    <span class="mc-footer__sep">⬥</span>
                    <a href="<?=$this->getUrl(['module'=>'contact', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('contact') ?></a>
                    <span class="mc-footer__sep">⬥</span>
                    <a href="<?=$this->getUrl(['module'=>'imprint', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('imprint') ?></a>
                    <span class="mc-footer__sep">⬥</span>
                    <a href="<?=$this->getUrl(['module'=>'privacy', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('privacy') ?></a>
                </div>
                <div class="mc-footer__copyright">
                    &copy; <?=date('Y') ?> <?=$this->getLayoutSetting('headertext') ?> | CMS by <a href="https://www.ilch.de/">Ilch</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?=$this->getLayoutUrl('assets/js/main.js') ?>"></script>
</body>
</html>
<?php /** @var $this \Ilch\Layout\Frontend */ ?><!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=$this->getHeader() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="<?=$this->getLayoutUrl('assets/css/style.css') ?>" rel="stylesheet">
    <?=$this->getCustomCSS() ?>

</head>
<body>

<!-- ===== FLOATING WIDGETS (Left) ===== -->
<aside class="floating-widgets floating-widgets--left" id="floatingWidgetsLeft">
    <?=$this->getMenu(
            1,
            '<div class="fw-widget">
                <div class="fw-widget__header">%s</div>
                <div class="fw-widget__body">%c</div>
            </div>', [
                    'menus' => [
                            'ul-class-root'   => 'fw-nav',
                            'ul-class-child'  => 'fw-nav__sub',
                            'li-class-root'   => 'fw-nav__item',
                            'li-class-child'  => 'fw-nav__item--child',
                            'li-class-active' => 'fw-nav__item--active',
                            'a-class'         => 'fw-nav__link',
                            'span-class'      => 'fw-nav__text',
                            'allow-nesting'   => true,
                    ],
                    'boxes' => [
                            'render' => false,
                    ],
            ]
    ); ?>
</aside>

<!-- ===== FLOATING WIDGETS (Right) ===== -->
<aside class="floating-widgets floating-widgets--right" id="floatingWidgetsRight">
    <?=$this->getMenu(
            2,
            '<div class="fw-widget">
                <div class="fw-widget__header">%s</div>
                <div class="fw-widget__body">%c</div>
            </div>', [
                    'menus' => [
                            'ul-class-root'   => 'fw-nav',
                            'ul-class-child'  => 'fw-nav__sub',
                            'li-class-root'   => 'fw-nav__item',
                            'li-class-child'  => 'fw-nav__item--child',
                            'li-class-active' => 'fw-nav__item--active',
                            'a-class'         => 'fw-nav__link',
                            'span-class'      => 'fw-nav__text',
                            'allow-nesting'   => true,
                    ],
                    'boxes' => [
                            'render' => true,
                    ],
            ]
    ); ?>
</aside>

<!-- ===== WIDGET TOGGLE BUTTONS ===== -->
<button class="widget-toggle widget-toggle--left" id="toggleWidgetsLeft"
        type="button" aria-label="<?=$this->getTrans('togglewidgetsleft') ?>"
        aria-expanded="false" aria-controls="floatingWidgetsLeft">
    <span class="widget-toggle__icon">&#9776;</span>
</button>
<button class="widget-toggle widget-toggle--right" id="toggleWidgetsRight"
        type="button" aria-label="<?=$this->getTrans('togglewidgetsright') ?>"
        aria-expanded="false" aria-controls="floatingWidgetsRight">
    <span class="widget-toggle__icon">&#9776;</span>
</button>

<!-- ===== NAVIGATION ===== -->
<header class="wow-header">
    <!-- Desktop Navigation -->
    <nav class="wow-nav d-none d-lg-flex" role="navigation" aria-label="<?=$this->getTrans('navigation') ?>">
        <div class="wow-nav__ornament wow-nav__ornament--left"></div>
        <div class="wow-nav__links">
            <?=$this->getMenu(
                    1,
                    '<div class="wow-nav__group">
                        <span class="wow-nav__group-title">%s</span>
                        %c
                    </div>', [
                            'menus' => [
                                    'ul-class-root'   => 'wow-nav__list',
                                    'ul-class-child'  => 'wow-nav__dropdown',
                                    'li-class-root'   => 'wow-nav__item',
                                    'li-class-child'  => 'wow-nav__item--child',
                                    'li-class-active' => 'wow-nav__item--active',
                                    'a-class'         => 'wow-nav__link',
                                    'span-class'      => 'wow-nav__text',
                                    'allow-nesting'   => true,
                            ],
                            'boxes' => [
                                    'render' => false,
                            ],
                    ]
            ); ?>
        </div>
        <div class="wow-nav__ornament wow-nav__ornament--right"></div>
    </nav>

    <!-- Mobile Navigation -->
    <nav class="wow-nav-mobile d-lg-none" role="navigation" aria-label="<?=$this->getTrans('navigation') ?>">
        <button class="wow-nav-mobile__toggle" type="button"
                data-bs-toggle="collapse" data-bs-target="#mobileNav"
                aria-controls="mobileNav" aria-expanded="false"
                aria-label="<?=$this->getTrans('togglenavigation') ?>">
            <span class="wow-nav-mobile__icon"></span>
            <?=$this->getTrans('navigation') ?>
        </button>
        <div class="collapse" id="mobileNav">
            <div class="wow-nav-mobile__menu">
                <?=$this->getMenu(
                        1,
                        '<div class="wow-nav-mobile__group">
                            <div class="wow-nav-mobile__group-title">%s</div>
                            %c
                        </div>', [
                                'menus' => [
                                        'ul-class-root'   => 'wow-nav-mobile__list',
                                        'ul-class-child'  => 'wow-nav-mobile__sub',
                                        'li-class-root'   => 'wow-nav-mobile__item',
                                        'li-class-child'  => 'wow-nav-mobile__item--child',
                                        'li-class-active' => 'wow-nav-mobile__item--active',
                                        'a-class'         => 'wow-nav-mobile__link',
                                        'span-class'      => 'wow-nav-mobile__text',
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

<!-- ===== HERO BANNER ===== -->
<section class="wow-hero">
    <div class="wow-hero__overlay"></div>
    <img class="wow-hero__image" src="<?=$this->getBaseUrl($this->getLayoutSetting('heroimage')) ?>" alt="<?=$this->getTrans('heroimage') ?>">
    <div class="wow-hero__content">

        <h1 class="wow-hero__title"><?=$this->getLayoutSetting('headertext') ?></h1>
        <p class="wow-hero__subtitle"><?=$this->getLayoutSetting('headersubtext') ?></p>
    </div>
    <div class="wow-hero__border-bottom"></div>
</section>

<!-- ===== MAIN CONTENT ===== -->
<main class="wow-main">
    <div class="container">
        <div class="wow-content">
            <div class="wow-content__corner wow-content__corner--tl"></div>
            <div class="wow-content__corner wow-content__corner--tr"></div>
            <div class="wow-content__corner wow-content__corner--bl"></div>
            <div class="wow-content__corner wow-content__corner--br"></div>

            <?=$this->getHmenu() ?>

            <div class="wow-content__inner">
                <?=$this->getContent() ?>
            </div>
        </div>
    </div>
</main>

<!-- ===== FOOTER ===== -->
<footer class="wow-footer">
    <div class="wow-footer__border-top"></div>
    <div class="container">
        <div class="wow-footer__content">
            <div class="wow-footer__links">
                <a href="<?=$this->getUrl() ?>"><?=$this->getTrans('home') ?></a>
                <span class="wow-footer__separator">&#10022;</span>
                <a href="<?=$this->getUrl(['module'=>'contact', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('contact') ?></a>
                <span class="wow-footer__separator">&#10022;</span>
                <a href="<?=$this->getUrl(['module'=>'imprint', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('imprint') ?></a>
                <span class="wow-footer__separator">&#10022;</span>
                <a href="<?=$this->getUrl(['module'=>'privacy', 'controller'=>'index', 'action'=>'index']) ?>"><?=$this->getTrans('privacy') ?></a>
            </div>
            <div class="wow-footer__copyright">
                &copy; <?=date('Y') ?> <?=$this->getLayoutSetting('headertext') ?> | CMS by <a href="https://www.ilch.de/">Ilch</a>
            </div>
        </div>
    </div>
</footer>

<script src="<?=$this->getLayoutUrl('assets/js/main.js') ?>"></script>
</body>
</html>

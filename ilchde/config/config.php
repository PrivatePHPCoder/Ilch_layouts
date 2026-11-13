<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Layouts\Ilchde\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'name' => 'Ilch.de',
        'version' => '1.0.0',
        'ilchCore' => '2.2.21',
        'author' => 'Ilch.de',
        'link' => 'https://ilch.de',
        'desc' => 'Das Layout von ilch.de, modern neu interpretiert: Logo-Karte, dunkle Hauptnavigation, rote Brotkrumenleiste, Seitenspalten, Hell-/Dunkelmodus. Menüs: 1 = Hauptnavigation (dunkles Band, nur Menüpunkte), 2 = linke Spalte, 3 = Leistenmenü in der roten Brotkrumenleiste (klappt per Pfeil-Reiter auf, nur Menüpunkte), 4 = rechte Spalte (optional). Menüs ohne Boxen zeigen ihren Namen nicht an.',
        'layouts' => [
            'index_full' => [
                ['module' => 'user', 'controller' => 'panel'],
                ['module' => 'forum'],
                ['module' => 'guestbook'],
            ]
        ],
        'settings' => [
            // --- Marke & Farben ---------------------------------------------
            'sep_brand' => [
                'type' => 'separator',
            ],
            'logo' => [
                'type' => 'mediaselection',
                'default' => 'application/layouts/ilchde/img/logo.png',
                'description' => 'logoInfo',
            ],
            'accentcolor' => [
                'type' => 'colorpicker',
                'default' => '#cc0101',
                'description' => 'accentcolorInfo',
            ],

            // --- Download-Schaltfläche (linke Spalte) -----------------------
            'sep_download' => [
                'type' => 'separator',
            ],
            'hidedownload' => [
                'type' => 'flipswitch',
                'default' => '0',
                'description' => 'hidedownloadInfo',
            ],
            'downloadtitle' => [
                'type' => 'text',
                'default' => 'Zum Download',
                'description' => '',
            ],
            'downloadsubtitle' => [
                'type' => 'text',
                'default' => 'ilch Version 2',
                'description' => '',
            ],
            'downloadurl' => [
                'type' => 'url',
                'default' => 'https://github.com/IlchCMS/Ilch-2.0/releases/latest',
                'description' => '',
            ],

            // --- Fußbereich -------------------------------------------------
            'sep_footer' => [
                'type' => 'separator',
            ],
            'footertext' => [
                'type' => 'text',
                'default' => 'ilch.de',
                'description' => 'footertextInfo',
            ],
            'githuburl' => [
                'type' => 'url',
                'default' => 'https://github.com/IlchCMS/Ilch-2.0',
                'description' => '',
            ],
            'facebookurl' => [
                'type' => 'url',
                'default' => 'https://www.facebook.com/pages/Ilchde/114576205253230',
                'description' => '',
            ],
        ],
    ];

    public function getUpdate($installedVersion)
    {
    }
}

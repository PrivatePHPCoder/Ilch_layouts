<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Layouts\WowClassic\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'name' => 'WoW Classic',
        'version' => '1.0.0',
        'ilchCore' => '2.2.0',
        'author' => 'PrivatePHPCoder',
        'link' => 'https://ilch.de',
        'desc' => 'World of Warcraft inspiriertes Gaming Layout - Single Column mit schwebenden Widgets',

        'settings' => [
            'headertext' => [
                'type' => 'text',
                'default' => 'Your Guild Name',
                'description' => '',
            ],
            'headersubtext' => [
                'type' => 'text',
                'default' => 'Für die Allianz · Für die Horde',
                'description' => '',
            ],
            'heroimage' => [
                'type' => 'mediaselection',
                'default' => 'application/layouts/wowclassic/assets/img/hero.jpg',
                'description' => 'img',
            ],
        ],
    ];

    public function getUpdate($installedVersion)
    {
    }
}

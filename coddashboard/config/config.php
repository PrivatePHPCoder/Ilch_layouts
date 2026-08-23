<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Layouts\CodDashboard\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'name' => 'CoD Dashboard',
        'version' => '1.0.0',
        'ilchCore' => '2.2.0',
        'author' => 'PrivatePHPCoder',
        'link' => 'https://ilch.de',
        'desc' => 'Call of Duty inspiriertes Dashboard Layout - Vertikale Icon-Navigation, HUD-Elemente, taktischer Stil',

        'settings' => [
            'headertext' => [
                'type' => 'text',
                'default' => 'TASK FORCE 141',
                'description' => '',
            ],
            'headersubtext' => [
                'type' => 'text',
                'default' => 'TACTICAL OPERATIONS CENTER',
                'description' => '',
            ],
            'heroimage' => [
                'type' => 'mediaselection',
                'default' => 'application/layouts/CodDashboard/assets/img/header-bg.jpg',
                'description' => 'img',
            ],
        ],
    ];

    public function getUpdate($installedVersion)
    {
    }
}
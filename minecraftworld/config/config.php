<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Layouts\MinecraftWorld\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'name' => 'Minecraft World',
        'version' => '1.0.0',
        'ilchCore' => '2.2.0',
        'author' => 'PrivatePHPCoder',
        'link' => 'https://ilch.de',
        'desc' => 'Minecraft inspiriertes Layout - Drei Spalten, Pixel-Stil, Crafting-UI Elemente',

        'settings' => [
            'headertext' => [
                'type' => 'text',
                'default' => 'Minecraft Server',
                'description' => '',
            ],
            'headersubtext' => [
                'type' => 'text',
                'default' => 'Survival · Creative · Adventure',
                'description' => '',
            ],
            'heroimage' => [
                'type' => 'mediaselection',
                'default' => 'application/layouts/MinecraftWorld/assets/img/hero.png',
                'description' => 'img',
            ],
        ],
    ];

    public function getUpdate($installedVersion)
    {
    }
}
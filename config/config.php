<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gametracker\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'gametracker',
        'version' => '1.0.0',
        'icon_small' => 'fa-regular fa-google',
        'author' => 'The_Mumie',
        'link' => 'https://ilch.de',
        'languages' => [
            'de_DE' => [
                'name' => 'Gametracker',
                'description' => 'Es können Gametracker views erstellt werden, welche auf einer Seite oder in einer Box dargestellt werden.',
            ],
            'en_EN' => [
                'name' => 'Gametracker',
                'description' => 'Game tracker views can be created, which are displayed on a page or in a box.',
            ],
        ],
        'boxes' => [
            'gametracker' => [
                'de_DE' => [
                    'name' => 'Gametracker'
                ],
                'en_EN' => [
                    'name' => 'Gametracker'
                ]
            ]
        ],
        'ilchCore' => '2.1.48',
        'phpVersion' => '7.3'
    ];

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());

        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->set('gametrackers_slider', '0')
            ->set('gametrackers_slider_mode', 'vertical')
            ->set('gametrackers_box_height', '90')
            ->set('gametrackers_slider_speed', '6000');
    }

    public function uninstall()
    {
        $this->db()->queryMulti('DROP TABLE `[prefix]_gametrackers`');
        $this->db()->queryMulti("DELETE FROM `[prefix]_config` WHERE `key` = 'gametrackers_slider';
            DELETE FROM `[prefix]_config` WHERE `key` = 'gametrackers_slider_mode';
            DELETE FROM `[prefix]_config` WHERE `key` = 'gametrackers_box_height';
            DELETE FROM `[prefix]_config` WHERE `key` = 'gametrackers_slider_speed'");
    }

    public function getInstallSql(): string
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_gametrackers` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `pos` INT(11) NOT NULL DEFAULT 0,
            `name` VARCHAR(100) NOT NULL,
            `banner` VARCHAR(255) NOT NULL,
            `link` VARCHAR(255) NOT NULL,
            `target` TINYINT(1) NOT NULL DEFAULT 0,
            `setfree` TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1';
    }

    public function getUpdate(string $installedVersion): string
    {
        switch ($installedVersion) {
            case '1.0.0':
                // no break
        }

        return '"' . $this->config['key'] . '" Update-function executed.';
    }
}

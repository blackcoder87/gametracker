<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Gametracker\Boxes;

use Modules\Gametracker\Mappers\Gametracker as GametrackerMapper;

class Gametracker extends \Ilch\Box
{
    public function render()
    {
        $gametrackerMapper = new GametrackerMapper();

        $this->getView()->set('slider', $this->getConfig()->get('gametrackers_slider'))
            ->set('sliderMode', $this->getConfig()->get('gametrackers_slider_mode'))
            ->set('sliderSpeed', $this->getConfig()->get('gametrackers_slider_speed'))
            ->set('boxHeight', $this->getConfig()->get('gametrackers_box_height'))
            ->set('gametrackers', $gametrackerMapper->getGametrackersBy(['setfree' => 1], ['pos' => 'ASC', 'id' => 'ASC']));
    }
}

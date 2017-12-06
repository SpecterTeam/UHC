<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/5/2017
 * Time: 11:22 PM
 */

namespace uhc\scenario\scenarios;


use pocketmine\entity\Effect;
use uhc\events\StartUHCEvent;
use uhc\scenario\Scenario;

class CatEyes extends Scenario
{

    /**
     * @param StartUHCEvent $event
     */
    public function onStart(StartUHCEvent $event)
    {
        $players = $event->getPlayers();
        foreach ($players as $player){
            $player->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setVisible(false)->setDuration(PHP_INT_MAX)->setAmplifier(10));
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "CatEyes";
    }
}
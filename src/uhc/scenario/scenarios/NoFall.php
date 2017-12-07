<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/8/2017
 * Time: 12:56 AM
 */

namespace uhc\scenario\scenarios;


use pocketmine\event\entity\EntityDamageEvent;
use uhc\scenario\Scenario;

class NoFall extends Scenario
{
    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event)
    {
        if ($event->getCause() == EntityDamageEvent::CAUSE_FALL){
            $event->setCancelled(true);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "NoFall";
    }
}
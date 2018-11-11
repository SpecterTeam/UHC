<?php
/**
 *     UHC  Copyright (C) 2017-2018  SpecterTeam
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace uhc\scenario\scenarios;


use pocketmine\event\entity\EntityDamageEvent;
use uhc\scenario\Scenario;

class NoFall extends Scenario
{
    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event) : void
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
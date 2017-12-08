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

namespace uhc\scenario;


use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use uhc\events\StartUHCEvent;
use uhc\events\StopUHCEvent;

abstract class Scenario
{
    private $enabled = false;
    /**
     * @param PlayerMoveEvent $event
     */
    public function onMove(PlayerMoveEvent $event) {}

    /**
     * @param BlockBreakEvent $event
     */
    public function onBreak(BlockBreakEvent $event) {}

    /**
     * @param BlockPlaceEvent $event
     */
    public function onPlace(BlockPlaceEvent $event) {}

    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event) {}

    /**
     * @param StartUHCEvent $event
     */
    public function onStart(StartUHCEvent $event) {}

    /**
     * @param StopUHCEvent $event
     */
    public function onStop(StopUHCEvent $event) {}

    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event) {}

    /**
     * @return string
     */
    public function getName() : string
    {
        return "default";
    }

    /**
     * @return bool
     */
    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled = true)
    {
        $this->enabled = $enabled;
    }
}
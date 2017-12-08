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
namespace uhc\listener;


use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\EventPriority;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\MethodEventExecutor;
use uhc\events\StartUHCEvent;
use uhc\events\StopUHCEvent;
use uhc\UHC;

class ScenarioListener implements Listener
{
    private $plugin;

    /**
     * ScenarioListener constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        $this->setPlugin($plugin);
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
        $plugin->getServer()->getPluginManager()->registerEvent("uhc\\events\\StartUHCEvent", $this, EventPriority::NORMAL, new MethodEventExecutor("onStart"), $plugin, true);
        $plugin->getServer()->getPluginManager()->registerEvent("uhc\\events\\StopUHCEvent", $this, EventPriority::NORMAL, new MethodEventExecutor("onStop"), $plugin, true);
    }

    /**
     * @param PlayerMoveEvent $event
     */
    public function onMove(PlayerMoveEvent $event)
    {
        UHC::getScenariomanager()->doMove($event);
    }

    /**
     * @param BlockBreakEvent $event
     */
    public function onBreak(BlockBreakEvent $event)
    {
        UHC::getScenariomanager()->doBreak($event);
    }

    /**
     * @param BlockPlaceEvent $event
     */
    public function onPlace(BlockPlaceEvent $event)
    {
        UHC::getScenariomanager()->doPlace($event);
    }

    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event)
    {
        UHC::getScenariomanager()->doDeath($event);
    }

    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event)
    {
        UHC::getScenariomanager()->doDamage($event);
    }

    /**
     * @param StartUHCEvent $event
     */
    public function onStart(StartUHCEvent $event)
    {
        UHC::getScenariomanager()->doStart($event);
    }

    /**
     * @param StopUHCEvent $event
     */
    public function onStop(StopUHCEvent $event)
    {
        UHC::getScenariomanager()->doStop($event);
    }

    /**
     * @return UHC
     */
    public function getPlugin() : UHC
    {
        return $this->plugin;
    }

    /**
     * @param UHC $plugin
     */
    public function setPlugin(UHC $plugin)
    {
        $this->plugin = $plugin;
    }
}
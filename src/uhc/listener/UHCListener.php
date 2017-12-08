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
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\utils\TextFormat;
use uhc\LangManager;
use uhc\task\UHCTask;
use uhc\UHC;
use uhc\UHCPlayer;

class UHCListener implements Listener
{
    private $plugin;

    /**
     * UHCListener constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        $this->setPlugin($plugin);
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event)
    {
        $player = $event->getPlayer();
        if($player instanceof UHCPlayer){
            if($player->isPlaying()){
                UHC::getUHCManager()->setLastDeath($player->getName());
                UHC::getUHCManager()->removePlayer($player);
                $event->setDeathMessage(null);
                UHC::getUHCManager()->sendMessage(LangManager::DEATH, true);
                //TODO: Custom messages
            }
        }
    }

    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event)
    {
        if(!UHC::getUHCManager()->isPvP()) {
            $event->setCancelled(true);
        }
    }

    /**
     * @param BlockBreakEvent $event
     */
    public function onBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        if ($player instanceof UHCPlayer) {
            if ($player->getLevel()->getName() === UHC::getUHCManager()->getName()) {
                if (!UHC::getUHCManager()->isStarted() and UHC::getUHCManager()->getState() == UHCTask::STARTING) {
                    $event->setCancelled(true);
                }
            }
        }
    }

    /**
     * @return UHC
     */
    public function getPlugin(): UHC
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
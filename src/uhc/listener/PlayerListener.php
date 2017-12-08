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
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerJoinEvent;
use uhc\UHC;
use pocketmine\event\Listener;
use uhc\UHCPlayer;

class PlayerListener implements Listener
{
    private $plugin;

    /**
     * PlayerListener constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        $this->setPlugin($plugin);
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    /**
     * @param PlayerJoinEvent $event
     */
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        if($player instanceof UHCPlayer){
            $player->initConfig();
        }
    }

    /**
     * @param PlayerCreationEvent $event
     */
    public function onCreation(PlayerCreationEvent $event)
    {
        $event->setPlayerClass(UHCPlayer::class);
    }

    /**
     * @param BlockBreakEvent $event
     */
    public function onBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        if($player instanceof UHCPlayer){
            if($player->getLevel()->getName() === $this->getPlugin()->getServer()->getDefaultLevel()->getName()){
                if (!$player->isOp() or !$player->hasPermission("lobby.break")){
                    $event->setCancelled(true);
                }
            }
        }
    }

    /**
     * @param BlockPlaceEvent $event
     */
    public function onPlace(BlockPlaceEvent $event)
    {
        $player = $event->getPlayer();
        if($player instanceof UHCPlayer){
            if($player->getLevel()->getName() === $this->getPlugin()->getServer()->getDefaultLevel()->getName()){
                if (!$player->isOp() or !$player->hasPermission("lobby.place")){
                    $event->setCancelled(true);
                }
            }
        }
    }

    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event)
    {
        $player = $event->getEntity();
        if ($player instanceof UHCPlayer){
            if ($player->getLevel()->getName() === $this->getPlugin()->getServer()->getDefaultLevel()->getName()){
                $event->setCancelled(true);
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
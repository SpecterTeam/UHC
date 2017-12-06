<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/6/2017
 * Time: 9:39 PM
 */

namespace uhc\listener;

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
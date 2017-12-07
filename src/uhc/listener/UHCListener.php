<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/6/2017
 * Time: 10:42 PM
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
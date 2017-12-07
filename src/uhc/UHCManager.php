<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/5/2017
 * Time: 8:38 PM
 */

namespace uhc;

use pocketmine\level\generator\Generator;
use pocketmine\level\generator\normal\Normal;
use pocketmine\level\Level;
use pocketmine\level\Position;
use uhc\events\StartUHCEvent;
use uhc\task\UHCTask;

class UHCManager
{
    const DEFAULT_NAME = "UHC";

    private $plugin, $level, $name = self::DEFAULT_NAME, $started = false, $players = [], $lastdeath = "", $lastwinner = "", $state = UHCTask::STARTING;

    /**
     * UHCManager constructor.
     * @param UHC $plugin
     * @param string $name
     */
    public function __construct(UHC $plugin, string $name)
    {
        $this->setPlugin($plugin);
        $this->setName($name);
        if($plugin->getServer()->isLevelGenerated($name)){
            $plugin->getServer()->loadLevel($name);
            $level = $plugin->getServer()->getLevelByName($name);
        } else {
            $plugin->getServer()->generateLevel($name, null, Generator::getGeneratorName(Normal::class));
            $level = $plugin->getServer()->getLevelByName($name);
        }
        $this->setLevel($level);
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

    /**
     * @return Level
     */
    public function getLevel() : Level
    {
        return $this->level;
    }

    /**
     * @param Level $level
     */
    public function setLevel(Level $level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $message
     * @param bool $translate
     */
    public function broadcastMessage(string $message, bool $translate = false)
    {
        foreach ($this->getPlayers() as $player){
            $translate ? $player->sendTranslatedMessage($message) : $player->sendMessage($message);
        }
    }

    public function start()
    {
        $this->setStarted(true);
        $players = $this->getLevel()->getPlayers();
        foreach ($players as $player){
            if($player instanceof UHCPlayer){
                if($player->getGamemode() == UHCPlayer::SURVIVAL){
                    $this->addPlayer($player);
                    $player->teleport(new Position(mt_rand(-500, 500), 130, mt_rand(-500, 500), $this->getLevel()));
                    $player->getInventory()->clearAll();
                    $player->removeAllEffects();
                }
            }
        }
        $this->broadcastMessage(LangManager::START_GAME, true);
        $this->getPlugin()->getServer()->getPluginManager()->callEvent(new StartUHCEvent($this->getPlugin(), $this->getName(), $this->getPlayers()));
    }

    /**
     * @param UHCPlayer $winner
     */
    public function stop(UHCPlayer $winner)
    {
        $this->setStarted(false);
        $this->setLastWinner($winner->getName());
        foreach ($this->getLevel()->getPlayers() as $player){
            if($player instanceof UHCPlayer){
                if($player->isPlaying()) $this->removePlayer($player);
                $player->teleport($this->getPlugin()->getServer()->getDefaultLevel()->getSpawnLocation());
            }
        }
    }

    /**
     * @return bool
     */
    public function isStarted() : bool
    {
        return $this->started;
    }

    /**
     * @param bool $started
     */
    public function setStarted(bool $started)
    {
        $this->started = $started;
    }

    /**
     * @param UHCPlayer $player
     */
    public function addPlayer(UHCPlayer $player)
    {
        $this->players[$player->getName()] = $player->getName();
    }

    /**
     * @param UHCPlayer $player
     */
    public function removePlayer(UHCPlayer $player)
    {
        unset($this->players[$player->getName()]);
    }

    /**
     * @param UHCPlayer $player
     * @return bool
     */
    public function isPlaying(UHCPlayer $player)
    {
        return isset($this->players[$player->getName()]);
    }

    /**
     * @return UHCPlayer[]
     */
    public function getPlayers() : array
    {
        return $this->players;
    }

    /**
     * @return string
     */
    public function getLastDeath(): string
    {
        return $this->lastdeath;
    }

    /**
     * @param string $lastdeath
     */
    public function setLastDeath(string $lastdeath)
    {
        $this->lastdeath = $lastdeath;
    }

    /**
     * @return int
     */
    public function getState() : int
    {
        return $this->state;
    }

    /**
     * @param int $state
     */
    public function setState(int $state)
    {
        //$this->getPlugin()->getServer()->getPluginManager()->callEvent();
        $this->state = $state;
    }

    /**
     * @return bool
     */
    public function isPvP() : bool
    {
        return $this->isStarted() and ($this->getState() == UHCTask::GRACE or $this->getState() == UHCTask::END);
    }

    /**
     * @return string
     */
    public function getLastWinner() : string
    {
        return $this->lastwinner;
    }

    /**
     * @param string $lastwinner
     */
    public function setLastWinner(string $lastwinner)
    {
        $this->lastwinner = $lastwinner;
    }
}
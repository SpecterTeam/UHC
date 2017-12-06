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
use pocketmine\utils\TextFormat;
use uhc\events\StartUHCEvent;

class UHCManager
{
    const DEFAULT_NAME = "UHC";

    private $plugin, $level, $name = self::DEFAULT_NAME, $started = false, $players = [];

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
        $this->getPlugin()->getServer()->broadcastMessage(Utils::getPrefix() . TextFormat::GREEN . "the game has started!");
        $this->getPlugin()->getServer()->getPluginManager()->callEvent(new StartUHCEvent($this->getPlugin(), $this->getName(), $this->getPlayers()));
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
}
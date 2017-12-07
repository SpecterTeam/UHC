<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/7/2017
 * Time: 4:40 PM
 */

namespace uhc\events;

use uhc\UHCPlayer;
use uhc\UHC;
use pocketmine\event\plugin\PluginEvent;

class StopUHCEvent extends PluginEvent
{
    private $name = "";
    private $winner, $winnername = "";

    public static $handlerList = null;

    /**
     * StartUHCEvent constructor.
     * @param UHC $plugin
     * @param string $name
     * @param UHCPlayer $player
     */
    public function __construct(UHC $plugin, string $name, UHCPlayer $player)
    {
        parent::__construct($plugin);
        $this->setName($name);
        $this->setWinner($player);
        $this->setWinnerName($player->getName());
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
     * @return UHCPlayer
     */
    public function getWinner() : UHCPlayer
    {
        return $this->winner;
    }

    /**
     * @param UHCPlayer $winner
     */
    public function setWinner(UHCPlayer $winner)
    {
        $this->winner = $winner;
    }

    /**
     * @return string
     */
    public function getWinnerName() : string
    {
        return $this->winnername;
    }

    /**
     * @param string $name
     */
    public function setWinnerName(string $name)
    {
        $this->winnername = $name;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/5/2017
 * Time: 11:29 PM
 */

namespace uhc\events;


use pocketmine\event\plugin\PluginEvent;
use uhc\UHC;
use uhc\UHCPlayer;

class StartUHCEvent extends PluginEvent
{
    private $name = "";
    private $players = [];

    /**
     * StartUHCEvent constructor.
     * @param UHC $plugin
     * @param string $name
     * @param UHCPlayer[] $players
     */
    public function __construct(UHC $plugin, string $name, array $players)
    {
        parent::__construct($plugin);
        $this->setName($name);
        $this->setPlayers($players);
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
     * @return UHCPlayer[]
     */
    public function getPlayers() : array
    {
        return $this->players;
    }

    /**
     * @param UHCPlayer[] $players
     */
    public function setPlayers(array $players)
    {
        $this->players = $players;
    }
}
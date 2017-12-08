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
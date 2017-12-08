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


use pocketmine\event\plugin\PluginEvent;
use uhc\UHC;
use uhc\UHCPlayer;

class StartUHCEvent extends PluginEvent
{
    private $name = "";
    private $players = [];

    public static $handlerList = null;

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
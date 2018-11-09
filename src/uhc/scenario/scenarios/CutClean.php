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

namespace uhc\scenario\scenarios;


use pocketmine\block\BlockIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use uhc\scenario\Scenario;

class CutClean extends Scenario
{
    /**
     * @param BlockBreakEvent $event
     */
    public function onBreak(BlockBreakEvent $event) : void
    {
        switch ($event->getBlock()->getId()){
            case BlockIds::IRON_ORE:
                $event->setDrops([Item::get(ItemIds::IRON_ORE, 0, 1)]);
            break;

            case BlockIds::GOLD_ORE:
                $event->setDrops([Item::get(ItemIds::GOLD_ORE, 0, 1)]);
            break;
        }
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return "CutClean";
    }
}
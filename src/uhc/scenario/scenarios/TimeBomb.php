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


use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\tile\Chest;
use uhc\scenario\Scenario;
use uhc\task\TimeBombTask;
use uhc\UHC;
use uhc\UHCPlayer;

class TimeBomb extends Scenario
{
    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event)
    {
        if(UHC::getUHCManager()->isStarted()){
            $event->setDrops([]);
            $player = $event->getPlayer();
            if($player instanceof UHCPlayer) {
                $this->spawnChest($player);
            }
        }
    }

    /**
     * @param UHCPlayer $player
     */
    public function spawnChest(UHCPlayer $player)
    {
        $position = $player->asPosition();

        $position->getLevel()->setBlock($position, Block::get(BlockIds::CHEST));
        $position->getLevel()->setBlock($position->add(1), Block::get(BlockIds::CHEST));

        $tile1 = $position->getLevel()->getTile($position);
        $tile2 = $position->getLevel()->getTile($position->add(1));

        if ($tile1 instanceof Chest and $tile2 instanceof Chest){
            $tile1->pairWith($tile2);
            $tile2->pairWith($tile1);

            foreach ($player->getInventory()->getContents() as $item) {
                $tile1->getInventory()->addItem($item);
            }
            if (UHC::getScenariomanager()::getScenario("GoldenHead")->isEnabled()) {
                $tile2->getInventory()->addItem(new \uhc\item\GoldenHead(1));
            }
            new TimeBombTask(UHC::getInstance(), $position);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "TimeBomb";
    }
}
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
use pocketmine\inventory\ShapedRecipe;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\tile\Skull;
use uhc\scenario\Scenario;
use uhc\scenario\ScenarioManager;
use uhc\UHC;

class GoldenHead extends Scenario
{
    public function __construct()
    {
        ItemFactory::registerItem(new \uhc\item\GoldenHead(), true);
        UHC::getInstance()->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(new \uhc\item\GoldenHead(1), [
            "iii",
            "ihi",
            "iii"
        ], [
            "i" => Item::get(ItemIds::GOLD_INGOT, 0, 1),
            "h" => Item::get(ItemIds::SKULL, 0, 1)
        ]));
    }

    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event)
    {
        if(UHC::getUHCManager()->isStarted()){
            if(!ScenarioManager::getScenario("TimeBomb")->isEnabled()) {
                //DeathPole
                $position = $event->getPlayer()->asPosition();

                $position->getLevel()->setBlock($position, Block::get(BlockIds::SKULL_BLOCK, Skull::TYPE_HUMAN));
                $position->getLevel()->setBlock($position->subtract(0, 1, 0), Block::get(BlockIds::NETHER_BRICK_FENCE));
                $position->getLevel()->setBlock($position->subtract(1, 1, 0), Block::get(BlockIds::NETHER_BRICK_FENCE));
                $position->getLevel()->setBlock($position->subtract(0, 1, 0)->add(1), Block::get(BlockIds::NETHER_BRICK_FENCE));
                $position->getLevel()->setBlock($position->subtract(0, 2, 0), Block::get(BlockIds::NETHER_BRICK_FENCE));
            }
        }
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return "GoldenHead";
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/5/2017
 * Time: 8:47 PM
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
    public function onBreak(BlockBreakEvent $event)
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
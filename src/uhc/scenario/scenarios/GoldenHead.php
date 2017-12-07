<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/7/2017
 * Time: 10:53 PM
 */

namespace uhc\scenario\scenarios;

use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use uhc\scenario\Scenario;
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
            "h" => Item::get(ItemIds::MOB_HEAD, 0, 1)
        ]));
    }

    /**
     * @param PlayerDeathEvent $event
     */
    public function onDeath(PlayerDeathEvent $event)
    {
        if(UHC::getUHCManager()->isStarted()){
            $position = $event->getPlayer()->asPosition();

            //DeathPole
            $position->getLevel()->setBlock($position, Block::get(BlockIds::MOB_HEAD_BLOCK));
            $position->getLevel()->setBlock($position->subtract(0, 1, 0), Block::get(BlockIds::NETHER_BRICK_FENCE));
            $position->getLevel()->setBlock($position->subtract(1, 1, 0), Block::get(BlockIds::NETHER_BRICK_FENCE));
            $position->getLevel()->setBlock($position->subtract(0, 1, 0)->add(1), Block::get(BlockIds::NETHER_BRICK_FENCE));
            $position->getLevel()->setBlock($position->subtract(0, 2, 0), Block::get(BlockIds::NETHER_BRICK_FENCE));
        }
    }

    public function getName() : string
    {
        return "GoldenHead";
    }
}
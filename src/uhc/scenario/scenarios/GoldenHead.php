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
use pocketmine\entity\Effect;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\inventory\ShapedRecipe;
use pocketmine\item\GoldenApple;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;
use uhc\scenario\Scenario;
use uhc\UHC;

class GoldenHead extends Scenario
{
    public function __construct()
    {
        $GoldenHead = new class extends GoldenApple
        {
            /**
             * GoldenHead constructor.
             * @param int $meta
             */
            public function __construct($meta = 0)
            {
                parent::__construct($meta);
            }

            /**
             * @return array
             */
            public function getAdditionalEffects() : array
            {
                return [
                    Effect::getEffect(Effect::REGENERATION)->setAmplifier(1)->setDuration(20 * ($this->getDamage() == 1 ? 10 : 5)),
                    Effect::getEffect(Effect::ABSORPTION)->setDuration(20 * 120)
                ];
            }

            /**
             * @return string
             */
            public function getCustomName(): string
            {
                return $this->getDamage() == 1 ? TextFormat::RESET . TextFormat::GOLD . "GoldenHead" : TextFormat::RESET . TextFormat::YELLOW . "GoldenApple";
            }

            public function hasCustomName(): bool
            {
                return true;
            }

        };
        ItemFactory::registerItem($GoldenHead, true);
        UHC::getInstance()->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(Item::get(ItemIds::GOLDEN_APPLE, 1, 1), [
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
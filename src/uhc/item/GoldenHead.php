<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/8/2017
 * Time: 12:12 AM
 */

namespace uhc\item;


use pocketmine\entity\Effect;
use pocketmine\item\GoldenApple;
use pocketmine\utils\TextFormat;

class GoldenHead extends GoldenApple
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

}
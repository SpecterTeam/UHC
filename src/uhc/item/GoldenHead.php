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
    public function getCustomName() : string
    {
        //Hope it will change the name Lol
        return $this->getDamage() == 1 ? TextFormat::RESET . TextFormat::GOLD . "GoldenHead" : TextFormat::RESET . TextFormat::YELLOW . "GoldenApple";
    }

    /**
     * @return bool
     */
    public function hasCustomName(): bool
    {
        return true;
    }

}
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

namespace uhc;


use pocketmine\utils\TextFormat;

class Utils extends \pocketmine\utils\Utils
{
    const PREFIX = TextFormat::BOLD . TextFormat::DARK_GRAY . "[" . TextFormat::RESET . TextFormat::YELLOW . "UHC" . TextFormat::BOLD . TextFormat::DARK_GRAY . "]" . TextFormat::RESET;

    /**
     * @return string
     */
    public static function getPrefix() : string
    {
        return self::PREFIX;
    }

    /**
     * @param string $message
     * @return string
     */
    public static function getColors(string $message) : string
    {
        return str_replace("&k", TextFormat::OBFUSCATED, str_replace("&r",TextFormat::RESET, str_replace("&l",TextFormat::BOLD, str_replace("&o",TextFormat::ITALIC, str_replace("&f",TextFormat::WHITE, str_replace("&e",TextFormat::YELLOW, str_replace("&d",TextFormat::LIGHT_PURPLE, str_replace("&c",TextFormat::RED, str_replace("&b",TextFormat::AQUA, str_replace("&a",TextFormat::GREEN, str_replace("&0",TextFormat::BLACK, str_replace("&9",TextFormat::BLUE, str_replace("&8",TextFormat::DARK_GRAY, str_replace("&7",TextFormat::GRAY, str_replace("&6",TextFormat::GOLD, str_replace("&5",TextFormat::DARK_PURPLE, str_replace("&4",TextFormat::DARK_RED, str_replace("&3",TextFormat::DARK_AQUA, str_replace("&2",TextFormat::DARK_GREEN, str_replace("&1",TextFormat::DARK_BLUE, $message))))))))))))))))))));
    }

    /**
     * @param int $from
     * @param int $to
     * @return int
     */
    public static function getRandomNumber(int $from = 10000, int $to = PHP_INT_MAX) : int
    {
        return mt_rand($from, $to);
    }

}
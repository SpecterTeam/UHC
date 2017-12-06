<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/5/2017
 * Time: 11:52 PM
 */

namespace uhc;


use pocketmine\utils\TextFormat;

class Utils
{
    const PREFIX = TextFormat::BOLD . TextFormat::DARK_GRAY . "[" . TextFormat::RESET . TextFormat::YELLOW . "UHC" . TextFormat::BOLD . TextFormat::DARK_GRAY . "]" . TextFormat::RESET;

    /**
     * @return string
     */
    public static function getPrefix() : string
    {
        return self::PREFIX;
    }
}
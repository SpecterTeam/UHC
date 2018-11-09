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


use pocketmine\utils\Config;

class LangManager
{
    //TODO: More languages

    const DEFAULT_LANG = "eng";
    const LANGS_FOLDER = "lang";

    const START_GAME = "start.game";
    const STOP_GAME = "stop.game";
    const END_GAME = "end.game";
    const DEATH = "died";
    const JOIN_GAME = "join.game";
    const QUIT_GAME = "quit.game";
    const WIN_GAME = "win.game";
    private $default = self::DEFAULT_LANG;
    private $plugin;

    private static $langs = [];

    /**
     * LangManager constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        $this->setPlugin($plugin);
        if(!is_dir($plugin->getDataFolder() . self::LANGS_FOLDER)){
            @mkdir($plugin->getDataFolder() . self::LANGS_FOLDER);
        }
        $this->registerDefaultLanguage();
    }

    public function registerDefaultLanguage() : void
    {
        $messages = [
            self::START_GAME => "{prefix} &athe game has started!",
            self::STOP_GAME => "{prefix} &4the game has stopped!",
            self::END_GAME => "{prefix} &athe game has ended!",
            self::DEATH => "{prefix} &4{death} died.",
            self::JOIN_GAME => "{prefix} &7{joined} has joined the game!",
            self::QUIT_GAME => "{prefix} &7{left} has left the game!"
        ];
        $config = new Config($this->getPlugin()->getDataFolder() . self::LANGS_FOLDER . DIRECTORY_SEPARATOR . self::DEFAULT_LANG . ".yml", Config::YAML, $messages);
        self::$langs["eng"] = $config->getAll(true);
    }

    /**
     * @param string $message
     * @param string $lang
     * @return string
     */
    public static function translate(string $message, string $lang) : string
    {
        if(isset(self::$langs[$lang][$message])){
            return Utils::getColors(self::$langs[$lang][$message]);
        }
        return Utils::getColors($message);
    }

    /**
     * @return string
     */
    public function getDefault() : string
    {
        return $this->default;
    }

    /**
     * @param string $default
     */
    public function setDefault(string $default) : void
    {
        $this->default = $default;
    }

    /**
     * @return UHC
     */
    public function getPlugin() : UHC
    {
        return $this->plugin;
    }

    /**
     * @param UHC $plugin
     */
    public function setPlugin(UHC $plugin)
    {
        $this->plugin = $plugin;
    }
}
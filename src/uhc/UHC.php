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

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use uhc\listener\PlayerListener;
use uhc\listener\ScenarioListener;
use uhc\listener\UHCListener;
use uhc\scenario\ScenarioManager;
use uhc\task\UHCTask;

class UHC extends PluginBase
{
    const CONFIG_FILE = "config.yml";

    public static $instance;
    public static $uhcmanager, $scenariomanager, $langmanager;
    public static $config;

    /**
     * @return Config
     */
    public static function getConfigFile() : Config
    {
        return self::$config;
    }

    /**
     * @param Config $config
     */
    public static function setConfigFile(Config $config)
    {
        self::$config = $config;
    }

    /**
     * @return LangManager
     */
    public static function getLangmanager() : LangManager
    {
        return self::$langmanager;
    }

    /**
     * @param LangManager $langmanager
     */
    public static function setLangmanager(LangManager $langmanager) : void
    {
        self::$langmanager = $langmanager;
    }

    public function registerConfig() : void
    {
        if (!is_dir($this->getDataFolder())) @mkdir($this->getDataFolder());
        self::setConfigFile(new Config($this->getDataFolder() . self::CONFIG_FILE, Config::YAML, [
            "levels" => [
                "lobby" => "world",
                "game" => "UHC"
            ],
            "time" => [
                "grace" => UHCTask::GRACE_TIME,
                "end" => UHCTask::END_TIME
            ],
            "default_lang" => "eng"
        ]));
    }


    public function onEnable() : void
    {
        self::setInstance($this);
        $this->registerConfig();
        $this->registerListeners();
        $this->registerManagers();
    }

    /**
     * @return UHC
     */
    public static function getInstance() : UHC
    {
        return self::$instance;
    }

    /**
     * @param UHC $instance
     */
    public static function setInstance(UHC $instance) : void
    {
        self::$instance = $instance;
    }

    public function registerManagers() : void
    {
        self::setScenariomanager(new ScenarioManager($this));
        self::setUHCManager(new UHCManager($this, self::getConfigFile()->getNested("levels.game")));
        self::setLangmanager(new LangManager($this));
    }

    public function registerListeners() : void
    {
        new ScenarioListener($this);
        new PlayerListener($this);
        new UHCListener($this);
    }

    /**
     * @return UHCManager
     */
    public static function getUHCManager() : UHCManager
    {
        return self::$uhcmanager;
    }

    /**
     * @param UHCManager $uhcmanager
     */
    public static function setUHCManager(UHCManager $uhcmanager) : void
    {
        self::$uhcmanager = $uhcmanager;
    }

    /**
     * @return ScenarioManager
     */
    public static function getScenariomanager() : ScenarioManager
    {
        return self::$scenariomanager;
    }

    /**
     * @param ScenarioManager $scenariomanager
     */
    public static function setScenariomanager(ScenarioManager $scenariomanager) : void
    {
        self::$scenariomanager = $scenariomanager;
    }

}

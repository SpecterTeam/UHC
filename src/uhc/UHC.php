<?php

namespace uhc;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use uhc\listener\ScenarioListener;
use uhc\scenario\ScenarioManager;
use uhc\task\UHCTask;

class UHC extends PluginBase
{
    const CONFIG_FILE = "config.yml";

    public static $instance;
    public static $uhcmanager, $scenariomanager;
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

    public function registerConfig()
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


    public function onEnable()
    {
        self::setInstance($this);
        $this->registerManagers();
        $this->registerListeners();
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
    public static function setInstance(UHC $instance)
    {
        self::$instance = $instance;
    }

    public function registerManagers()
    {
        self::setScenariomanager(new ScenarioManager($this));
        self::setUHCManager(new UHCManager($this, "UHC", $this->getServer()->getDefaultLevel())); //TODO: Make player able to config his own world
    }

    public function registerListeners()
    {
        new ScenarioListener($this);
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
    public static function setUHCManager(UHCManager $uhcmanager)
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
    public static function setScenariomanager(ScenarioManager $scenariomanager)
    {
        self::$scenariomanager = $scenariomanager;
    }

}

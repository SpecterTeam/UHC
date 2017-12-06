<?php

namespace uhc;

use pocketmine\plugin\PluginBase;
use uhc\listener\ScenarioListener;
use uhc\scenario\ScenarioManager;

class UHC extends PluginBase
{
    public static $instance;
    public static $uhcmanager, $scenariomanager;


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

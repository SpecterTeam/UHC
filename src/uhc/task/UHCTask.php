<?php
/**
 * Created by PhpStorm.
 * User: FRISCOWZ
 * Date: 12/5/2017
 * Time: 8:43 PM
 */

namespace uhc\task;


use pocketmine\scheduler\PluginTask;
use uhc\UHC;

class UHCTask extends PluginTask
{
    const GRACE = 0;
    const PVP = 1;
    const END = 2;

    const GRACE_TIME = 900;
    //NO PVP Time limit
    const END_TIME = 16;

    private $grace_time = self::GRACE_TIME;
    private $end_time = self::END_TIME;

    private $state = self::GRACE;
    private $time = 0;

    /**
     * UHCTask constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        parent::__construct($plugin);
        $this->setGraceTime($plugin::getConfigFile()->getAll(true)["time"]["grace"]);
        $this->setEndTime($plugin::getConfigFile()->getAll(true)["time"]["end"]);
        $this->setHandler($plugin->getServer()->getScheduler()->scheduleRepeatingTask($this, 20));
    }

    /**
     * Actions to execute when run
     *
     * @param int $currentTick
     *
     * @return void
     */
    public function onRun(int $currentTick)
    {
        switch ($this->getState()){
            case self::GRACE:
                $time = $this->getTime();
                $this->setTime(++$time);
                if ($time == self::GRACE_TIME){
                    $this->setState(self::PVP);
                    $this->setTime(0);
                    //TODO: State Change event
                    break;
                }
            break;

            case self::PVP:
                $time = $this->getTime();
                $this->setTime(++$time);
                if(count(UHC::getUHCManager()->getPlayers()) <= 1){
                    $this->setState(self::END);
                    $this->setTime(0);
                    //TODO: Win Function && Win Event
                }
            break;

            case self::END:
                $time = $this->getTime();
                $this->setTime(++$time);
                //TODO: Stop Function && Stop event
                if($time == $this->getEndTime()){
                    $this->getHandler()->cancel();
                }
            break;
        }
    }

    /**
     * @return int
     */
    public function getState() : int
    {
        return $this->state;
    }

    /**
     * @param int $state
     */
    public function setState(int $state)
    {
        $this->state = $state;
    }

    /**
     * @return int
     */
    public function getTime() : int
    {
        return $this->time;
    }

    /**
     * @param int $time
     */
    public function setTime(int $time)
    {
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getGraceTime() : int
    {
        return $this->grace_time;
    }

    /**
     * @param int $grace_time
     */
    public function setGraceTime(int $grace_time)
    {
        $this->grace_time = $grace_time;
    }

    /**
     * @return int
     */
    public function getEndTime() : int
    {
        return $this->end_time;
    }

    /**
     * @param int $end_time
     */
    public function setEndTime(int $end_time)
    {
        $this->end_time = $end_time;
    }
}
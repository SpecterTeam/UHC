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

    const GRACE_TIME = 900; //30 minutes, user will be able to change it via the config soon
    //NO PVP Time limit
    const END_TIME = 16; //16 Seconds, user will be able to change it via the config soon

    private $state = self::GRACE;
    private $time = 0;

    public function __construct(UHC $owner)
    {
        parent::__construct($owner);
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
                    //TODO: State Change event
                    break;
                }
            break;

            case self::PVP:
                $time = $this->getTime();
                $this->setTime(++$time);
            break;

            case self::END:
                $time = $this->getTime();
                $this->setTime(++$time);
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
}
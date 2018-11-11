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

namespace uhc\task;


use pocketmine\scheduler\Task;
use uhc\UHC;

class UHCTask extends Task
{
    const STARTING = 0;
    const GRACE = 1;
    const PVP = 2;
    const END = 3;

    const STARTING_TIME = 60;
    const GRACE_TIME = 900;
    //NO PVP Time limit
    const END_TIME = 16;

    private $grace_time = self::GRACE_TIME;
    private $end_time = self::END_TIME;

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
            case self::STARTING:
                $time = $this->getTime();
                $this->setTime(++$time);
                if($time == self::STARTING_TIME){
                    $this->setState(self::GRACE);
                    $this->setTime(0);
                }
            break;

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
        return UHC::getUHCManager()->getState();
    }

    /**
     * @param int $state
     */
    public function setState(int $state)
    {
        UHC::getUHCManager()->setState($state);
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
    public function setEndTime(int $end_time) : void
    {
        $this->end_time = $end_time;
    }
}
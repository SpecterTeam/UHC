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


use pocketmine\entity\Entity;
use pocketmine\entity\Skin;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\level\Explosion;
use pocketmine\level\Position;
use pocketmine\network\mcpe\protocol\AddPlayerPacket;
use pocketmine\network\mcpe\protocol\PlayerSkinPacket;
use pocketmine\network\mcpe\protocol\RemoveEntityPacket;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
use uhc\UHC;
use uhc\Utils;

class TimeBombTask extends PluginTask
{
    private $position;
    private $time = 30;
    private $id = 11525020;
    private $uuid = 11525020;

    /**
     * TimeBombTask constructor.
     * @param UHC $plugin
     * @param Position $position
     */
    public function __construct(UHC $plugin, Position $position)
    {
        parent::__construct($plugin);
        $this->setPosition($position);
        $this->setHandler($plugin->getServer()->getScheduler()->scheduleRepeatingTask($this, 20));
        $this->setId(++Entity::$entityCount);
        $this->setUuid(Utils::getRandomNumber());

        $pk = new AddPlayerPacket();
        $pk->uuid = $this->getUuid();
        $pk->username = "";
        $pk->entityRuntimeId = $this->getId();
        $pk->position = $this->asVector3(); //TODO: check offset
        $pk->item = ItemFactory::get(Item::AIR, 0, 0);

        $flags = (
            (1 << Entity::DATA_FLAG_CAN_SHOW_NAMETAG) |
            (1 << Entity::DATA_FLAG_ALWAYS_SHOW_NAMETAG) |
            (1 << Entity::DATA_FLAG_IMMOBILE)
        );
        $pk->metadata = [
            Entity::DATA_FLAGS =>   [Entity::DATA_TYPE_LONG,   $flags],
            Entity::DATA_NAMETAG => [Entity::DATA_TYPE_STRING, TextFormat::RED . "Chest will explode in few second(s)!"],
            Entity::DATA_SCALE =>   [Entity::DATA_TYPE_FLOAT,  0.01]
        ];

        $skinPk = new PlayerSkinPacket();
        $skinPk->uuid = $this->getUuid();
        $skinPk->skin = new Skin("Standard_Custom", \str_repeat("\x00", 8192));
        foreach ($position->getLevel()->getPlayers() as $player)
        {
            $player->dataPacket($pk);
            $player->dataPacket($skinPk);
        }
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick)
    {
        $time = $this->getTime();

        if($time <= 0){
            $explosion = new Explosion($this->getPosition(), 1);
            if($explosion->explodeA()){
                $explosion->explodeB();
            }
            $pk = new RemoveEntityPacket();
            $pk->entityUniqueId = $this->getId();
            foreach ($this->getPosition()->getLevel()->getPlayers() as $player) {
                $player->dataPacket($pk);
            }
            $this->getHandler()->cancel();
            return;
        } else {
            $this->setTime(--$time);
        }
    }

    /**
     * @return Position
     */
    public function getPosition() : Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;
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
    public function getUuid() : int
    {
        return $this->uuid;
    }

    /**
     * @param int $uuid
     */
    public function setUuid(int $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
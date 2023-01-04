<?php

namespace Core\Modules;

use Core\AcePlayer;
use pocketmine\entity\Entity;
use pocketmine\entity\Skin;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\convert\SkinAdapterSingleton;
use pocketmine\network\mcpe\protocol\AddPlayerPacket;
use pocketmine\network\mcpe\protocol\PlayerSkinPacket;
use pocketmine\network\mcpe\protocol\RemoveActorPacket;
use pocketmine\utils\UUID;

class FakePlayerModule {
    /** @var Skin|null  */
    public ?Skin $skin = null;
    /** @var UUID|null  */
    public ?UUID $uuid = null;
    /** @var Vector3|null  */
    public ?Vector3 $pos = null;
    /** @var string|null  */
    public ?string $text = null;
    /** @var int  */
    private int $entityId;

    /**
     * @param Vector3 $pos
     */
    public function __construct(Vector3 $pos) {
        $this->pos = $pos;
        $this->uuid = UUID::fromRandom();
        $this->entityId = Entity::$entityCount++;
    }

    /**
     * @return Vector3
     */
    public function getPos(): Vector3 {
        return $this->pos;
    }

    /**
     * @return Skin
     */
    public function getSkin(): Skin {
        return $this->skin;
    }

    /**
     * @param AcePlayer $player
     * @param Skin $skin
     * @return void
     */
    public function setSkin(AcePlayer $player, Skin $skin): void {
        $this->skin = $skin;
        $this->update($player);
    }

    /**
     * @return UUID
     */
    public function getUuid(): UUID {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param string $text
     * @return void
     */
    public function setText(string $text): void {
        $this->text = $text;
    }

    /**
     * @param AcePlayer $player
     * @return bool
     */
    public function update(AcePlayer $player): bool {
        if ($player->isOnline()) {
            $pk = new AddPlayerPacket();
            $pk->uuid = $this->getUuid();
            $pk->username = $this->getText();
            $pk->entityRuntimeId = $this->entityId;
            $pk->position = $this->getPos();
            $pk->motion = new Vector3();
            $pk->yaw = 90;
            $pk->pitch = 0;
            $pk->metadata = [];
            $player->dataPacket($pk);
            $pk = new PlayerSkinPacket();
            $pk->uuid = $this->getUuid();
            $pk->skin = SkinAdapterSingleton::get()->toSkinData($this->getSkin());
            $player->dataPacket($pk);
            return true;
        } else {
            $this->remove($player);
        }
        return false;
    }

    public function remove(AcePlayer $player): void {
        $pk = new RemoveActorPacket();
        $pk->entityUniqueId = $this->entityId;
        $player->sendDataPacket($pk);
    }
}
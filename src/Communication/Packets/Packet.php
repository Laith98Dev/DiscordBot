<?php
/*
 * DiscordBot, PocketMine-MP Plugin.
 *
 * Licensed under the Open Software License version 3.0 (OSL-3.0)
 * Copyright (C) 2020-present JaxkDev
 *
 * Twitter :: @JaxkDev
 * Discord :: JaxkDev
 * Email   :: JaxkDev@gmail.com
 */

namespace JaxkDev\DiscordBot\Communication\Packets;

use JaxkDev\DiscordBot\Communication\BinarySerializable;
use JaxkDev\DiscordBot\Communication\BinaryStream;

abstract class Packet implements \JsonSerializable, BinarySerializable{

    public static int $UID_COUNT = 1;

    protected int $UID;

    public function __construct(?int $uid = null){
        if($uid === null){
            if(Packet::$UID_COUNT > 4294967295){
                //32bit int overflow, reset.
                Packet::$UID_COUNT = 1;
            }
            $this->UID = Packet::$UID_COUNT++;
        }else{
            $this->UID = $uid;
        }
    }

    public function getUID(): int{
        return $this->UID;
    }

    abstract public function binarySerialize(): BinaryStream;
    abstract public static function fromBinary(BinaryStream $stream): self; //Update self reference by adding abstract interface function.

    abstract public function jsonSerialize(): array;
    abstract public static function fromJson(array $data): self;
}
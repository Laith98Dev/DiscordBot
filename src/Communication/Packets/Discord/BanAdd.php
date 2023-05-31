<?php
/*
 * DiscordBot, PocketMine-MP Plugin.
 *
 * Licensed under the Open Software License version 3.0 (OSL-3.0)
 * Copyright (C) 2020-present JaxkDev
 *
 * Twitter :: @JaxkDev
 * Discord :: JaxkDev#2698
 * Email   :: JaxkDev@gmail.com
 */

namespace JaxkDev\DiscordBot\Communication\Packets\Discord;

use JaxkDev\DiscordBot\Models\Ban;
use JaxkDev\DiscordBot\Communication\Packets\Packet;

class BanAdd extends Packet{

    /** @var Ban */
    private $ban;

    public function __construct(Ban $ban){
        parent::__construct();
        $this->ban = $ban;
    }

    public function getBan(): Ban{
        return $this->ban;
    }

    // Explicit serialization to significantly reduce serialized size.

    public function __serialize(): array{
        return [
            $this->UID,
            $this->ban
        ];
    }

    public function __unserialize(array $data): void{
        [
            $this->UID,
            $this->ban
        ] = $data;
    }
}
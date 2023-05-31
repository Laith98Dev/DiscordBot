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

namespace JaxkDev\DiscordBot\Communication\Packets\Plugin;

use JaxkDev\DiscordBot\Communication\Packets\Packet;
use JaxkDev\DiscordBot\Models\Messages\Message;

class RequestEditMessage extends Packet{

    /** @var Message */
    private $message;

    public function __construct(Message $message){
        parent::__construct();
        $this->message = $message;
    }

    public function getMessage(): Message{
        return $this->message;
    }

    public function __serialize(): array{
        return [
            $this->UID,
            $this->message
        ];
    }

    public function __unserialize(array $data): void{
        [
            $this->UID,
            $this->message
        ] = $data;
    }
}
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

class RequestPinMessage extends Packet{

    /** @var string */
    private $channel_id;

    /** @var string */
    private $message_id;

    public function __construct(string $channel_id, string $message_id){
        parent::__construct();
        $this->message_id = $message_id;
        $this->channel_id = $channel_id;
    }

    public function getMessageId(): string{
        return $this->message_id;
    }

    public function getChannelId(): string{
        return $this->channel_id;
    }

    public function serialize(): ?string{
        return serialize([
            $this->UID,
            $this->message_id,
            $this->channel_id
        ]);
    }

    public function unserialize($data): void{
        $data = unserialize($data);
        if(!is_array($data)){
            throw new \AssertionError("Failed to unserialize data to array, got '".gettype($data)."' instead.");
        }
        [
            $this->UID,
            $this->message_id,
            $this->channel_id
        ] = $data;
    }
}
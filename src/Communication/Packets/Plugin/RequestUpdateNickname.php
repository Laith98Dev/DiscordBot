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

class RequestUpdateNickname extends Packet{

    /** @var string */
    private $server_id;

    /** @var string */
    private $user_id;

    /** @var string|null */
    private $nickname;

    public function __construct(string $server_id, string $user_id, ?string $nickname = null){
        parent::__construct();
        $this->server_id = $server_id;
        $this->user_id = $user_id;
        $this->nickname = $nickname;
    }

    public function getServerId(): string{
        return $this->server_id;
    }

    public function getUserId(): string{
        return $this->user_id;
    }

    public function getNickname(): ?string{
        return $this->nickname;
    }

    public function __serialize(): array{
        return [
            $this->UID,
            $this->server_id,
            $this->user_id,
            $this->nickname
        ];
    }

    public function __unserialize($data): void{
        try{
            [
                $this->UID,
                $this->server_id,
                $this->user_id,
                $this->nickname
            ] = $data;
        }catch(\Throwable $e){
            throw new \AssertionError("Failed to unserialize '".get_parent_class($this)."'", 0, $e);
        }
    }
}
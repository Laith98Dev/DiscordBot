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

use JaxkDev\DiscordBot\Models\Member;
use JaxkDev\DiscordBot\Models\User;
use JaxkDev\DiscordBot\Communication\Packets\Packet;

class MemberJoin extends Packet{

    /** @var Member */
    private $member;

    /** @var User */
    private $user;

    public function __construct(Member $member, User $user){
        parent::__construct();
        $this->member = $member;
        $this->user = $user;
    }

    public function getMember(): Member{
        return $this->member;
    }

    public function getUser(): User{
        return $this->user;
    }

    public function __serialize(): array{
        return [
            $this->UID,
            $this->member,
            $this->user
        ];
    }

    public function __unserialize($data): void{
        try{
            [
                $this->UID,
                $this->member,
                $this->user
            ] = $data;
        }catch(\Throwable $e){
            throw new \AssertionError("Failed to unserialize '".get_parent_class($this)."'", 0, $e);
        }
    }
}
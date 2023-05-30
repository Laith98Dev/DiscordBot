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

use JaxkDev\DiscordBot\Communication\Packets\Packet;
use JaxkDev\DiscordBot\Models\VoiceState;

class VoiceStateUpdate extends Packet{

    /** @var string */
    private $member_id;

    /** @var VoiceState */
    private $voice_state;

    public function __construct(string $member_id, VoiceState $voice_state){
        parent::__construct();
        $this->member_id = $member_id;
        $this->voice_state = $voice_state;
    }

    public function getMemberId(): string{
        return $this->member_id;
    }

    public function getVoiceState(): VoiceState{
        return $this->voice_state;
    }

    public function __serialize(): array{
        return [
            $this->UID,
            $this->member_id,
            $this->voice_state
        ];
    }

    public function __unserialize($data): void{
        try{
            [
                $this->UID,
                $this->member_id,
                $this->voice_state
            ] = $data;
        }catch(\Throwable $e){
            throw new \AssertionError("Failed to unserialize '".get_parent_class($this)."'", 0, $e);
        }
    }
}
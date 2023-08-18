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

namespace JaxkDev\DiscordBot\Communication;

use function sizeof;
use function strlen;

class BinaryStream extends \pocketmine\utils\BinaryStream{

    public function putString(string $value): void{
        $this->putInt(strlen($value));
        $this->put($value);
    }

    public function getString(): string{
        return $this->get($this->getInt());
    }

    /** @param BinarySerializable<mixed> $value */
    public function putSerializable(BinarySerializable $value): void{
        $this->put($value->binarySerialize()->getBuffer());
    }

    /**
     * @template T of BinarySerializable<mixed>
     * @param class-string<T> $class
     * @return T
     */
    public function getSerializable(string $class){
        /** @var T $x */
        $x = $class::fromBinary($this);
        return $x;
    }

    /** @param BinarySerializable<mixed>[] $values */
    public function putSerializableArray(array $values): void{
        $this->putInt(sizeof($values));
        foreach($values as $value){
            $this->put($value->binarySerialize()->getBuffer());
        }
    }

    /**
     * @template T of BinarySerializable<mixed>
     * @param class-string<T> $class
     * @return T[]
     */
    public function getSerializableArray(string $class): array{
        $array = [];
        for($i = 0, $size = $this->getInt(); $i < $size; $i++){
            /** @var T $x */
            $x = $class::fromBinary($this);
            $array[] = $x;
        }
        return $array;
    }

    /** @param BinarySerializable<mixed>[]|null $values */
    public function putNullableSerializableArray(?array $values): void{
        if($values === null){
            $this->putBool(false);
            return;
        }
        $this->putBool(true);
        $this->putSerializableArray($values);
    }

    /**
     * @template T of BinarySerializable<mixed>
     * @param class-string<T> $class
     * @return T[]|null
     */
    public function getNullableSerializableArray(string $class): ?array{
        if(!$this->getBool()){
            return null;
        }
        $array = [];
        for($i = 0, $size = $this->getInt(); $i < $size; $i++){
            /** @var T $x */
            $x = $class::fromBinary($this);
            $array[] = $x;
        }
        return $array;
    }

    /** @param string[] $values */
    public function putStringArray(array $values): void{
        $this->putInt(sizeof($values));
        foreach($values as $value){
            $this->putString($value);
        }
    }

    /** @return string[] */
    public function getStringArray(): array{
        $array = [];
        for($i = 0, $size = $this->getInt(); $i < $size; $i++){
            $array[] = $this->getString();
        }
        return $array;
    }

    /** @param string[]|null $values */
    public function putNullableStringArray(?array $values): void{
        if($values === null){
            $this->putBool(false);
            return;
        }
        $this->putBool(true);
        $this->putInt(sizeof($values));
        foreach($values as $value){
            $this->putString($value);
        }
    }

    /** @return string[]|null */
    public function getNullableStringArray(): ?array{
        if(!$this->getBool()){
            return null;
        }
        $array = [];
        for($i = 0, $size = $this->getInt(); $i < $size; $i++){
            $array[] = $this->getString();
        }
        return $array;
    }

    /** @param int[] $values */
    public function putByteArray(array $values): void{
        $this->putInt(sizeof($values));
        foreach($values as $value){
            $this->putByte($value);
        }
    }

    /** @return int[] */
    public function getByteArray(): array{
        $array = [];
        for($i = 0, $size = $this->getInt(); $i < $size; $i++){
            $array[] = $this->getByte();
        }
        return $array;
    }

    /** @param int[] $values */
    public function putIntArray(array $values): void{
        $this->putInt(sizeof($values));
        foreach($values as $value){
            $this->putInt($value);
        }
    }

    /** @return int[] */
    public function getIntArray(): array{
        $array = [];
        for($i = 0, $size = $this->getInt(); $i < $size; $i++){
            $array[] = $this->getInt();
        }
        return $array;
    }

    //Nullables

    public function putNullable(?string $value): void{
        $this->putBool($value !== null);
        if($value !== null){
            $this->put($value);
        }
    }

    public function putNullableBool(?bool $value): void{
        $this->putBool($value !== null);
        if($value !== null){
            $this->putBool($value);
        }
    }

    public function getNullableBool(): ?bool{
        return $this->getBool() ? $this->getBool() : null;
    }

    public function putNullableByte(?int $value): void{
        $this->putBool($value !== null);
        if($value !== null){
            $this->putByte($value);
        }
    }

    public function getNullableByte(): ?int{
        return $this->getBool() ? $this->getByte() : null;
    }

    public function putNullableInt(?int $value): void{
        $this->putBool($value !== null);
        if($value !== null){
            $this->putInt($value);
        }
    }

    public function getNullableInt(): ?int{
        return $this->getBool() ? $this->getInt() : null;
    }

    public function putNullableLong(?int $value): void{
        $this->putBool($value !== null);
        if($value !== null){
            $this->putLong($value);
        }
    }

    public function getNullableLong(): ?int{
        return $this->getBool() ? $this->getLong() : null;
    }

    public function putNullableString(?string $value): void{
        $this->putBool($value !== null);
        if($value !== null){
            $this->putString($value);
        }
    }

    public function getNullableString(): ?string{
        return $this->getBool() ? $this->getString() : null;
    }

    /** @param BinarySerializable<mixed>|null $value */
    public function putNullableSerializable(?BinarySerializable $value): void{
        $this->putBool($value !== null);
        if($value !== null){
            $this->put($value->binarySerialize()->getBuffer());
        }
    }

    /**
     * @template T of BinarySerializable<mixed>
     * @param class-string<T> $class
     * @return T|null
     */
    public function getNullableSerializable(string $class){
        if($this->getBool()){
            /** @var T $x */
            $x = $class::fromBinary($this);
            return $x;
        }else{
            return null;
        }
    }
}
<?php

declare(strict_types=1);

namespace App\DTO\Traits;

trait MakeSelf
{
    public static function make(array $args=[]): self
    {
        return new self($args);
    }
}

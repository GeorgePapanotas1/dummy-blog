<?php

namespace App\Dto\Common\Forms;

abstract class BaseForm
{
    abstract public function toArray(): array;

    abstract public static function fromArray(array $data): self;
}

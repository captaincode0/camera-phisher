<?php

declare(strict_types=1);

namespace Camphish\Data\Model;

interface StorableInterface
{
    public function toArray(): array;
}

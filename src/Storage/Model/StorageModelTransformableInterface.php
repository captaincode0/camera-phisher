<?php

declare(strict_types=1);

namespace Camphish\Data\Model;

interface StorageModelTransformableInterface
{
    public function toModel(): StorableDataInterface;
}

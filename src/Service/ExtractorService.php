<?php

declare(strict_types=1);

namespace Camphish\Service;

use Camphish\Data\Model\StorageModelTransformableInterface;
use Camphish\Storage\Handler\AbstractHandler;

class ExtractorService implements ExtractorServiceInterface
{
    private StorageModelTransformableInterface $dataRetriever;

    private AbstractHandler $storage;

    public function __construct(
        StorageModelTransformableInterface $dataRetriever,
        AbstractHandler $storage
    ) {
        $this->dataRetriever = $dataRetriever;
        $this->storage = $storage;
    }

    public function extract(): void
    {
        $storageModel = $this->dataRetriever->toModel();

        $this->storage->save($storageModel);
    }
}

<?php

declare(strict_types=1);

namespace Camphish\Storage\Handler;

use Camphish\Data\Model\StorableDataInterface;

abstract class AbstractHandler
{
    public const SOURCE_FILE_SYSTEM = 'SourceFileSystem';

    protected string $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    protected function buildExceptionMessage(string $message): string
    {
        return sprintf(
            '%sError: %s',
            $this->source,
            $message
        );
    }

    public abstract function open(string $resourcePath = ''): void;
    public abstract function close(): void;
    public abstract function save(StorableDataInterface $element): void;
}

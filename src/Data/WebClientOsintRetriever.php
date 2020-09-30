<?php

declare(strict_types=1);

namespace Camphish\Data;

use Camphish\Data\Model\StorableDataInterface;
use Camphish\Data\Model\StorageModelTransformableInterface;
use Camphish\Data\Model\WebClientDataModel;

class WebClientOsintRetriever implements StorageModelTransformableInterface {
    private array $server;

    public const FIELD_SERVER_HTTP_CLIENT_IP = 'HTTP_CLIENT_IP';
    public const FIELD_SERVER_HTTP_X_FORWARDED_FOR = 'HTTP_X_FORWARDED_FOR';
    public const FIELD_SERVER_REMOTE_ADDR = 'REMOTE_ADDR';
    public const FIELD_USER_AGENT = 'HTTP_USER_AGENT';

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function getIpAddress(): string
    {
        if ($this->isKeyInServer(self::FIELD_SERVER_HTTP_CLIENT_IP)) {
            return $this->server[self::FIELD_SERVER_HTTP_CLIENT_IP];
        } elseif ($this->isKeyInServer(self::FIELD_SERVER_HTTP_X_FORWARDED_FOR)) {
            return $this->server[self::FIELD_SERVER_HTTP_X_FORWARDED_FOR];
        }

        return $this->server[self::FIELD_SERVER_REMOTE_ADDR] ?? '';
    }

    public function getUserAgent(): string
    {
        return $this->server[self::FIELD_USER_AGENT] ?? '';
    }

    private function isKeyInServer(string $key): bool
    {
        return array_key_exists($key, $this->server);
    }

    public function toModel(): StorableDataInterface
    {
        $webClientModel = new WebClientDataModel();

        $webClientModel
            ->setIpAddress($this->getIpAddress())
            ->setUserAgent($this->getUserAgent());

        return $webClientModel;
    }
}

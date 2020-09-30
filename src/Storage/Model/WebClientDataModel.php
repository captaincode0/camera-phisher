<?php

declare(strict_types=1);

namespace Camphish\Data\Model;

class WebClientDataModel implements StorableDataInterface
{
    public const FIELD_IP_ADDRESS = 'Ip Address';
    public const FIELD_IP_WEB_BROWSER = 'Web Browser';

    private string $ipAddress;

    private string $userAgent;

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function toArray(): array
    {
        return [
            self::FIELD_IP_ADDRESS => $this->getIpAddress(),
            self::FIELD_IP_WEB_BROWSER => $this->getUserAgent(),
        ];
    }
}

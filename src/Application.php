<?php

declare(strict_types=1);

namespace Camphish;

use Camphish\Service\ExtractorServiceInterface;

class Application
{
    private ExtractorServiceInterface $extractorService;

    public function __construct(ExtractorServiceInterface $extractorService)
    {
        $this->extractorService = $extractorService;
    }

    public function run(): void
    {
        $this->extractorService->extract();
    }
}

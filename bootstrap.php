<?php

require "./src/Storage/Model/StorableInterface.php";
require "./src/Storage/Model/StorableDataInterface.php";
require "./src/Storage/Model/StorageModelTransformableInterface.php";
require "./src/Storage/Model/WebClientDataModel.php";
require "./src/Data/WebClientOsintRetriever.php";
require './src/Storage/Handler/AbstractHandler.php';
require './src/Storage/Handler/FileSystem/FileSystemHandler.php';
require './src/Service/ExtractorServiceInterface.php';
require './src/Service/ExtractorService.php';
require './src/Application.php';

use Camphish\Application;
use Camphish\Service\ExtractorService;
use Camphish\Data\WebClientOsintRetriever;
use Camphish\Storage\Handler\FileSystem\FileSystemHandler;

$webClientOsintRetriever = new WebClientOsintRetriever($_SERVER);
$fileSystemHandler = new FileSystemHandler();

$extractorService = new ExtractorService(
    $webClientOsintRetriever,
    $fileSystemHandler
);

$app = new Application($extractorService);

$app->run();

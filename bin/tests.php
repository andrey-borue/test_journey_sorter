<?php
include_once __DIR__ . '/../app/autoload.php';

$collectionTest = new \JourneyRouter\Tests\BoardingCard\BoardingCardCollectionTest();

$collectionTest->testSort();
$collectionTest->testConstructor();
$collectionTest->testSimpleRoute();
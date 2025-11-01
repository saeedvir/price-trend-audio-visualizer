<?php
require __DIR__ . '/../vendor/autoload.php';

use PriceTrendAudio\PriceTrend;
use PriceTrendAudio\AudioGenerator;

// Example price data
$prices = [100, 102, 105, 105, 105, 104, 102, 101, 101, 103, 104];
$dates  = ['2025-10-20','2025-10-21','2025-10-22','2025-10-23','2025-10-24','2025-10-25','2025-10-26','2025-10-27','2025-10-28','2025-10-29','2025-10-30'];

// Detect ranges
$ranges = PriceTrend::findDataRanges($prices, $dates, 2);

// Generate audio summary
AudioGenerator::joinRangeAudio($ranges, __DIR__ . '/../output.mp3');

// Generate random test ranges
$randomRanges = AudioGenerator::generateRandomData(100);
AudioGenerator::joinRangeAudio($randomRanges, __DIR__ . '/../output_random.mp3');

echo "Audio files generated.\n";

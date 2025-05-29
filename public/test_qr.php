<?php

// Adjust path if your vendor directory is elsewhere
require __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

echo "PHP Version: " . PHP_VERSION . "<br>";
echo "Testing Endroid QR Code...<br>";

try {
    $qrCode = Builder::create()
        ->writer(new PngWriter())
        ->data('Minimal Test Works!')
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(200)
        ->margin(10)
        ->build();

    $qrCode->saveToFile(__DIR__ . '/test_standalone_qr.png');
    echo "SUCCESS: QR Code generated as test_standalone_qr.png<br>";

} catch (Throwable $e) {
    echo "ERROR:<br>";
    echo "Class: " . get_class($e) . "<br>";
    echo "Message: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
    echo "<pre>Trace:\n" . $e->getTraceAsString() . "</pre><br>";
}
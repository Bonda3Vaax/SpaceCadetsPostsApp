<?php
function logError($errorMessage, $errorFile = 'error_log.txt') {
    $date = date('Y-m-d H:i:s');
    $logMessage = "[$date] ERROR: $errorMessage" . PHP_EOL;
    $logFilePath = __DIR__ . '/../logs/' . $errorFile;

       // Write the error message to the log file
    file_put_contents($logFilePath, $logMessage, FILE_APPEND);
}
?>
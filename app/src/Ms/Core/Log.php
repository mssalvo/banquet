<?php

namespace Banquet\Ms\Core;

class Log {
    private $filename;

    public function __construct() {
        $this->filename = defined('LOG_FILE_NAME') && LOG_FILE_NAME !== ''
            ? LOG_FILE_NAME
            : 'log.txt';
    }

    public static function writeError($message) {
        self::writeLog('ERROR', $message);
    }

    public static function writeInfo($message) {
        self::writeLog('INFO', $message);
    }

    private static function writeLog($level, $message) {
        $logLevel = defined('IS_LOG') && IS_LOG !== '' ? IS_LOG : 'ALL';

        if ($level === 'ERROR' && $logLevel !== 'ERROR' && $logLevel !== 'ALL') {
            return;
        }

        if ($level === 'INFO' && $logLevel !== 'INFO' && $logLevel !== 'ALL') {
            return;
        }

        $file = self::resolveLogFile();
        self::rotateIfNeeded($file);

        $dir = dirname($file);
        if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            return;
        }

        $line = date('Y-m-d G:i:s') . ' - ' . $level . ' - ' . $message . PHP_EOL;
        $written = @file_put_contents($file, $line, FILE_APPEND | LOCK_EX);

        if ($written === false) {
            $fallbackFile = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'log.txt';
            @file_put_contents($fallbackFile, $line, FILE_APPEND | LOCK_EX);
        }
    }

    private static function resolveLogFile() {
        $directory = defined('LOG_DIR_NAME') && LOG_DIR_NAME !== ''
            ? LOG_DIR_NAME
            : dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
        $filename = defined('LOG_FILE_NAME') && LOG_FILE_NAME !== ''
            ? LOG_FILE_NAME
            : 'log.txt';

        return rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $filename;
    }

    private static function rotateIfNeeded($file) {
        $maxSize = defined('LOG_MAX_SIZE') ? (int) LOG_MAX_SIZE : 1024 * 1024;

        if (!file_exists($file)) {
            return;
        }

        if (filesize($file) < $maxSize) {
            return;
        }

        $backup = $file . '.bak';
        if (file_exists($backup)) {
            @unlink($backup);
        }

        @rename($file, $backup);
    }
}
?>
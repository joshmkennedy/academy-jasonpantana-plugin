<?php

namespace JP;

/** @package JP */
class SyncLogger {
    public function __construct() {
        // $this->logFile = getAimAssetPath('logs/sync.log');
        // if (!file_exists($this->logFile)) {
        //     file_put_contents($this->logFile, '');
        // }
    }



    /**
     * @param string $message
     */
    public function log(string $message): void {
        $this->write($message);
    }

    /**
     * @param string $message 
     * @return void 
     */
    private function write(string $message): void {
        // TODO: make this env specific.
        error_log($message);
    }

    public function logD(mixed $message):void {
        $this->write(print_r($message, true));
    }
}

<?php

namespace JP;

/**
 * Wraps third party classes to prevent errors if this class is not defined or avaliable.
 **/

class SafeMethodCaller {
    private $instance;
    
    public function __construct($instance, public ?string $className = null) {
        $this->instance = $instance;
    }

    public function __call($method, $args) {
        if (is_object($this->instance) && method_exists($this->instance, $method)) {
            return call_user_func_array([$this->instance, $method], $args);
        }
        if ($this->instance === null) {
            error_log("❗ {$this->className} instance not found");
            return null;
        }
        error_log("❗ {$this->className} method not found");
        // Return default values for known method patterns.
        if (strpos($method, 'get') === 0) {
            return [];
        }

        return null;
    }
}




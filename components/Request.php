<?php

namespace app\components;

class Request
{
    private $storage;

    // public function __construct() {
        // $this->storage = $this->cleanInput($_REQUEST);
    // }

   
    public function __get($name) {
        if (isset($this->storage[$name])) return $this->storage[$name];
        return NULL;
    }
   
    private function cleanInput($data) {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->cleanInput($value);
            }
            return $cleaned;
        }
        return trim(htmlspecialchars($data, ENT_QUOTES));
    }

    public function getRequestEntries()
    {
        return $this->storage;
    }

    public function post() {
        $this->storage = $this->cleanInput($_POST);
        return $this->storage;
    }

        public function get() {
        $this->storage = $this->cleanInput($_GET);
        return $this;
    }
}
<?php

    class Environment {
        public static function getEnvVariables() {
            $envFile = file_get_contents(__DIR__ . '/../.env');
            $lines = explode("\n", $envFile);
            $env = [];
            foreach ($lines as $line) {
                if (trim($line) && strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $env[trim($key)] = trim($value);
                }
            }
            return $env;
        }
    }
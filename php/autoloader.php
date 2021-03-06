<?php
/**
 * Autoloader function to not worry about including stuff anymore
 *
 * @package    Autoloader
 * @author     Romain Laneuville <romain.laneuville@hotmail.fr>
 */

set_include_path(__DIR__);

spl_autoload_register(
    function ($className) {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if (stream_resolve_include_path($fileName) !== false) {
            include_once $fileName;
        }
    }
);

// Require the vendor composer autoloader
require_once 'vendor/autoload.php';

<?php

namespace App\Helpers;

class Registry {

    public static $data = [];
    public static $keyMappings = [];
    public static $invalidateKeys = [];
    public static $tableMappings = [];

    public static function setupTables()
    {
        $keys = [];

        $templateDirectory = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(APP_PATH.'Entity/', \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        foreach ($templateDirectory as $folder) {

            $className = 'App\\'.str_replace([APP_PATH, '/', '.php'], ['', '\\', ''], $folder->getPathName());

            if (!empty($keys[$className]) || $folder->isDir()) {
                continue;
            }

            if (strstr($className, 'Base') !== false || strstr($className, 'Interface') !== false) {
                continue;
            }

            $classMock = new $className;

            $primaryKey = $classMock->getTablePrefix();

            unset($classMock);

            $keys[$className] = $primaryKey;
        }

        static::$tableMappings = $keys;
    }

    public static function hasObject($type, $typeId): bool
    {
        if (!empty(static::$data[$type]) && !empty(static::$data[$type][$typeId])) {

            if (!empty(static::$invalidateKeys[$type])) {
                foreach (static::$invalidateKeys[$type] as $fieldKey => $entityMethod) {
                    if (static::$data[$type][$typeId]->$entityMethod() !== $data[$fieldKey]) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }

    public static function getObject($type, $typeId)
    {
        return static::$data[$type][$typeId];
    }

    public static function setObject($type, $typeId, $object)
    {
        if (empty(static::$data[$type])) {
            static::$data[$type] = [];
        }
        static::$data[$type][$typeId] = $object;
    }
}

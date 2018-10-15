<?php

namespace Morphable;

class Path
{
    /**
     * Normalize path
     * @param string path
     * @return string normalized path
     */
    public static function normalize(string $path)
    {
        return '/' . trim($path, '/');
    }

    /**
     * validate path
     * @param string path
     * @return bool
     */
    public static function validate(string $path)
    {
        return ! (bool) preg_match("/[^a-zA-Z0-9\/\.\-\_\\]/", $path);
    }

    /**
     * Recursively remove directories and files
     * @param string path to be unlinked
     * @return void
     */
    public static function unlinkDirectory(string $path)
    {
        if (!file_exists($path)) {
            return;
        }

        if (!is_dir($path)) {
            \unlink($path);
            return;
        }

        foreach (\scandir($path) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            self::unlinkDirectory("{$path}/{$item}");
        }
    }
}

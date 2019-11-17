<?php

namespace Morphable\SimpleCache;

class Path
{
    /**
     * check os is windows
     * @return bool
     */
    public static function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Normalize path
     * @param string path
     * @return string normalized path
     */
    public static function normalize(string $path)
    {
        if (preg_match('/\w\:/', $path) && self::isWindows()) {
            return trim(trim($path), '/');
        }

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

        \rmdir($path);
    }
}

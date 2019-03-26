<?php

namespace Morphable;

use \Morphable\SimpleCache\Path;
use \Morphable\SimpleCache\SerializeJson;
use \Morphable\SimpleCache\SerializeInterface;
use \Morphable\SimpleCache\Exception\ItemNotFound;
use \Morphable\SimpleCache\Exception\FailedToSetItem;
use \Morphable\SimpleCache\Exception\FailedToGetItem;

class SimpleCache
{
    /**
     * Base directory
     * @var string
     */
    private $directory;

    /**
     * Serialize adapter
     * @var object Morphable\SimpleCache\SerializeInterface
     */
    private $adapter;

    /**
     * Cache item extension
     * @var string
     */
    private $extension = '.cache';

    /**
     * Construct
     * @param string base directory
     * @param object Morphable\SimpleCache\SerializeInterface
     * @return void
     */
    public function __construct(string $directory, SerializeInterface $adapter = null)
    {
        $this->directory = Path::normalize($directory);

        $this->adapter = $adapter;
        if ($adapter === null) {
            $this->adapter = new SerializeJson();
        }
    }

    /**
     * Get and normalize full path
     * @param string id of cache item
     * @return string normalized path
     */
    private function getPath(string $id): string
    {
        return $this->directory . Path::normalize($id) . $this->extension;
    }

    /**
     * Get a cache item and unserialize it
     * @param string item id
     * @return array unserialized item
     */
    public function get(string $id): array
    {
        $path = $this->getPath($id);

        if (!$this->exists($id)) {
            throw new ItemNotFound();
        }

        $get = file_get_contents($path);

        if ($get === false) {
            throw new FailedToGetItem();
        }

        return $this->adapter->unserialize($get);
    }

    /**
     * Set cache item and serialize it
     * @param string cache item id
     * @param array content to be cached
     * @return void
     */
    public function set(string $id, array $content)
    {
        if (!file_exists($this->directory)) {
            mkdir($this->directory);
        }

        $path = $this->getPath($id);
        $dir = explode('/', $path);
        array_pop($dir);
        $dir = implode('/', $dir);

        if ($dir !== null && !is_dir($dir)) {
            mkdir($dir);
        }

        $put = file_put_contents($path, $this->adapter->serialize($content));

        if ($put === false) {
            throw new FailedToSetItem();
        }
    }

    /**
     * Check if item exists
     * @param string cache item id
     * @return bool
     */
    public function exists(string $id): bool
    {
        $path = $this->getPath($id);

        if (\file_exists($path)) {
            return true;
        }

        return false;
    }

    /**
     * Delete cache item of directory
     * @param string cache item id
     * @return void
     */
    public function delete(string $id)
    {
        $path = $this->getPath($id);
        path::unlinkDirectory($path);
    }

    /**
     * Clear cache directory
     * @return void
     */
    public function clear()
    {
        path::unlinkDirectory($this->directory);
    }
}

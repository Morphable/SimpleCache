<?php

namespace Morphable;

use \Morphable\SimpleCache;

class SimpleCacheTest extends \PHPUnit\Framework\TestCase
{
    public function testSetItem()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache');
        $cache->set('test_item', ['test' => 1]);

        $this->assertTrue($cache->exists('test_item'));
        $cache->clear();
    }

    public function testGetItem()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache');
        $cache->set('test_item', ['test' => 1]);

        $item = $cache->get('test_item');

        $this->assertTrue(is_array($item));
        $cache->clear();
    }

    public function testItemExists()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache');
        $cache->set('test_item', ['test' => 1]);

        $this->assertTrue($cache->exists('test_item'));
        $cache->clear();
    }

    public function testItemNotExists()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache');
        $this->assertTrue(!$cache->exists('test_item_not_exists'));
    }

    public function testClearItem()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache');
        $cache->set('test_item', ['test' => 1]);
        $cache->delete('test_item');

        $this->assertTrue(!$cache->exists('test_item'));
    }

    public function testClearDir()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache');
        $cache->set('/sub/test_item', ['test' => 1]);
        $cache->delete('sub');
        $this->assertTrue(!$cache->exists('sub/test_item'));
    }
}

<?php

namespace Morphable;

use \Morphable\SimpleCache;
use \Morphable\SimpleCache\Exception\FailedToGetItem;
use \Morphable\SimpleCache\Exception\FailedToSetItem;
use \Morphable\SimpleCache\Exception\ItemNotFound;
use \Morphable\SimpleCache\Exception\UnableToSerialize;
use \Morphable\SimpleCache\Exception\UnableToUnserialize;
use \Morphable\SimpleCache\SerializeInterface;
use \Morphable\SimpleCache\SerializeJson;
use \Morphable\SimpleCache\SerializeArray;

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

    public function testCreateWithSub()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache');
        $cache->set('/sub_dir/test_item', ['test' => 1]);
        $cache->set('/sub_dir/test_item/xxx', ['test' => 1]);
        $this->assertTrue($cache->exists('/sub_dir/test_item/xxx'));
        $cache->clear();
    }

    public function testArrayCache()
    {
        $cache = new SimpleCache(__DIR__ . '/.cache', new SerializeArray());
        $cache->set('test_item', ['test' => 1]);
        $cache->get('test_item');
        $this->assertTrue($cache->exists('test_item'));
        $cache->clear();
    }
}

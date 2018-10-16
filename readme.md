# Simple cache component
A simple cache component, easy to implement into any system
## Installing
```terminal
$ composer require morphable/simple-cache
```
## Usage
```php
<?php

use \Morphable\SimpleCache;

// cache dir
$cache = new SimpleCache($root . '/.cache');
$cache->set('my_cache_item', $cacheItem);
$cache->exists('my_cache_item'); // true
$cache->get('my_cache_item');
$cache->delete('my_cache_item');

```
## Create your own content serializer
```php
<?php

use \Morphable\SimpleCache\Exception\UnableToSerialize;
use \Morphable\SimpleCache\Exception\UnableToUnserialize;
use \Morphable\SimpleCache\SerializeInterface;

class MySerializer implements SerializeInterface
{
    public function serialize(array $content): string
    {
    }

    public function unserialize(string $content): array
    {
    }
}
```

Use it like this:

```php
use \Morphable\SimpleCache;

$serializer = new MySerializer();
$cache = new SimpleCache($root . '/.cache', $serializer);

```

<?php

namespace Morphable\SimpleCache;

use \Morphable\SimpleCache\Exception\UnableToSerialize;
use \Morphable\SimpleCache\Exception\UnableToUnserialize;

class SerializeJson implements SerializeInterface
{
    /**
     * Serialize cache content
     * @throws object Morphable\SimpleCache\Exception\UnableToSerialize
     * @param array item to be serialized
     * @return string serialized item
     */
    public function serialize(array $content): string
    {
        return json_encode($content);
    }

    /**
     * Unserialize cache content
     * @throws object Morphable\SimpleCache\Exception\UnableToUnserialize
     * @param string item to be unserialized
     * @return array unserialized item
     */
    public function unserialize(string $content): array
    {
        $unserialize = json_decode($content, true);

        if ($unserialize === null) {
            throw new UnableToUnserialize();
        }

        return $unserialize;
    }
}

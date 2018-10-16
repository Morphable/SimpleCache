<?php

namespace Morphable\SimpleCache;

use \Morphable\SimpleCache\Exception\UnableToSerialize;
use \Morphable\SimpleCache\Exception\UnableToUnserialize;
use \Morphable\SimpleCache\SerializeInterface;

class SerializeArray implements SerializeInterface
{
    /**
     * Serialize cache content
     * @throws object Morphable\SimpleCache\Exception\UnableToSerialize
     * @param array item to be serialized
     * @return string serialized item
     */
    public function serialize(array $content): string
    {
        $serialize = \serialize($content);
        if ($serialize === false) {
            throw new UnableToSerialize();
        }

        return $serialize;
    }

    /**
     * Unserialize cache content
     * @throws object Morphable\SimpleCache\Exception\UnableToUnserialize
     * @param string item to be unserialized
     * @return array unserialized item
     */
    public function unserialize(string $content): array
    {
        $unserialize = \unserialize($content);

        if ($unserialize === false) {
            throw new UnableToUnserialize();
        }

        return $unserialize;
    }
}

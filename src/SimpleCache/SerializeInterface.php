<?php

namespace Morphable\SimpleCache;

interface SerializeInterface
{
    /**
     * Serialize cache content
     * @throws object Morphable\SimpleCache\Exception\UnableToSerialize
     * @param array item to be serialized
     * @return string serialized item
     */
    public function serialize(array $content): string;

    /**
     * Unserialize cache content
     * @throws object Morphable\SimpleCache\Exception\UnableToUnserialize
     * @param string item to be unserialized
     * @return array unserialized item
     */
    public function unserialize(string $content): array;
}

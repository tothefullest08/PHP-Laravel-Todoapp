<?php

namespace App\Core\Helpers;

trait JsonSerializableTrait
{
    /** @noinspection PhpComposerExtensionStubsInspection */
    public function toArray()
    {
        $array = get_object_vars($this);
        $data = [];
        array_walk($array, static function ($value, $key) use ($data) {
            if ($value instanceof \JsonSerializable) {
                $value = $value->jsonSerialize();
            }
            $data[$key] = $value;
        });

        return $data;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}

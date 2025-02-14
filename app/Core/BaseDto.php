<?php


namespace App\Core;


abstract class BaseDto
{

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if ($value === null) continue;
            $this->$key = $value;
        }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

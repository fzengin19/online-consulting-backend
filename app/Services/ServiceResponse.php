<?php

namespace App\Services;


class ServiceResponse
{

    public $status;
    public $data;

    public function __construct($data, $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }
}

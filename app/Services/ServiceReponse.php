<?php

namespace App\Services;


class ServiceResponse
{

    public $status;
    public $data;

    public function __construct($data, $status)
    {
        $this->data = $data;
        $this->status = $status;
    }
}

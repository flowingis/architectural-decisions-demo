<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;

class DoStuffData
{
    public $data;

    public static function create(Request $request): DoStuffData
    {
        $dto = new self();
        $dto->data = $request->request->get('data');

        return $dto;
    }
}

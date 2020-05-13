<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;

class DoStuffMoar
{
    public $data;

    public static function create(Request $request): DoStuffMoar
    {
        $dto = new self();
        $dto->data = $request->request->get('data');

        return $dto;
    }
}

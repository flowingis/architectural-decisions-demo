<?php

namespace App\Service;

use App\Entity\Widget;
use App\Repository\WidgetRepository;

class WidgetService
{
    private $repo;

    public function __construct(WidgetRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function widgetize(Widget $widget): void
    {
        $widget->doAFabulousThing();

        $this->repo->save($widget);
    }
}
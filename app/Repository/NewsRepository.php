<?php

namespace App\Repository;
use App\Repository\UseRepository;
use Prettus\Repository\Contracts\RepositoryInterface;

class NewsRepository extends UseRepository{
    function model()
    {
        return "App\\News";
    }
}

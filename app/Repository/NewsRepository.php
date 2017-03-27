<?php

namespace App\Repository;

use App\Repository\Repository;
use App\Repository\UseRepository;

class NewsRepository extends UseRepository{
    function model()
    {
        return "App\News";
    }
}

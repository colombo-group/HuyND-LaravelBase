<?php
/**
 * Created by PhpStorm.
 * User: huynguyen
 * Date: 27/03/2017
 * Time: 09:25
 */
namespace App\Repository;
use App\Repository\Repository;
use App\Repository\UseRepository;
class UserRepository extends UseRepository {
    function model()
    {
        return "App\User";
    }
}

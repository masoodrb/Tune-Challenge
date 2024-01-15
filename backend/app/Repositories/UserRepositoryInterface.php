<?php

namespace App\Repositories;

use App\GraphQL\Types\UserSort;
use App\GraphQL\Types\EventStatsFilter;

interface UserRepositoryInterface
{
    public function getAllUsers(UserSort $sort, EventStatsFilter $filter);
    public function getUserById($id);
}
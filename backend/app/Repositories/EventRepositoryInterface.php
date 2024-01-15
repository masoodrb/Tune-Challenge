<?php 
namespace App\Repositories;

use App\GraphQL\Types\EventStatsFilter;

interface EventRepositoryInterface
{
    public function getEventStats(EventStatsFilter $filter);
}
<?php

namespace App\Http\Controllers;


use App\GraphQL\Types\UserSort;
use Illuminate\Support\Facades\Log;
use App\Exceptions\JsonReadException;
use App\GraphQL\Types\EventStatsFilter;
use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers($rootValue, array $args, $context, $resolveInfo): array
    {
        try {
            $userSort = new UserSort($args['sort']['field'], $args['sort']['direction']);
            $eventStatsFilter = new EventStatsFilter(
                $args['filter']['dateRange'] ?? [],
                $args['filter']['userId'] ?? null,
                $args['filter']['type'] ?? null,
                $args['filter']['revenueRange'] ?? []
            );
            return $this->userRepository->getAllUsers($userSort, $eventStatsFilter)->all();
        } catch (JsonReadException $e) {
            Log::error($e->getMessage());
            return [];
        }
    }

    public function getUser($rootValue, array $args, $context, $resolveInfo)
    {
        return $this->userRepository->getUserById($args['id']);
    }
}
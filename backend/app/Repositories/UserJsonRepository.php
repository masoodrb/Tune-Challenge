<?php

namespace App\Repositories;


use Illuminate\Support\Carbon;
use App\GraphQL\Types\UserSort;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\GraphQL\Types\SortDirection;
use App\Exceptions\JsonReadException;
use App\GraphQL\Types\EventStatsFilter;
use App\Contracts\FileContentReaderInterface;

class UserJsonRepository implements UserRepositoryInterface
{
    private const USERS_JSON_PATH = 'data/users.json';
    private const EVENTS_JSON_PATH = 'data/logs.json';

    private const EVENT_TYPE_IMPRESSION = 'impression';
    private const EVENT_TYPE_CONVERSION = 'conversion';

    private $fileContentReader;

    public function __construct(FileContentReaderInterface $fileContentReader)
    {
        $this->fileContentReader = $fileContentReader;
    }

    public function getAllUsers(UserSort $sort, EventStatsFilter $filter): Collection
    {

            $usersJson = $this->fileContentReader->getFileContent(base_path(self::USERS_JSON_PATH));
            $eventsJson = $this->fileContentReader->getFileContent(base_path(self::EVENTS_JSON_PATH));

            if (!$usersJson) {
                throw new JsonReadException('Failed to read users JSON file');
            }
            
            if (!$eventsJson) {
                throw new JsonReadException('Failed to read events JSON file');
            }
    
            $users = collect(json_decode($usersJson, true));
            $events = collect(json_decode($eventsJson, true));
    
            $events = $this->filterEvents($events, $filter);
            $users = $this->mapUsers($users, $events);
            $users = $this->sortUsers($users, $sort);
    
            return $users;
    }

    private function filterEvents(Collection $events, EventStatsFilter $filter): Collection
    {
        if (!empty($filter->dateRange)) {
            $events = $events->whereBetween('time', [$filter->dateRange->start, $filter->dateRange->end]);
        }

        if ($filter->type) {
            $events = $events->where('type', $filter->type);
        }

        if (!empty($filter->revenueRange)) {
            $events = $events->whereBetween('revenue', [$filter->revenueRange->min, $filter->revenueRange->max]);
        }

        return $events;
    }

    private function mapUsers(Collection $users, Collection $events): Collection
    {
        return $users->map(function ($user) use ($events) {
            $userEvents = $events->where('user_id', $user['id']);

            $user['stats'] = [
                'totalImpressions' => $userEvents->where('type', self::EVENT_TYPE_IMPRESSION)->count(),
                'totalConversions' => $userEvents->where('type', self::EVENT_TYPE_CONVERSION)->count(),
                'totalRevenue' => $userEvents->sum('revenue'),
            ];

            $user['conversionsPerDay'] = $userEvents->where('type', self::EVENT_TYPE_CONVERSION)
            ->groupBy(function ($log) {
                return Carbon::parse($log['time'])->format('Y-m-d');
            })
            ->map(function ($dailyLogs, $date) {
                return [
                    'date' => $date,
                    'conversions' => $dailyLogs->count(),
                ];
            })
            ->values()
            ->all();

            return $user;
        });
    }

    private function sortUsers(Collection $users, UserSort $sort): Collection
    {
        if ($sort->getDirection() === SortDirection::DESC) {
            return $users->sortByDesc($sort->getField());
        } else {
            return $users->sortBy($sort->getField());
        }
    }

    public function getUserById($id)
    {
        $userSort = new UserSort('id', SortDirection::ASC);
        $eventStatsFilter = new EventStatsFilter();

        $users = $this->getAllUsers($userSort, $eventStatsFilter);

        return $users->firstWhere('id', $id);
    }
}
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\GraphQL\Types\EventStatsFilter;
use Illuminate\Console\Scheduling\Event;
use App\Contracts\FileContentReaderInterface;
use App\Repositories\EventRepositoryInterface;

class EventController extends Controller
{
    private $eventsRepository;

    public function __construct(EventRepositoryInterface $eventsRepository)
    {
        $this->eventsRepository = $eventsRepository;
    }

    public function getEventStats($rootValue, array $args, $context, $resolveInfo): array
    {
        $eventStatsFilter = new EventStatsFilter(
            $args['filter']['dateRange'] ?? [],
            $args['filter']['userId'] ?? null,
            $args['filter']['type'] ?? null,
            $args['filter']['revenueRange'] ?? []
        );
        return $this->eventsRepository->getEventStats($eventStatsFilter);
    }
  
}

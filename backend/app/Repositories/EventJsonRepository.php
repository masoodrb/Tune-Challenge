<?php

namespace App\Repositories;

use App\GraphQL\Types\EventStatsFilter;
use App\Contracts\FileContentReaderInterface;

class EventJsonRepository implements EventRepositoryInterface
{
  private const EVENTS_JSON_PATH = 'data/logs.json';
  private $fileContentReader;

  public function __construct(FileContentReaderInterface $fileContentReader)
  {
    $this->fileContentReader = $fileContentReader;
  }

  public function getEventStats(EventStatsFilter $filter)
  {
    $eventsJson = $this->fileContentReader->getFileContent(base_path(self::EVENTS_JSON_PATH));
    $events = collect(json_decode($eventsJson, true));

    if ($filter->dateRange) {
      $events = $events->whereBetween('time', [$filter->dateRange->start, $filter->dateRange->end]);
    }

    if ($filter->userId) {
      $events = $events->where('user_id', $filter->userId);
    }

    if ($filter->type) {
      $events = $events->where('type', $filter->type);
    }

    if ($filter->revenueRange) {
      $events = $events->whereBetween('revenue', [$filter->revenueRange->min, $filter->revenueRange->max]);
    }

    $totalImpressions = $events->where('type', 'impression')->count();
    $totalConversions = $events->where('type', 'conversion')->count();
    $totalRevenue = $events->sum('revenue');

    return [
      'totalImpressions' => $totalImpressions,
      'totalConversions' => $totalConversions,
      'totalRevenue' => $totalRevenue,
    ];
  }
}

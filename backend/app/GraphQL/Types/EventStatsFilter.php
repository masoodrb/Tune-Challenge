<?php
namespace App\GraphQL\Types;

use Illuminate\Support\Arr;

class EventStatsFilter
{
    public ?DateRange $dateRange;
    public ?int $userId;
    public ?string $type;
    public ?RevenueRange $revenueRange;

    public function __construct(
        array $dateRange = [],
        ?int $userId = null,
        ?string $type = null,
        array $revenueRange = []
    ) {
        $this->dateRange = Arr::has($dateRange, ['start', 'end']) ? new DateRange($dateRange['start'], $dateRange['end']) : null;
        $this->userId = $userId;
        $this->type = $type;
        $this->revenueRange = Arr::has($revenueRange, ['min', 'max']) ? new RevenueRange($revenueRange['min'], $revenueRange['max']) : null;
    }
}
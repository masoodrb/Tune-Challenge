<?php
namespace App\GraphQL\Types;

class DateRange
{
    public string $start;
    public string $end;

    public function __construct(string $start, string $end)
    {
        $this->start = $start;
        $this->end = $end;
    }
}
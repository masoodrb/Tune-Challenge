<?php 
namespace App\GraphQL\Types;

class RevenueRange
{
    public float $min;
    public float $max;

    public function __construct(float $min, float $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
}
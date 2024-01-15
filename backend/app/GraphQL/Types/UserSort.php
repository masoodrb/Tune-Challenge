<?php
namespace App\GraphQL\Types;

class UserSort
{
    private string $field;
    private string $direction;

    public function __construct(string $field = "name", string $direction = "ASC")
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): void
    {
        $this->field = $field;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): void
    {
        $this->direction = $direction;
    }
}
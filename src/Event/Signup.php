<?php

namespace AlexWestergaard\PhpGa4\Event;

use AlexWestergaard\PhpGa4\Facade;
use AlexWestergaard\PhpGa4\Model;

class Signup extends Model\Event implements Facade\SignUp
{
    protected $method;

    public function getName(): string
    {
        return 'sign_up';
    }

    public function getParams(): array
    {
        return [
            'method',
        ];
    }

    public function getRequiredParams(): array
    {
        return [];
    }

    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }
}

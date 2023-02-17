<?php

namespace App\Contract;

use App\Core\Container;
use Symfony\Component\Console\Command\Command;

class BaseCommand extends Command
{
    protected string $line = '----------------------------------------------------------';

    protected string $separator = '      |      ';

    protected function getEntity(): BaseEntity
    {
        $container = Container::getInstance();

        return $container->get($this->entity);
    }
}
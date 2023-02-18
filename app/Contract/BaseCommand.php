<?php

namespace App\Contract;

use Symfony\Component\Console\Command\Command;

class BaseCommand extends Command
{
    protected string $line = '----------------------------------------------------------';

    protected string $separator = '      |      ';

    protected function failed($output, $message, $type = 'error')
    {
        $output->writeln("<$type>$message</$type>");
        $output->writeln(' ');

        return Command::FAILURE;
    }
}
<?php

namespace App\Contract;

use Symfony\Component\Console\Command\Command;

class BaseCommand extends Command
{

    protected string $separator = '      |      ';

    protected function failed($output, $message, $type = 'error')
    {
        $output->writeln("<$type>$message</$type>");
        $output->writeln(' ');

        return Command::FAILURE;
    }

    protected function writeRow($output, array $data)
    {
        $last = count($data);
        foreach ($data as $i => $item) {
            if ($last == ++$i) {
                $output->writeln($item);
                continue;
            }
            $output->write($item);
            $output->write($this->separator);
        }
        $output->writeln($this->line);
    }
}
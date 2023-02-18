<?php

namespace App\Commands\Unit;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Entities\Unit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'unit:list')]
class UnitList extends BaseCommand
{
    protected string $line = '-------------------------------------------------------------------------------';

    protected string $entity = Unit::class;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = $this->getEntity();
        $units = $entity->all();

        $output->writeln(' ');
        if (count($units) == 0) {
            $output->writeln('<comment>No unit found.</comment>');
            $output->writeln(' ');

            return Command::SUCCESS;
        }

        $output->writeln('Units:');
        $output->writeln($this->line);
        $output->writeln('<question>Id'.$this->separator.'Name'
                         .$this->separator.'Products'.$this->separator.'Price'
                         .$this->separator.'Discount'.'</question>');
        $output->writeln($this->line);

        foreach ($units as $id => $unit) {
            $output->writeln(++$id.$this->separator.$unit['name'].$this->separator
                             .json_encode($unit['products']).$this->separator
                             .number_format($entity->getPrice($id)).$this->separator.$entity->getDiscount($id).'%');
            $output->writeln($this->line);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
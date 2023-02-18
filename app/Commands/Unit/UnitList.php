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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $units = Unit::query()->all();

        $output->writeln(' ');
        if (count($units) == 0) {
            return $this->failed($output, 'No unit found.');
        }

        $output->writeln('Units:');
        $output->writeln($this->line);
        $output->writeln('<question>Id'.$this->separator.'Name'
                         .$this->separator.'Products'.$this->separator.'Price'
                         .$this->separator.'Discount'.'</question>');
        $output->writeln($this->line);

        foreach ($units as $unit) {
            $id = $unit['id'];
            $price = Unit::query()->getPrice($id);
            $discount = Unit::query()->getDiscount($id);
            $output->writeln(++$id.$this->separator.$unit['name'].$this->separator
                             .json_encode($unit['products']).$this->separator
                             .number_format($price).$this->separator.$discount.'%');
            $output->writeln($this->line);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
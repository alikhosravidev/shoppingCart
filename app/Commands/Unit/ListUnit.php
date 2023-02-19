<?php

namespace App\Commands\Unit;

use App\Contract\BaseCommand;
use App\Entities\Unit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'unit:list')]
class ListUnit extends BaseCommand
{
    protected string $line = '-------------------------------------------------------------------------------------------------------';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $units = Unit::query()->all();

        $output->writeln(' ');
        if (count($units) == 0) {
            return $this->failed($output, 'No unit found.');
        }

        $output->writeln($this->line);
        $this->writeRow($output, [
            '<question>ID', 'Name', 'Products', 'Price', 'Discount', 'Final price</question>',
        ]);

        foreach ($units as $unit) {
            $this->writeRow($output, [
                $unit->id, $unit->name, json_encode($unit->products), number_format($unit->getPrice()),
                $unit->getDiscount().'%', number_format($unit->getFinalPrice())
            ]);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
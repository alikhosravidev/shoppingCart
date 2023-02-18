<?php

namespace App\Commands\Unit;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Entities\Unit;
use App\Utilities\PriceCalculator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'unit:list')]
class UnitList extends BaseCommand
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
            '<question>Id', 'Name', 'Products', 'Price', 'Discount', 'Final price</question>',
        ]);

        foreach ($units as $unit) {
            $id = $unit['id'];
            $price = Unit::query()->getPriceWithoutDiscount($id);
            $discount = $unit['discount'] ?? 0;
            $this->writeRow($output, [
                $id, $unit['name'], json_encode($unit['products']), number_format($price),
                $discount.'%', number_format(PriceCalculator::getFinalPrice($price, $discount))
            ]);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
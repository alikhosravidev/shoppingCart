<?php

namespace App\Commands\Product;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Utilities\PriceCalculator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:list')]
class ProductList extends BaseCommand
{
    protected string $line = '----------------------------------------------------------------------------------';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = Product::query()->all();
        $output->writeln(' ');
        if (count($products) == 0) {
            return $this->failed($output, 'No product found.');
        }

        $output->writeln($this->line);
        $this->writeRow($output, ['<question>Id', 'Name', 'Price', 'Discount', 'Final price</question>']);

        foreach ($products as $product) {
            $this->writeRow($output, [
                                  $product['id'], $product['name'], number_format($product['price']), $product['discount'].'%',
                                  number_format(PriceCalculator::getFinalPrice($product['price'], $product['discount'])),
                              ]);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
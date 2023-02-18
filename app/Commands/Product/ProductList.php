<?php

namespace App\Commands\Product;

use App\Contract\BaseCommand;
use App\Entities\Product;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:list')]
class ProductList extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = Product::query()->all();
        $output->writeln(' ');
        if (count($products) == 0) {
            return $this->failed($output, 'No product found.');
        }

        $output->writeln('Your Products:');
        $output->writeln($this->line);
        $output->writeln('<question>Id'.$this->separator.'Name'.$this->separator.'Price'.$this->separator.'Discount</question>');
        $output->writeln($this->line);

        foreach ($products as $product) {

            $output->writeln($product['id'].$this->separator.$product['name'].$this->separator.number_format($product['price']).$this->separator.$product['discount'].'%');
            $output->writeln($this->line);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
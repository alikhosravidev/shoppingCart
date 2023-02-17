<?php

namespace App\Commands\Products;

use App\Contract\BaseCommand;
use App\Entities\Product;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:list')]
class ProductList extends BaseCommand
{
    protected $entity = Product::class;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->getEntity()->all();

        $output->writeln(' ');
        if (count($products) == 0) {
            $output->writeln('No product found.');
            $output->writeln(' ');

            return Command::SUCCESS;
        }

        $output->writeln('Your Products:');
        $output->writeln($this->line);
        $output->writeln('Id'.$this->separator.'Name'.$this->separator.'Price'.$this->separator.'Discount');
        $output->writeln($this->line);

        foreach ($products as $product) {
            $output->writeln($product['id'].$this->separator.$product['name'].$this->separator.number_format($product['price']).$this->separator.$product['discount'].'%');
            $output->writeln($this->line);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
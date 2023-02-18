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
    protected string $entity = Product::class;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->getEntity()->all();

        $output->writeln(' ');
        if (count($products) == 0) {
            $output->writeln('<comment>No product found.</comment>');
            $output->writeln(' ');

            return Command::SUCCESS;
        }

        $output->writeln('Your Products:');
        $output->writeln($this->line);
        $output->writeln('<question>Id'.$this->separator.'Name'.$this->separator.'Price'.$this->separator.'Discount</question>');
        $output->writeln($this->line);

        foreach ($products as $id => $product) {

            $output->writeln(++$id.$this->separator.$product['name'].$this->separator.number_format($product['price']).$this->separator.$product['discount'].'%');
            $output->writeln($this->line);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
<?php

namespace App\Commands\Products;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Exceptions\ProductExceptions;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:add')]
class ProductAdd extends BaseCommand
{
    protected $entity = Product::class;

    protected function configure(): void
    {
        $this
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'Product name')
            ->addOption('price', null, InputOption::VALUE_OPTIONAL, 'Product price')
            ->addOption('discount', null, InputOption::VALUE_OPTIONAL, 'Product discount');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $product = $this->getEntity();

        $name = $input->getOption('name');
        if (! $name) {
            ProductExceptions::invalidName();
            return Command::FAILURE;
        }
        $price = $input->getOption('price');
        if (is_null($price) || $price < 0) {
            ProductExceptions::invalidPrice();
            return Command::FAILURE;
        }
        $discount = $input->getOption('discount') ?? 0;
        if (is_null($discount) || $discount < 0) {
            ProductExceptions::invalidDiscount();
            return Command::FAILURE;
        }
        $product->store(compact('name', 'price', 'discount'));

        $output->writeln(' ');
        $output->writeln('Your Product successfully added.');
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
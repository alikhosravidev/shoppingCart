<?php

namespace App\Commands\Product;

use App\Contract\BaseCommand;
use App\Core\Event;
use App\Entities\Product;
use App\Exceptions\ProductExceptions;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:create')]
class CreateProduct extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Product name')
            ->addOption('price', null, InputOption::VALUE_REQUIRED, 'Product price')
            ->addOption('discount', null, InputOption::VALUE_OPTIONAL, 'Product discount');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
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

        $product = Product::query()
            ->create(compact('name', 'price', 'discount'));

        $output->writeln(' ');
        $output->writeln('<info>Product successfully created.</info>');
        $output->writeln(' ');

        Event::dispatch('productCreated', $product);

        return Command::SUCCESS;
    }
}
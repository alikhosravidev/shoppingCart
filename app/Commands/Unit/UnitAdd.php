<?php

namespace App\Commands\Unit;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Entities\Unit;
use App\Entities\User;
use App\Exceptions\ProductExceptions;
use App\Exceptions\UnitExceptions;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'unit:add')]
class UnitAdd extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Unit name')
            ->addOption('products', null, InputOption::VALUE_REQUIRED, 'Products for unit')
            ->addOption('price', null, InputOption::VALUE_OPTIONAL, 'Unit price')
            ->addOption('discount', null, InputOption::VALUE_OPTIONAL, 'Unit discount');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getOption('name');
        if (! $name) {
            ProductExceptions::invalidName();
            return Command::FAILURE;
        }

        $products = $input->getOption('products');
        $products = $products ? explode(',', $products) : null;
        if (! $products || ! is_array($products) || count($products) <= 1) {
            UnitExceptions::invalidProducts();
            return Command::FAILURE;
        }
        foreach ($products as $productId) {
            $product = Product::query()->find($productId);
            if (! $product) {
                UnitExceptions::someProductNotExists($productId);
                return Command::FAILURE;
            }
        }

        $price = $input->getOption('price');
        if ($price < 0) {
            UnitExceptions::invalidPrice();
            return Command::FAILURE;
        }
        $discount = $input->getOption('discount');
        if ($discount < 0) {
            UnitExceptions::invalidPrice();
            return Command::FAILURE;
        }

        Unit::query()->store(compact('name', 'products', 'price', 'discount'));

        $output->writeln(' ');
        $output->writeln('<info>Unit successfully added.</info>');
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
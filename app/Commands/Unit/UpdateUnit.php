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

#[AsCommand(name: 'unit:update')]
class UpdateUnit extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->addArgument('id', null, InputArgument::REQUIRED, 'The id of the unit you want to update')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Unit name')
            ->addOption('products', null, InputOption::VALUE_REQUIRED, 'Products for unit')
            ->addOption('price', null, InputOption::VALUE_OPTIONAL, 'Unit price')
            ->addOption('discount', null, InputOption::VALUE_OPTIONAL, 'Unit discount');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        if (! is_numeric($id)) {
            return $this->failed($output, 'You most inter argument unit id');
        }

        $unit = Unit::query()->find($id);
        if (! $unit) {
            return $this->failed($output, 'Unit ID not found!');
        }

        $name = $input->getOption('name') ?? $unit['name'];
        $products = $input->getOption('products');
        if ($products) {
            $products = explode(',', $products);
        } else {
            $products = $unit['products'];
        }
        $price = $input->getOption('price') ?? $unit['price'];
        $discount = $input->getOption('discount') ?? $unit['discount'];

        Unit::query()->update($id, compact('name', 'products', 'price', 'discount'));

        $output->writeln(' ');
        $output->writeln('<info>Unit successfully updated.</info>');
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
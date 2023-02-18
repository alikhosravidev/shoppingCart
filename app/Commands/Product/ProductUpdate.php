<?php

namespace App\Commands\Product;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Exceptions\ProductExceptions;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:update')]
class ProductUpdate extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->addArgument('id', null, InputArgument::REQUIRED, 'The id of the product you want to remove')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'Product name')
            ->addOption('price', null, InputOption::VALUE_OPTIONAL, 'Product price')
            ->addOption('discount', null, InputOption::VALUE_OPTIONAL, 'Product discount');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        if (! is_numeric($id)) {
            return $this->failed($output, 'You most inter argument product id');
        }

        $product = Product::query()->find($id);
        if (! $product) {
            return $this->failed($output, 'Product ID not found!');
        }

        $name = $input->getOption('name') ?? $product['name'];
        $price = $input->getOption('price') ?? $product['price'];
        $discount = $input->getOption('discount') ?? $product['discount'];

        Product::query()->update($id, compact('name', 'price', 'discount'));

        $output->writeln(' ');
        $output->writeln('<info>Your Product successfully added.</info>');
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
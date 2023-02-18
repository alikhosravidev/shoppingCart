<?php

namespace App\Commands\Product;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Entities\Unit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:delete')]
class ProductDelete extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->addArgument('id', null, InputArgument::REQUIRED, 'The id of the product you want to remove');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(' ');
        $id = $input->getArgument('id');
        if (! is_numeric($id)) {
            return $this->failed($output, 'You most inter argument product id');
        }

        $product = Product::query()->find($id);
        if (! $product) {
            return $this->failed($output, 'Product ID not found!');
        }

        if (in_array($id, Unit::query()->getAllUnitProductIds())) {
            return $this->failed($output, 'You cannot remove this product because it is in a unit.');
        }

        $isDeleted = Product::query()->delete($id);
        if (! $isDeleted) {
            return $this->failed($output, 'Process Failed!');
        }

        $output->writeln('<info>product deleted.</info>');
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
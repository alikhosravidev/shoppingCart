<?php

namespace App\Commands\Products;

use App\Contract\BaseCommand;
use App\Entities\Product;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:delete')]
class ProductDelete extends BaseCommand
{
    protected $entity = Product::class;

    protected function configure(): void
    {
        $this
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'The id of the product you want to remove');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $product = $this->getEntity();
        $output->writeln(' ');

        $id = $input->getOption('id');
        if (! is_numeric($id)) {
            $output->writeln('You most inter product id with option --id');
            $output->writeln(' ');

            return Command::FAILURE;
        }
        $product->delete($id);
        $output->writeln('Your product deleted.');

        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
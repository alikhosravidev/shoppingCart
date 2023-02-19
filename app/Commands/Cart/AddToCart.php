<?php

namespace App\Commands\Cart;

use App\Cart\Cart;
use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Entities\Unit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'cart:add')]
class AddToCart extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->addArgument('type', null, InputArgument::REQUIRED, 'The type of the entity you want to add to cart')
            ->addArgument('id', null, InputArgument::REQUIRED, 'The id of the entity type you want to add to cart')
            ->addOption('quantity', null, InputOption::VALUE_OPTIONAL, 'The quantity of the entity you want to add to cart (default: 1)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cart = new Cart();
        $output->writeln(' ');
        $id = $input->getArgument('id');
        if (! is_numeric($id)) {
            return $this->failed($output, 'You most inter argument item ID');
        }

        $type = $input->getArgument('type');
        if (is_null($type)) {
            return $this->failed($output, 'You most inter argument item type');
        }

        if (! in_array($type, array_keys($cart->entityMap))) {
            return $this->failed($output, 'Your type is invalid (valid types: product, unit)');
        }

        $entityType = $cart->entityMap[$type];
        $entity = $entityType::query()->find($id);
        if (! $entity->exists()) {
            return $this->failed($output, "$type ID not found!");
        }
        $quantity = $input->getOption('quantity') ?? 1;

        $cart->add($id, $entityType, $entity->name, $quantity, $entity->getFinalPrice());

        $output->writeln("<info>$type successfully add to cart.</info>");
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
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
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'cart:delete')]
class DeleteFromCart extends BaseCommand
{
    protected array $entityMap = [
        'product' => Product::class,
        'unit' => Unit::class,
    ];

    protected function configure(): void
    {
        $this
            ->addArgument('type', null, InputArgument::REQUIRED, 'The type of the entity you want to add to cart')
            ->addArgument('id', null, InputArgument::REQUIRED, 'The id of the entity type you want to add to cart');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(' ');
        $id = $input->getArgument('id');
        if (! is_numeric($id)) {
            return $this->failed($output, 'You most inter argument item ID');
        }

        $type = $input->getArgument('type');
        if (is_null($type)) {
            return $this->failed($output, 'You most inter argument item type');
        }

        if (! in_array($type, array_keys($this->entityMap))) {
            return $this->failed($output, 'Your type is invalid (valid types: product, unit)');
        }

        $entityType = $this->entityMap[$type];
        $cart = new Cart;
        $cartId = $cart->generateRawId($id, $entityType);
        if (! $cart->exists($cartId)) {
            return $this->failed($output, 'Your item dose not exists.');
        }

        $deleted = $cart->remove($cartId);
        if (! $deleted) {
            return $this->failed($output, 'Process Failed!');
        }

        $output->writeln("<info>$type successfully add to cart.</info>");
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
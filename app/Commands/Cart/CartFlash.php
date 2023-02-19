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

#[AsCommand(name: 'cart:flash')]
class CartFlash extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(' ');
        $cart = new Cart;
        $cart->flash();
        $output->writeln("<info>Cart flashed.</info>");
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
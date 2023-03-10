<?php

namespace App\Commands\Cart;

use App\Contract\BaseCommand;
use App\Facades\Cart;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'cart:flash')]
class CartFlash extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(' ');
        Cart::flash();
        $output->writeln("<info>Cart flashed.</info>");
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
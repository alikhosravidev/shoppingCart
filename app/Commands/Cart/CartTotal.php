<?php

namespace App\Commands\Cart;

use App\Contract\BaseCommand;
use App\Facades\Cart;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'cart:total')]
class CartTotal extends BaseCommand
{
    protected string $line = '-------------------';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(' ');
        $output->writeln('<question>Total price</question>');
        $output->writeln($this->line);
        $output->writeln(Cart::total());
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
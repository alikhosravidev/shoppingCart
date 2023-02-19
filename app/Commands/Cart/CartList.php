<?php

namespace App\Commands\Cart;

use App\Cart\Cart;
use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Entities\Unit;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'cart:list')]
class CartList extends BaseCommand
{
    protected string $line = '----------------------------------------------------------------------------------';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cart = new Cart;
        $items = $cart->getItems();

        $output->writeln(' ');
        if (count($items) == 0) {
            return $this->failed($output, 'No item found.');
        }

        $output->writeln($this->line);
        $this->writeRow($output, [
            '<question>ID', 'Type', 'Name', 'Price', 'Quantity</question>',
        ]);

        foreach ($items as $item) {
            $type = array_search($item['entity_type'], $cart->entityMap);
            $this->writeRow($output, [
                $item['entity_id'], $type, $item['name'], number_format($item['price']), $item['quantity'],
            ]);
        }
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
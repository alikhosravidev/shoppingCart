<?php

namespace App\Commands\Unit;

use App\Contract\BaseCommand;
use App\Entities\Product;
use App\Entities\Unit;
use App\Entities\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'unit:delete')]
class UnitDelete extends BaseCommand
{
    protected string $entity = Unit::class;

    protected function configure(): void
    {
        $this
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'The id of the unit you want to remove');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $unit = $this->getEntity();
        $output->writeln(' ');

        $id = $input->getOption('id');
        if (! is_numeric($id)) {
            $output->writeln('<error>You most inter unit id with option --id</error>');
            $output->writeln(' ');

            return Command::FAILURE;
        }

        $isDeleted = $unit->delete($id);
        if ($isDeleted) {
            $output->writeln('<info>unit deleted.</info>');
        }else {
            $output->writeln('<comment>unit ID not found!</comment>');
        }

        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
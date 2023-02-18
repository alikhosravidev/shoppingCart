<?php

namespace App\Commands\Unit;

use App\Contract\BaseCommand;
use App\Entities\Unit;
use App\Entities\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'unit:delete')]
class UnitDelete extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->addArgument('id', null, InputArgument::REQUIRED, 'The id of the unit you want to remove');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(' ');

        $id = $input->getArgument('id');
        if (! is_numeric($id)) {
            return $this->failed($output, 'You most inter argument unit id');
        }

        $product = Unit::query()->find($id);
        if (! $product) {
            return $this->failed($output, 'Unit ID not found!');
        }

        $isDeleted = Unit::query()->delete($id);
        if (! $isDeleted) {
            return $this->failed($output, 'Process Failed!');
        }

        $output->writeln('<info>unit deleted.</info>');
        $output->writeln(' ');

        return Command::SUCCESS;
    }
}
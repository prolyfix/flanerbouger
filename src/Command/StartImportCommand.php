<?php

namespace App\Command;

use App\Manager\ImportManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:start-import',
    description: 'Start Import Processes',
)]
class StartImportCommand extends Command
{
    public function __construct(private ImportManager $importManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->importManager->triggerImports();
        $io->success('Import process started successfully.');
        return Command::SUCCESS;
    }
}

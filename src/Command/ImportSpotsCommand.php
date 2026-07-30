<?php

namespace App\Command;

use App\Service\SpotImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:spots:import', description: 'Import spots from Excel file')]
class ImportSpotsCommand extends Command
{
    public function __construct(private SpotImporter $importer)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::OPTIONAL, 'Excel file path', 'data Wind.xlsx');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        if (!file_exists($file)) {
            $output->writeln("<error>File not found: $file</error>");
            return Command::FAILURE;
        }

        $count = $this->importer->import($file);
        $output->writeln("<info>Imported $count spots</info>");
        return Command::SUCCESS;
    }
}

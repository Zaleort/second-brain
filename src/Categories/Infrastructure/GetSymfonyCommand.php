<?php

namespace App\Categories\Infrastructure;

use App\Categories\Application\CreateCategory\CreateCategoryCommand;
use App\Categories\Application\CreateCategory\CreateCategoryHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetSymfonyCommand extends Command
{
    public function __construct(private readonly CreateCategoryHandler $handler)
    {
        parent::__construct('app:category:new');
        $this->addArgument('name', InputArgument::REQUIRED, 'Nombre de la categoría');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $command = new CreateCategoryCommand($name);
        $this->handler->execute($command);
        $output->writeln('Increíble');
        return 0;
    }
}
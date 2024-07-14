<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Author; 
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'CleanupAuthorsCommand',
    description: 'Clean up some lazy authors',
)]
class CleanupAuthorsCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $lazyAuthors = $this->entityManager
                    ->getRepository(Author::class)
                    ->findAll();

        foreach ($lazyAuthors as $author) {
          if(empty($author->getBooks())){
                $this->entityManager->remove($author);
            }
        }

        $this->entityManager->flush();

        $output->writeln('Lazy authors deleted');
        
        return Command::SUCCESS;
    }
    

    
    
}

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

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        
        $repository = $this->em->getRepository(Author::class);
        $lazyAuthors = $repository->findAll();
        
        foreach ($lazyAuthors as $author) {
            if(empty($author->getBooks()))
            $this->em->remove($author);
        }

        $this->em->flush();

        $output->writeln('Deleted ' . count($lazyAuthors) . ' lazy authors.');
        
        return Command::SUCCESS;
    }
    

    
    
}

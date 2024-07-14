<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;

#[AsCommand(
    name: 'TestDataGen',
    description: 'Add some test data into db',
)]
class TestDataGenCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*
            DEPRICATED
        */
        /*
        for ($i = 0; $i < 10; $i++) {

            $book = new Book();
            $book->setTitle('book '.$i);
            $book->setReleaseDate(rand(1,10).".".rand(1,10).".".rand(1984,2024));

            for ($j = 0; $j < 2; $j++){
                $author = new Author();
                $author->setName('name '.$j);
                $author->setSurname('surname '.$j);
            }

            $book->addAuthor($author);
            $this->entityManager->persist($book);
            $this->entityManager->persist($author);
            $this->entityManager->flush();
        }
        */

        

        return Command::SUCCESS;
    }
}

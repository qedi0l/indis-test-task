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

    private function RandStr($length = 5) : string {
        $rand_str = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        return $rand_str;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //factories and faker... I know...

        //Book without author
        $book1 = new Book();
        $book1->setTitle($this->RandStr());
        $book1->setReleaseDate(rand(1,10).".".rand(1,10).".".rand(1984,2024));

        //Author with book
        $author1 = new Author();
        $author1->setName($this->RandStr());
        $author1->setSurname($this->RandStr());
        $author1->addAuthorBook($book1);

        //Book with author
        $book2 = new Book();
        $book2->setTitle($this->RandStr());
        $book2->setReleaseDate(rand(1,10).".".rand(1,10).".".rand(1984,2024));
        $book2->addBookAuthor($author1);

        //Author with two books
        $author2 = new Author();
        $author2->setName($this->RandStr());
        $author2->setSurname($this->RandStr());
        $author2->addAuthorBook($book1);
        $author2->addAuthorBook($book2);

        $publisher = new Publisher();
        $publisher->setName($this->RandStr());
        $publisher->setAddress("Street ".$this->RandStr()." ".rand(1,20));
        
        //Book with author and publisher
        $book3 = new Book();
        $book3->setTitle($this->RandStr());
        $book3->setReleaseDate(rand(1,10).".".rand(1,10).".".rand(1984,2024));
        $book2->addBookAuthor($author2);
        $book2->setPublisher($publisher);
        
        
        $this->entityManager->persist($book1);
        $this->entityManager->persist($author1);
        $this->entityManager->persist($book2);
        $this->entityManager->persist($author2);
        $this->entityManager->persist($publisher);
        $this->entityManager->persist($book3);
        
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}

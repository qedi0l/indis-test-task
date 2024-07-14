<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 6; $i++) {

            $book = new Book();
            $book->setTitle('book '.$i);
            $book->setReleaseDate(rand(1,10).".".rand(1,10).".".rand(1984,2024));

            for ($j = 0; $j < 2; $j++){
                $author = new Author();
                $author->setName('name '.$j);
                $author->setSurname('surname '.$j);
                if ($i%2==0){
                    $book->addAuthor($author);
                }
                $manager->persist($author);
            }

            $publisher = new Publisher();
            $publisher->setName('publisher '.$i);
            $publisher->setAddress('Street '.$i);
            if ($i%2!=0){
                $publisher->addBook($book);
            }
            $manager->persist($publisher);
            $manager->persist($book);
            
        }

        $manager->flush();
    }
}

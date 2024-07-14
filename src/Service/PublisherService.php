<?php
namespace App\Service;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;

class PublisherService
{
    public function createPublisher($entityManager,$request)
    {
        $publisherData = $request->toArray();

        $name = $publisherData['name'];
        $address = $publisherData['address'];
        $books_ids = $publisherData['booksIDs'];

        $publisher = new Publisher();
        $publisher->setName($name);
        $publisher->setAddress($address);

        if(isset($books_ids) && !empty($books_ids)){

            $books = $entityManager
                    ->getRepository(Book::class)
                    ->findBy(['id' => $books_ids]);

            foreach ($books as $book){
                $book->setPublisher($publisher);
                $publisher->addPublisherBook($book);
            }
        }

        $entityManager->persist($book);
        $entityManager->persist($publisher);
        $entityManager->flush();

        return [
            'status' => 201,
        ];
    }

    public function updatePublisher($entityManager,$request)
    {
        $publisherData = $request->toArray();

        $publisherID = $publisherData['publisherID'];
        $name = $publisherData['name'];
        $address = $publisherData['address'];
        $booksIDs = $publisherData['booksIDs'];


        $publisher = $entityManager
                    ->getRepository(Publisher::class)
                    ->findOneById($publisherID);

        if (isset($name) && !empty($name)){
            $publisher->setName($name);
        }

        if (isset($address) && !empty($address)){
            $publisher->setAddress($address);
        }

        if(isset($booksIDs) && !empty($booksIDs)){
            $books = $entityManager
                    ->getRepository(Book::class)
                    ->findBy(['id' => $booksIDs]);

            foreach ($books as $book){
                //$publisher->addPublisherBook($book);
                $book->setPublisher($publisher);
            }
        }

        $entityManager->flush();

        return [
            'status' => 200,
        ];
    }

    public function deletePublisher($entityManager,$request) 
    {
        $publisherData = $request->toArray();
        $id = $publisherData['publisherID'];

        $publisher = $entityManager
                ->getRepository(Publisher::class)
                ->findOneById($id);

        
        $entityManager->remove($publisher);
        $entityManager->flush();
        
        return [
            'status' => 200,
        ];
    }
}
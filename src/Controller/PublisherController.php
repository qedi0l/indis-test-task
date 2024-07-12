<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PublisherController extends AbstractController
{
    public function create(EntityManagerInterface $entityManager, string $publisher_json): JsonResponse
    {
        $publisher_json = json_decode($publisher_json);
        $name = $publisher_json->name;
        $address = $publisher_json->address;
        $books_ids = json_decode($publisher_json->books_ids);

        $publisher = new Publisher();
        $publisher->setName($name);
        $publisher->setAddress($address);

        if(isset($books_ids) && !empty($books_ids)){
            foreach ($books_ids as $book_id){

                $bookRepository = $entityManager->getRepository(Book::class);
                $book = $bookRepository->findOneById($book_id);
                $book->setPublisher($publisher);
                $publisher->addPublisherBook($book);
            }
        }
        $entityManager->persist($publisher);
    
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->json([
            'status' => 201,
        ]);
    }
    

    public function update(EntityManagerInterface $entityManager, string $publisher_json): JsonResponse
    {
        $publisher_json = json_decode($publisher_json);
        $name = $publisher_json->name;
        $address = $publisher_json->address;
        $publisher_id = $publisher_json->id;
        $books_ids = json_decode($publisher_json->books_ids);

        $publisherRepository = $entityManager->getRepository(Publisher::class);
        $publisher = $publisherRepository->findOneById($publisher_id);
        
        if(!empty($name)) $publisher->setName($name);
        if(!empty($address)) $publisher->setAddress($address);
        if(isset($books_ids) || !empty($books_ids)){
            foreach ($books_ids as $book_id){
                $bookRepository = $entityManager->getRepository(Book::class);
                $book = $bookRepository->findOneById($book_id);
                $publisher->addPublisherBook($book);
            }
        }

        $entityManager->flush();

        return $this->json([
            'status' => 200,
        ]);
    }


    public function delete(EntityManagerInterface $entityManager,int $id): JsonResponse
    {
        $publisher = $entityManager->getRepository(Publisher::class)->find($id);
        
        $entityManager->remove($publisher);
        $entityManager->flush();
        
        return $this->json([
            'status' => 200,
        ]);
    }
}

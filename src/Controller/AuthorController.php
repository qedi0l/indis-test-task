<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author/create',name:"book_create", methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, string $author_json): JsonResponse
    {
        $author_json = json_decode($author_json);
        $name = $author_json->name;
        $surname = $author_json->surname;
        $books_ids = json_decode($author_json->books_ids);

        $author = new Author();
        $author->setName($name);
        $author->setSurname($surname);

        if(isset($books_ids) || !empty($books_ids)){
            foreach ($books_ids as $book_id){
                $bookRepository = $entityManager->getRepository(Book::class);
                $book = $bookRepository->findOneById($book_id);
                $author->addBook($book);
            }
        }

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->json([
            'status' => 201,
        ]);
    }
    
    #[Route('/author/delete',name:"book_delete", methods: ['POST'])]
    public function delete(EntityManagerInterface $entityManager,int $id): JsonResponse
    {
        $author = $entityManager->getRepository(Author::class)->find($id);
        
        $entityManager->remove($author);
        $entityManager->flush();
        
        return $this->json([
            'status' => 200,
        ]);
    }
}

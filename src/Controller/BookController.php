<?php
namespace App\Controller;

// ...
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;
use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    #[Route('/book/create',name:"book_create", methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager,Request $request, BookService $bookService):JsonResponse
    {
        $response = $bookService->createBook($entityManager,$request);
        return $this->json($response);
    }

    #[Route('/book/all',name:"book_all", methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager, BookService $bookService): JsonResponse
    {
        $response = $bookService->allBooks($entityManager);
        dd($response);
        return $this->json($response);
    }

    #[Route('/book/delete',name:"book_delete", methods: ['POST'])]
    public function delete(EntityManagerInterface $entityManager,Request $request,BookService $bookService): JsonResponse
    {
        $response = $bookService->deleteBook($entityManager,$request);
        return $this->json($response);
    }
}
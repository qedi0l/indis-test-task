<?php
namespace App\Controller;

// ...
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    public function create(EntityManagerInterface $entityManager, string $book_json): JsonResponse
    {
        $book_json = json_decode($book_json);
        
        $title = $book_json->title;
        $release_date = $book_json->releaseDate;
        $book_publisher_id = json_decode($book_json->bookPublisher);
        $book_author_id = json_decode($book_json->bookAuthor);

        $book = new Book();
        $book->setTitle($title);
        $book->setReleaseDate($release_date);

        if(isset($book_publisher_id) && !empty($book_publisher_id)){
            $publisherRepository = $entityManager->getRepository(Publisher::class);
            $publisher = $publisherRepository->findOneById($book_publisher_id[0]);
            $book->setPublisher($publisher);
        }

        if(isset($book_author_id) && !empty($book_author_id)){
            $authorRepository = $entityManager->getRepository(Author::class);
            $author = $authorRepository->findOneById($book_author_id[0]);
            $book->addBookAuthor($author);
        }
    
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->json([
            'status' => 201,
        ]);
    }
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $bookRepository = $entityManager->getRepository(Book::class);
        $books = $bookRepository->findAll();

        $book_titles = [];
        $book_release_dates =[];
        $authors = [];
        $publishers = [];

        foreach ($books as $book){

            $book_title = $book->getTitle();
            array_push($book_titles,$book_title);

            $book_release_date = $book->getReleaseDate();
            array_push($book_release_dates,$book_release_date);

            $book_publisher = $book->getPublisher();
            $publisherRepository = $entityManager->getRepository(Publisher::class);
            if(isset($book_publisher)){
                $publisher = $publisherRepository->findOneById($book_publisher->getId());
                array_push($publishers,$publisher->getName());
            }
            else{
                array_push($publishers,"");
            }
            
            $book_author = $book->getAuthor();
            if(isset($book_author)){ 
                try{
                    $author = $book_author->toArray()[0]->getSurname();
                    array_push($authors,$author);
                }
                catch(Exception $ex){array_push($authors,"");}
            }

        } 


        return $this->json([
            'book_titles' => json_encode($book_titles),
            'book_release_dates' => json_encode($book_release_dates),
            'authors' => json_encode($authors),
            'publishers'=> json_encode($publishers),
        ]);
    }

    public function delete(EntityManagerInterface $entityManager,int $id): JsonResponse
    {
        $book = $entityManager->getRepository(Book::class)->find($id);

        $entityManager->remove($book);
        $entityManager->flush();
        
        return $this->json([
            'status' => 200,
        ]);
    }
}
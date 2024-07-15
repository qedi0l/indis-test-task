<?php
namespace App\Service;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;

class BookService
{
    public function createBook($entityManager,$request)
    {
        $bookData = $request->toArray();
        
        $title = $bookData['title'];
        $releaseDate = $bookData['releaseDate'];
        $bookPublisherID = $bookData['bookPublisherID'];
        $bookAuthorIDs = $bookData['bookAuthorIDs'];

        $book = new Book();
        $book->setTitle($title);
        $book->setReleaseDate($releaseDate);

        if(!empty($bookPublisherID)){
            $publisher = $entityManager
                    ->getRepository(Publisher::class)
                    ->findOneById($bookPublisherID);
            $book->setPublisher($publisher);
        }

        if(!empty($bookAuthorIDs)){
            $authors = $entityManager
                ->getRepository(Author::class)
                ->findBy(['id' => $bookAuthorIDs]);

            foreach ($authors as $author){
                $book->addAuthor($author);
            }
        }

        $entityManager->persist($book);
        $entityManager->flush();

        return [
            'status' => 201,
        ];
    }

    public function allBooks ($entityManager){

        $books = $entityManager
            ->getRepository(Book::class)
            ->findAll();

        foreach ($books as $book){

            $title = $book->getTitle();
            $releaseDate = $book->getReleaseDate();
            $authorsIDs = $book->getAuthors()->toArray();
            $publisher_id = $book->getPublisher();
            $authors = [];
            


            if(isset($authorsIDs) && !empty($authorsIDs)){ 
                $authorsEnt = $entityManager
                        ->getRepository(Author::class)
                        ->findBy(['id' => $authorsIDs]);
                foreach ($authorsEnt as $author){
                    $authors[] = $author->getSurname();
                }
            } 
            if(isset($publisher_id) && !empty($publisher_id)){
                
                $publisher = $entityManager
                        ->getRepository(Publisher::class)
                        ->findOneById($publisher_id);
                $publisher = $publisher->getName();
            }
            else{
                $publisher = "";
            }

            $books_data[] = [
                'title' => $title,
                'releaseDate' => $releaseDate,
                'authors' => $authors,
                'publisher' => $publisher,
            ];

        } 
        return $books_data;
    }

    public function deleteBook($entityManager,$request) {

        $bookData = $request->toArray();
        $id = $bookData['bookID'];

        $book = $entityManager
                ->getRepository(Book::class)
                ->findOneById($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return [
            'status' => 201,
        ];
    }
}




<?php
namespace App\Service;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;

class AuthorService
{
    public function createAuthor($entityManager,$request)
    {
        $authorData = $request->toArray();
        
        $name = $authorData['name'];
        $surname = $authorData['releaseDate'];
        $booksIDs = $authorData['booksIDs'];

        $author = new Author();
        $author->setName($name);
        $author->setSurname($surname);

        if(!empty($booksIDs)){
            $books = $entityManager
                    ->getRepository(Book::class)
                    ->findBy(['id' => $booksIDs]);
    
            foreach ($books as $book){
                $author->addBook($book);
            }
        }

        $entityManager->persist($book);
        $entityManager->flush();

        return [
            'status' => 201,
        ];
    }


    public function deleteAuthor($entityManager,$request) {

        $authorData = $request->toArray();
        $id = $authorData['authorID'];

        $author = $entityManager
                ->getRepository(Book::class)
                ->findOneById($id);

        $entityManager->remove($author);
        $entityManager->flush();

        return [
            'status' => 201,
        ];
    }
}




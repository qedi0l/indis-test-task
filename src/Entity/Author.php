<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Surname = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'book_author', orphanRemoval: true,cascade: ['persist'])]
    private Collection $Books;

    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'Author', orphanRemoval: true,cascade: ['persist'])]
    private Collection $author_books;

    public function __construct()
    {
        $this->Books = new ArrayCollection();
        $this->author_books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(?string $Surname): static
    {
        $this->Surname = $Surname;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->Books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->Books->contains($book)) {
            $this->Books->add($book);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        $this->Books->removeElement($book);

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getAuthorBooks(): Collection
    {
        return $this->author_books;
    }

    public function addAuthorBook(Book $authorBook): static
    {
        if (!$this->author_books->contains($authorBook)) {
            $this->author_books->add($authorBook);
            $authorBook->addAuthor($this);
        }

        return $this;
    }

    public function removeAuthorBook(Book $authorBook): static
    {
        if ($this->author_books->removeElement($authorBook)) {
            $authorBook->removeAuthor($this);
        }

        return $this;
    }
}

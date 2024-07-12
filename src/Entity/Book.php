<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ReleaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'Books')]
    private ?Publisher $books_from_publisher = null;

    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'Books',orphanRemoval: true,cascade: ['persist'])]
    private Collection $book_author;

    #[ORM\ManyToOne(inversedBy: 'publisher_books')]
    private ?Publisher $Publisher = null;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'author_books',orphanRemoval: true,cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]  
    private Collection $Author;

    public function __construct()
    {
        $this->book_author = new ArrayCollection();
        $this->Author = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->ReleaseDate;
    }

    public function setReleaseDate(?string $ReleaseDate): static
    {
        $this->ReleaseDate = $ReleaseDate;

        return $this;
    }

    public function getBooksFromPublisher(): ?Publisher
    {
        return $this->books_from_publisher;
    }

    public function setBooksFromPublisher(?Publisher $books_from_publisher): static
    {
        $this->books_from_publisher = $books_from_publisher;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getBookAuthor(): Collection
    {
        return $this->book_author;
    }

    public function addBookAuthor($bookAuthor): static
    {
        if (isset($bookAuthor) && !$this->book_author->contains($bookAuthor)) {
            $this->book_author->add($bookAuthor);
            $bookAuthor->addBook($this);
        }

        return $this;
    }

    public function removeBookAuthor($bookAuthor): static
    {
        if ($this->book_author->removeElement($bookAuthor)) {
            $bookAuthor->removeBook($this);
        }

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->Publisher;
    }

    public function setPublisher(?Publisher $Publisher): static
    {
        $this->Publisher = $Publisher;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthor(): Collection
    {
        return $this->Author;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->Author->contains($author)) {
            $this->Author->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->Author->removeElement($author);

        return $this;
    }

}

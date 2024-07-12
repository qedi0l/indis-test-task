<?php

namespace App\Entity;

use App\Repository\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublisherRepository::class)]
class Publisher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Address = null;

    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'books_from_publisher',orphanRemoval: true,cascade: ['persist'])]
    private Collection $Books;

    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'Publisher' ,orphanRemoval: true,cascade: ['persist'])]
    private Collection $publisher_books;

    public function __construct()
    {
        $this->Books = new ArrayCollection();
        $this->publisher_books = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */

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
            $book->setBooksFromPublisher($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->Books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getBooksFromPublisher() === $this) {
                $book->setBooksFromPublisher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getPublisherBooks(): Collection
    {
        return $this->publisher_books;
    }

    public function addPublisherBook(Book $publisherBook): static
    {
        if (!$this->publisher_books->contains($publisherBook)) {
            $this->publisher_books->add($publisherBook);
            $publisherBook->setPublisher($this);
        }

        return $this;
    }

    public function removePublisherBook(Book $publisherBook): static
    {
        if ($this->publisher_books->removeElement($publisherBook)) {
            // set the owning side to null (unless already changed)
            if ($publisherBook->getPublisher() === $this) {
                $publisherBook->setPublisher(null);
            }
        }

        return $this;
    }
   
}

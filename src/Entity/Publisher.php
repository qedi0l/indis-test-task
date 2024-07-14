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
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'publisher' ,orphanRemoval: true,cascade: ['persist'])]
    private Collection $books;

    public function __construct()
    {
        //$this->books = new ArrayCollection();
        $this->books = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

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
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setPublisher($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            if ($book->getPublisher() === $this) {
                $book->setPublisher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getPublisherBooks(): Collection
    {
        return $this->books;
    }

    public function addPublisherBook(Book $books): static
    {
        if (!$this->books->contains($books)) {
            $this->books->add($books);
            $books->setPublisher($this);
        }

        return $this;
    }

    public function removePublisherBook(Book $books): static
    {
        if ($this->books->removeElement($books)) {
            if ($books->getPublisher() === $this) {
                $books->setPublisher(null);
            }
        }

        return $this;
    }
   
}

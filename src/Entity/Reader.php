<?php

namespace App\Entity;

use App\Repository\ReaderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReaderRepository::class)]
class Reader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'Reader')]
    private Collection $readbook;

    public function __construct()
    {
        $this->readbook = new ArrayCollection();
    }

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getReadbook(): Collection
    {
        return $this->readbook;
    }

    public function addReadbook(Book $readbook): static
    {
        if (!$this->readbook->contains($readbook)) {
            $this->readbook->add($readbook);
        }

        return $this;
    }

    public function removeReadbook(Book $readbook): static
    {
        $this->readbook->removeElement($readbook);

        return $this;
    }
public function __toString()
    {
        return $this->getId() . ' - ' . $this->getUsername()  ;
    }
   
}

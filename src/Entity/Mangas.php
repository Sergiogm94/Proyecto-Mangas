<?php

namespace App\Entity;

use App\Repository\MangasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangasRepository::class)]
class Mangas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $year = null;

    #[ORM\OneToMany(mappedBy: 'manga', targetEntity: Characters::class)]
    private Collection $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, Characters>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Characters $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setManga($this);
        }

        return $this;
    }

    public function removeCharacter(Characters $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getManga() === $this) {
                $character->setManga(null);
            }
        }

        return $this;
    }
}

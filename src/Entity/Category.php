<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subCategory')]
    private ?self $subCategory = null;

    public function __construct()
    {
        $this->subCategory = new ArrayCollection();
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

    public function getSubCategory(): ?self
    {
        return $this->subCategory;
    }

    public function setSubCategory(?self $subCategory): static
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    public function addSubCategory(self $subCategory): static
    {
        if (!$this->subCategory->contains($subCategory)) {
            $this->subCategory->add($subCategory);
            $subCategory->setSubCategory($this);
        }

        return $this;
    }

    public function removeSubCategory(self $subCategory): static
    {
        if ($this->subCategory->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getSubCategory() === $this) {
                $subCategory->setSubCategory(null);
            }
        }

        return $this;
    }
}

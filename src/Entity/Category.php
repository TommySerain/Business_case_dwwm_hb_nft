<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'category:read'],
    denormalizationContext: ['groups' => 'nft:write', 'nft:update']
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['nft:read', 'category:read', 'nft:update'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read', 'category:read', 'nft:update'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: NFT::class, mappedBy: 'category')]
    #[Groups(['category:read'])]
    private Collection $nFTs;

    public function __construct()
    {
        $this->nFTs = new ArrayCollection();
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

    /**
     * @return Collection<int, NFT>
     */
    public function getNFTs(): Collection
    {
        return $this->nFTs;
    }

    public function addNFT(NFT $nFT): static
    {
        if (!$this->nFTs->contains($nFT)) {
            $this->nFTs->add($nFT);
            $nFT->addCategory($this);
        }

        return $this;
    }

    public function removeNFT(NFT $nFT): static
    {
        if ($this->nFTs->removeElement($nFT)) {
            $nFT->removeCategory($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CollectionNftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CollectionNftRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'nft:read', 'collection:read']
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class CollectionNft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['nft:read', 'collection:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read', 'collection:read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'collection', targetEntity: NFT::class)]
    #[Groups(['nft:read'])]
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
            $nFT->setCollection($this);
        }

        return $this;
    }

    public function removeNFT(NFT $nFT): static
    {
        if ($this->nFTs->removeElement($nFT)) {
            // set the owning side to null (unless already changed)
            if ($nFT->getCollection() === $this) {
                $nFT->setCollection(null);
            }
        }

        return $this;
    }
}

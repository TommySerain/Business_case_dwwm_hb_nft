<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\NFTRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NFTRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'nft:read']
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class NFT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'nft:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'nft:read', 'user:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'nft:read', 'user:read'])]
    private ?string $img = null;

    #[ORM\Column]
    #[Groups(['nft:read', 'user:read'])]
    private ?int $existingNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['nft:read', 'user:read'])]
    private ?\DateTimeInterface $launchDate = null;

    #[ORM\Column]
    #[Groups(['nft:read', 'user:read'])]
    private ?float $launchPriceEth = null;

    #[ORM\Column]
    #[Groups(['nft:read', 'user:read'])]
    private ?float $launchPriceEur = null;

    #[ORM\ManyToOne(inversedBy: 'nFTs')]
    #[Groups(['nft:read', 'user:read'])]
    private ?CollectionNft $collection = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'nFTs')]
    #[Groups(['nft:read', 'user:read'])]
    private Collection $category;

    #[ORM\ManyToOne(inversedBy: 'nft')]
    #[Groups(['nft:read'])]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['nft:read', 'user:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['nft:read', 'user:read'])]
    private ?string $creator = null;

    public function __construct()
    {
        $this->category = new ArrayCollection();
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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getExistingNumber(): ?int
    {
        return $this->existingNumber;
    }

    public function setExistingNumber(int $existingNumber): static
    {
        $this->existingNumber = $existingNumber;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launchDate;
    }

    public function setLaunchDate(\DateTimeInterface $launchDate): static
    {
        $this->launchDate = $launchDate;

        return $this;
    }

    public function getLaunchPriceEth(): ?float
    {
        return $this->launchPriceEth;
    }

    public function setLaunchPriceEth(float $launchPriceEth): static
    {
        $this->launchPriceEth = $launchPriceEth;

        return $this;
    }

    public function getLaunchPriceEur(): ?float
    {
        return $this->launchPriceEur;
    }

    public function setLaunchPriceEur(float $launchPriceEur): static
    {
        $this->launchPriceEur = $launchPriceEur;

        return $this;
    }

    public function getCollection(): ?CollectionNft
    {
        return $this->collection;
    }

    public function setCollection(?CollectionNft $collection): static
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): static
    {
        $this->creator = $creator;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Categories\Infrastructure\DoctrineCategory;
use App\Repository\MemoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MemoryRepository::class)]
class Memory
{
    #[Groups('memory')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups('memory')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups('memory')]
    #[ORM\Column(length: 4294967295)]
    private ?string $content = null;

    #[Groups('memory')]
    #[ORM\Column]
    private ?int $type = null;

    #[Groups('memory')]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups('memory')]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[Groups('memory')]
    #[ORM\ManyToMany(targetEntity: DoctrineCategory::class, inversedBy: 'memories')]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @return Collection<int, DoctrineCategory>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(DoctrineCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(DoctrineCategory $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}

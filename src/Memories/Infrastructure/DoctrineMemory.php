<?php

namespace App\Memories\Infrastructure;

use App\Categories\Infrastructure\DoctrineCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'memory')]
#[ORM\Entity()]
class DoctrineMemory
{
    #[Groups('memory')]
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    public string $id;

    #[Groups('memory')]
    #[ORM\Column(length: 255)]
    public string $name;

    #[Groups('memory')]
    #[ORM\Column(length: 4294967295)]
    public ?string $content = null;

    #[Groups('memory')]
    #[ORM\Column]
    public ?int $type = null;

    #[ORM\Column(length: 36)]
    public string $userId;

    #[Groups('memory')]
    #[ORM\Column]
    public ?\DateTimeImmutable $createdAt = null;

    #[Groups('memory')]
    #[ORM\Column(nullable: true)]
    public ?\DateTimeImmutable $modifiedAt = null;

    #[Groups('memory')]
    #[ORM\ManyToMany(targetEntity: DoctrineCategory::class)]
    public Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
}

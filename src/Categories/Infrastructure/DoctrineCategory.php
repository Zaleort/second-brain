<?php

namespace App\Categories\Infrastructure;

use App\Entity\Memory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'category')]
#[ORM\Entity()]
class DoctrineCategory
{
    #[Groups('category')]
    #[ORM\Id]
    #[ORM\Column]
    public string $id;

    #[Groups('category')]
    #[ORM\Column(length: 255, unique: true)]
    public ?string $name = null;

    #[Groups('category_memories')]
    #[ORM\ManyToMany(targetEntity: Memory::class, mappedBy: 'categories')]
    public Collection $memories;

    public function __construct()
    {
        $this->memories = new ArrayCollection();
    }
}

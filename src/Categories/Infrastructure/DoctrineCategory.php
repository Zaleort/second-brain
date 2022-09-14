<?php

namespace App\Categories\Infrastructure;

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

    public function __construct()
    {
    }
}

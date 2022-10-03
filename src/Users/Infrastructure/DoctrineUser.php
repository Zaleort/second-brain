<?php

declare(strict_types=1);

namespace App\Users\Infrastructure;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'users')]
#[ORM\Entity()]
class DoctrineUser
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    public string $id;

    #[ORM\Column(length: 255)]
    public string $email;

    #[ORM\Column(length: 255)]
    public string $password;
}
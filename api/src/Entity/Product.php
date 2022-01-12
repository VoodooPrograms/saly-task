<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['index'])]
    private $name;

    #[ORM\Column(type: 'string', length: 36)]
    #[Groups(['index'])]
    private $uuid;

    #[ORM\Column(type: 'integer')]
    #[Groups(['index'])]
    private $price;

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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getPrice(): ?string
    {
        return number_format($this->price / 100, 2);
    }

    public function setPrice(string $price): self
    {
        $this->price = floatval($price) * 100;

        return $this;
    }

    #[ORM\PrePersist]
    public function generateUuid(): self
    {
        $this->uuid = Uuid::v4()->toRfc4122();

        return $this;
    }
}

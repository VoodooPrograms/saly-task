<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $created_at;

    #[ORM\PrePersist]
    public function onPrePersistSetCreatedDate()
    {
        $this->created_at = new DateTime();
    }

    public function getCreatedAtDate(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAtDate(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
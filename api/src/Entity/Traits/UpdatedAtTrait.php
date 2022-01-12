<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated_at;

    #[ORM\PreUpdate]
    public function onPrePersistSetUpdatedDate()
    {
        $this->updated_at = new DateTime();
    }

    public function getUpdatedAtDate(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAtDate(DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
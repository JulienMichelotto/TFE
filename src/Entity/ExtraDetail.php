<?php

namespace App\Entity;

use App\Repository\ExtraDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExtraDetailRepository::class)
 */
class ExtraDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $detail;

    /**
     * @ORM\ManyToOne(targetEntity=Extra::class, inversedBy="details")
     * @ORM\JoinColumn(nullable=true)
     */
    private $extra;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $percent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getExtra(): ?Extra
    {
        return $this->extra;
    }

    public function setExtra(?Extra $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function getPercent(): ?int
    {
        return $this->percent;
    }

    public function setPercent(?int $percent): self
    {
        $this->percent = $percent;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\ExtraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExtraRepository::class)
 */
class Extra
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=ExtraDetail::class, mappedBy="extra")
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=Curiculum::class, inversedBy="extra")
     */
    private $curiculum;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|ExtraDetail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(ExtraDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setExtra($this);
        }

        return $this;
    }

    public function removeDetail(ExtraDetail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getExtra() === $this) {
                $detail->setExtra(null);
            }
        }

        return $this;
    }

    public function getCuriculum(): ?Curiculum
    {
        return $this->curiculum;
    }

    public function setCuriculum(?Curiculum $curiculum): self
    {
        $this->curiculum = $curiculum;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}

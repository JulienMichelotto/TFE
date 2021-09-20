<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
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
    private $descr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $societyName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $jobCity;

    /**
     * @ORM\Column(type="date")
     */
    private $start;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $end;

    /**
     * @ORM\OneToMany(targetEntity=JobDetail::class, mappedBy="job")
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=Curiculum::class, inversedBy="job")
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

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(string $descr): self
    {
        $this->descr = $descr;

        return $this;
    }

    public function getSocietyName(): ?string
    {
        return $this->societyName;
    }

    public function setSocietyName(?string $societyName): self
    {
        $this->societyName = $societyName;

        return $this;
    }

    public function getJobCity(): ?string
    {
        return $this->jobCity;
    }

    public function setJobCity(?string $jobCity): self
    {
        $this->jobCity = $jobCity;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return Collection|JobDetail[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(JobDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setJob($this);
        }

        return $this;
    }

    public function removeDetail(JobDetail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getJob() === $this) {
                $detail->setJob(null);
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

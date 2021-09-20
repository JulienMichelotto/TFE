<?php

namespace App\Entity;

use App\Repository\CuriculumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=CuriculumRepository::class)
 * @Vich\Uploadable
 */
class Curiculum implements Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="curiculum")
     */
    private $formation;

    /**
     * @ORM\OneToMany(targetEntity=Job::class, mappedBy="curiculum")
     */
    private $job;

    /**
     * @ORM\OneToMany(targetEntity=Extra::class, mappedBy="curiculum")
     */
    private $extra;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cv")
     */
    private $user;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="curiculum", fileNameProperty="imageName")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Template::class, inversedBy="curiculum")
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $highlightColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cvFile;

    public function __construct()
    {
        $this->formation = new ArrayCollection();
        $this->job = new ArrayCollection();
        $this->extra = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormation(): Collection
    {
        return $this->formation;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formation->contains($formation)) {
            $this->formation[] = $formation;
            $formation->setCuriculum($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formation->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCuriculum() === $this) {
                $formation->setCuriculum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Job[]
     */
    public function getJob(): Collection
    {
        return $this->job;
    }

    public function addJob(Job $job): self
    {
        if (!$this->job->contains($job)) {
            $this->job[] = $job;
            $job->setCuriculum($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->job->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getCuriculum() === $this) {
                $job->setCuriculum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Extra[]
     */
    public function getExtra(): Collection
    {
        return $this->extra;
    }

    public function addExtra(Extra $extra): self
    {
        if (!$this->extra->contains($extra)) {
            $this->extra[] = $extra;
            $extra->setCuriculum($this);
        }

        return $this;
    }

    public function removeExtra(Extra $extra): self
    {
        if ($this->extra->removeElement($extra)) {
            // set the owning side to null (unless already changed)
            if ($extra->getCuriculum() === $this) {
                $extra->setCuriculum(null);
            }
        }

        return $this;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    public function serialize()
    {
        
    }
    public function unserialize($data)
    {
        
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

    public function getTemplate(): ?Template
    {
        return $this->template;
    }

    public function setTemplate(?Template $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getHighlightColor(): ?string
    {
        return $this->highlightColor;
    }

    public function setHighlightColor(?string $highlightColor): self
    {
        $this->highlightColor = $highlightColor;

        return $this;
    }

    public function getCvFile(): ?string
    {
        return $this->cvFile;
    }

    public function setCvFile(?string $cvFile): self
    {
        $this->cvFile = $cvFile;

        return $this;
    }



}

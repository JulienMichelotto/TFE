<?php

namespace App\Entity;

use App\Repository\TemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TemplateRepository::class)
 */
class Template
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
     * @ORM\Column(type="boolean")
     */
    private $dark;

    /**
     * @ORM\ManyToMany(targetEntity=Color::class, mappedBy="template_color")
     */
    private $colors;

    /**
     * @ORM\OneToMany(targetEntity=Curiculum::class, mappedBy="template")
     */
    private $curiculum;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $codeFile;

    public function __construct()
    {
        $this->colors = new ArrayCollection();
        $this->curiculum = new ArrayCollection();
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

    public function getDark(): ?bool
    {
        return $this->dark;
    }

    public function setDark(bool $dark): self
    {
        $this->dark = $dark;

        return $this;
    }

    /**
     * @return Collection|Color[]
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(Color $color): self
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
            $color->addTemplateColor($this);
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->colors->removeElement($color)) {
            $color->removeTemplateColor($this);
        }

        return $this;
    }

    /**
     * @return Collection|curiculum[]
     */
    public function getCuriculum(): Collection
    {
        return $this->curiculum;
    }

    public function addCuriculum(curiculum $curiculum): self
    {
        if (!$this->curiculum->contains($curiculum)) {
            $this->curiculum[] = $curiculum;
            $curiculum->setTemplate($this);
        }

        return $this;
    }

    public function removeCuriculum(curiculum $curiculum): self
    {
        if ($this->curiculum->removeElement($curiculum)) {
            // set the owning side to null (unless already changed)
            if ($curiculum->getTemplate() === $this) {
                $curiculum->setTemplate(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCodeFile(): ?string
    {
        return $this->codeFile;
    }

    public function setCodeFile(?string $codeFile): self
    {
        $this->codeFile = $codeFile;

        return $this;
    }
}

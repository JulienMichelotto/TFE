<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color
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
     * @ORM\ManyToMany(targetEntity=Template::class, inversedBy="colors")
     */
    private $template_color;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct()
    {
        $this->template_color = new ArrayCollection();
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

    /**
     * @return Collection|Template[]
     */
    public function getTemplateColor(): Collection
    {
        return $this->template_color;
    }

    public function addTemplateColor(Template $templateColor): self
    {
        if (!$this->template_color->contains($templateColor)) {
            $this->template_color[] = $templateColor;
        }

        return $this;
    }

    public function removeTemplateColor(Template $templateColor): self
    {
        $this->template_color->removeElement($templateColor);

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
}

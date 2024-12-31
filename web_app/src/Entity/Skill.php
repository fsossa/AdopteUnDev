<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Developer>
     */
    #[ORM\ManyToMany(targetEntity: Developer::class, inversedBy: 'skills')]
    private Collection $developers_has_skills;

    /**
     * @var Collection<int, Poste>
     */
    #[ORM\ManyToMany(targetEntity: Poste::class, inversedBy: 'skills')]
    private Collection $postes_has_skills;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->developers_has_skills = new ArrayCollection();
        $this->postes_has_skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    public function getDevelopersHasSkills(): Collection
    {
        return $this->developers_has_skills;
    }

    public function addDevelopersHasSkill(Developer $developersHasSkill): static
    {
        if (!$this->developers_has_skills->contains($developersHasSkill)) {
            $this->developers_has_skills->add($developersHasSkill);
        }

        return $this;
    }

    public function removeDevelopersHasSkill(Developer $developersHasSkill): static
    {
        $this->developers_has_skills->removeElement($developersHasSkill);

        return $this;
    }

    /**
     * @return Collection<int, Poste>
     */
    public function getPostesHasSkills(): Collection
    {
        return $this->postes_has_skills;
    }

    public function addPostesHasSkill(Poste $postesHasSkill): static
    {
        if (!$this->postes_has_skills->contains($postesHasSkill)) {
            $this->postes_has_skills->add($postesHasSkill);
        }

        return $this;
    }

    public function removePostesHasSkill(Poste $postesHasSkill): static
    {
        $this->postes_has_skills->removeElement($postesHasSkill);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}

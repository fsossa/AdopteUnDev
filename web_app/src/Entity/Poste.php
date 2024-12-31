<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $location = null;

    #[ORM\Column]
    private ?int $experiences = null;

    #[ORM\Column(nullable: true)]
    private ?int $min_salary = null;

    #[ORM\Column(nullable: true)]
    private ?int $max_salary = null;

    #[ORM\ManyToOne(inversedBy: 'postes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    // /**
    //  * @var Collection<int, Developer>
    //  */
    // #[ORM\ManyToMany(targetEntity: Developer::class, inversedBy: 'postes')]
    // private Collection $developer_has_poste;

    // /**
    //  * @var Collection<int, Developer>
    //  */
    // #[ORM\ManyToMany(targetEntity: Developer::class, inversedBy: 'visited_postes')]
    // private Collection $developer_visite_poste;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'postes_has_skills')]
    private Collection $skills;
    
    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, DeveloperFavPoste>
     */
    #[ORM\OneToMany(targetEntity: DeveloperFavPoste::class, mappedBy: 'poste', orphanRemoval: true)]
    private Collection $developerFavPostes;

    /**
     * @var Collection<int, DeveloperVisitePoste>
     */
    #[ORM\OneToMany(targetEntity: DeveloperVisitePoste::class, mappedBy: 'poste', orphanRemoval: true)]
    private Collection $developerVisitePostes;

    public function __construct()
    {
        // $this->developer_has_poste = new ArrayCollection();
        // $this->developer_visite_poste = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->developerFavPostes = new ArrayCollection();
        $this->developerVisitePostes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getExperiences(): ?int
    {
        return $this->experiences;
    }

    public function setExperiences(int $experiences): static
    {
        $this->experiences = $experiences;

        return $this;
    }

    public function getMinSalary(): ?int
    {
        return $this->min_salary;
    }

    public function setMinSalary(?int $min_salary): static
    {
        $this->min_salary = $min_salary;

        return $this;
    }

    public function getMaxSalary(): ?int
    {
        return $this->max_salary;
    }

    public function setMaxSalary(?int $max_salary): static
    {
        $this->max_salary = $max_salary;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Developer>
     */
    // public function getDeveloperHasPoste(): Collection
    // {
    //     return $this->developer_has_poste;
    // }

    // public function addDeveloperHasPoste(Developer $developerHasPoste): static
    // {
    //     if (!$this->developer_has_poste->contains($developerHasPoste)) {
    //         $this->developer_has_poste->add($developerHasPoste);
    //     }

    //     return $this;
    // }

    // public function removeDeveloperHasPoste(Developer $developerHasPoste): static
    // {
    //     $this->developer_has_poste->removeElement($developerHasPoste);

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Developer>
    //  */
    // public function getDeveloperVisitePoste(): Collection
    // {
    //     return $this->developer_visite_poste;
    // }

    // public function addDeveloperVisitePoste(Developer $developerVisitePoste): static
    // {
    //     if (!$this->developer_visite_poste->contains($developerVisitePoste)) {
    //         $this->developer_visite_poste->add($developerVisitePoste);
    //     }

    //     return $this;
    // }

    // public function removeDeveloperVisitePoste(Developer $developerVisitePoste): static
    // {
    //     $this->developer_visite_poste->removeElement($developerVisitePoste);

    //     return $this;
    // }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->addPostesHasSkill($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removePostesHasSkill($this);
        }

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

    /**
     * @return Collection<int, DeveloperFavPoste>
     */
    public function getDeveloperFavPostes(): Collection
    {
        return $this->developerFavPostes;
    }

    public function addDeveloperFavPoste(DeveloperFavPoste $developerFavPoste): static
    {
        if (!$this->developerFavPostes->contains($developerFavPoste)) {
            $this->developerFavPostes->add($developerFavPoste);
            $developerFavPoste->setPoste($this);
        }

        return $this;
    }

    public function removeDeveloperFavPoste(DeveloperFavPoste $developerFavPoste): static
    {
        if ($this->developerFavPostes->removeElement($developerFavPoste)) {
            // set the owning side to null (unless already changed)
            if ($developerFavPoste->getPoste() === $this) {
                $developerFavPoste->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DeveloperVisitePoste>
     */
    public function getDeveloperVisitePostes(): Collection
    {
        return $this->developerVisitePostes;
    }

    public function addDeveloperVisitePoste(DeveloperVisitePoste $developerVisitePoste): static
    {
        if (!$this->developerVisitePostes->contains($developerVisitePoste)) {
            $this->developerVisitePostes->add($developerVisitePoste);
            $developerVisitePoste->setPoste($this);
        }

        return $this;
    }

    public function removeDeveloperVisitePoste(DeveloperVisitePoste $developerVisitePoste): static
    {
        if ($this->developerVisitePostes->removeElement($developerVisitePoste)) {
            // set the owning side to null (unless already changed)
            if ($developerVisitePoste->getPoste() === $this) {
                $developerVisitePoste->setPoste(null);
            }
        }

        return $this;
    }
}

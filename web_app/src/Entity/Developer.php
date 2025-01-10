<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column]
    private ?int $experiences = 0;

    #[ORM\Column]
    private ?int $salary = 0;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $avatar = null;

    #[ORM\OneToOne(inversedBy: 'developer', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // /**
    //  * @var Collection<int, Poste>
    //  */
    // #[ORM\ManyToMany(targetEntity: Poste::class, mappedBy: 'developer_has_poste')]
    // private Collection $fav_postes;

    // /**
    //  * @var Collection<int, Poste>
    //  */
    // #[ORM\ManyToMany(targetEntity: Poste::class, mappedBy: 'developer_visite_poste')]
    // private Collection $visited_postes;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'developers_has_skills')]
    private Collection $skills;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'dev_give_notes')]
    private Collection $my_notes;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'evaluation')]
    private Collection $dev_give_notes;

    /**
     * @var Collection<int, DeveloperFavPoste>
     */
    #[ORM\OneToMany(targetEntity: DeveloperFavPoste::class, mappedBy: 'developer', orphanRemoval: true)]
    private Collection $developerFavPostes;

    /**
     * @var Collection<int, DeveloperVisitePoste>
     */
    #[ORM\OneToMany(targetEntity: DeveloperVisitePoste::class, mappedBy: 'developer', orphanRemoval: true)]
    private Collection $developerVisitePostes;

    /**
     * @var Collection<int, CompanyFavDeveloper>
     */
    #[ORM\OneToMany(targetEntity: CompanyFavDeveloper::class, mappedBy: 'developer', orphanRemoval: true)]
    private Collection $companyFavDevelopers;

    /**
     * @var Collection<int, CompanyVisiteDeveloper>
     */
    #[ORM\OneToMany(targetEntity: CompanyVisiteDeveloper::class, mappedBy: 'developer', orphanRemoval: true)]
    private Collection $companyVisiteDevelopers;

    // /**
    //  * @var Collection<int, Company>
    //  */
    // #[ORM\ManyToMany(targetEntity: Company::class, inversedBy: 'fav_developers')]
    // private Collection $companies_has_developers;

    // /**
    //  * @var Collection<int, Company>
    //  */
    // #[ORM\ManyToMany(targetEntity: Company::class, inversedBy: 'visited_developers')]
    // private Collection $companies_visite_developers;

    public function __construct()
    {
        // $this->fav_postes = new ArrayCollection();
        // $this->visited_postes = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->my_notes = new ArrayCollection();
        $this->dev_give_notes = new ArrayCollection();
        // $this->companies_has_developers = new ArrayCollection();
        // $this->companies_visite_developers = new ArrayCollection();
        $this->developerFavPostes = new ArrayCollection();
        $this->developerVisitePostes = new ArrayCollection();
        $this->companyFavDevelopers = new ArrayCollection();
        $this->companyVisiteDevelopers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

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

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    // /**
    //  * @return Collection<int, Poste>
    //  */
    // public function getPostes(): Collection
    // {
    //     return $this->fav_postes;
    // }

    // public function addPoste(Poste $poste): static
    // {
    //     if (!$this->fav_postes->contains($poste)) {
    //         $this->fav_postes->add($poste);
    //         $poste->addDeveloperHasPoste($this);
    //     }

    //     return $this;
    // }

    // public function removePoste(Poste $poste): static
    // {
    //     if ($this->fav_postes->removeElement($poste)) {
    //         $poste->removeDeveloperHasPoste($this);
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Poste>
    //  */
    // public function getVisitedPostes(): Collection
    // {
    //     return $this->visited_postes;
    // }

    // public function addVisitedPoste(Poste $visitedPoste): static
    // {
    //     if (!$this->visited_postes->contains($visitedPoste)) {
    //         $this->visited_postes->add($visitedPoste);
    //         $visitedPoste->addDeveloperVisitePoste($this);
    //     }

    //     return $this;
    // }

    // public function removeVisitedPoste(Poste $visitedPoste): static
    // {
    //     if ($this->visited_postes->removeElement($visitedPoste)) {
    //         $visitedPoste->removeDeveloperVisitePoste($this);
    //     }

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
            $skill->addDevelopersHasSkill($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeDevelopersHasSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getEvaluation(): Collection
    {
        return $this->my_notes;
    }

    public function addEvaluation(self $evaluation): static
    {
        if (!$this->my_notes->contains($evaluation)) {
            $this->my_notes->add($evaluation);
        }

        return $this;
    }

    public function removeEvaluation(self $evaluation): static
    {
        $this->my_notes->removeElement($evaluation);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getDevGiveNotes(): Collection
    {
        return $this->dev_give_notes;
    }

    public function addDevGiveNote(self $devGiveNote): static
    {
        if (!$this->dev_give_notes->contains($devGiveNote)) {
            $this->dev_give_notes->add($devGiveNote);
            $devGiveNote->addEvaluation($this);
        }

        return $this;
    }

    public function removeDevGiveNote(self $devGiveNote): static
    {
        if ($this->dev_give_notes->removeElement($devGiveNote)) {
            $devGiveNote->removeEvaluation($this);
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Company>
    //  */
    // public function getCompaniesHasDevelopers(): Collection
    // {
    //     return $this->companies_has_developers;
    // }

    // public function addCompaniesHasDeveloper(Company $companiesHasDeveloper): static
    // {
    //     if (!$this->companies_has_developers->contains($companiesHasDeveloper)) {
    //         $this->companies_has_developers->add($companiesHasDeveloper);
    //     }

    //     return $this;
    // }

    // public function removeCompaniesHasDeveloper(Company $companiesHasDeveloper): static
    // {
    //     $this->companies_has_developers->removeElement($companiesHasDeveloper);

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Company>
    //  */
    // public function getCompaniesVisiteDevelopers(): Collection
    // {
    //     return $this->companies_visite_developers;
    // }

    // public function addCompaniesVisiteDeveloper(Company $companiesVisiteDeveloper): static
    // {
    //     if (!$this->companies_visite_developers->contains($companiesVisiteDeveloper)) {
    //         $this->companies_visite_developers->add($companiesVisiteDeveloper);
    //     }

    //     return $this;
    // }

    // public function removeCompaniesVisiteDeveloper(Company $companiesVisiteDeveloper): static
    // {
    //     $this->companies_visite_developers->removeElement($companiesVisiteDeveloper);

    //     return $this;
    // }

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
            $developerFavPoste->setDeveloper($this);
        }

        return $this;
    }

    public function removeDeveloperFavPoste(DeveloperFavPoste $developerFavPoste): static
    {
        if ($this->developerFavPostes->removeElement($developerFavPoste)) {
            // set the owning side to null (unless already changed)
            if ($developerFavPoste->getDeveloper() === $this) {
                $developerFavPoste->setDeveloper(null);
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
            $developerVisitePoste->setDeveloper($this);
        }

        return $this;
    }

    public function removeDeveloperVisitePoste(DeveloperVisitePoste $developerVisitePoste): static
    {
        if ($this->developerVisitePostes->removeElement($developerVisitePoste)) {
            // set the owning side to null (unless already changed)
            if ($developerVisitePoste->getDeveloper() === $this) {
                $developerVisitePoste->setDeveloper(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyFavDeveloper>
     */
    public function getCompanyFavDevelopers(): Collection
    {
        return $this->companyFavDevelopers;
    }

    public function getMyNotes(): Collection
{
    return $this->my_notes;
}


    public function addCompanyFavDeveloper(CompanyFavDeveloper $companyFavDeveloper): static
    {
        if (!$this->companyFavDevelopers->contains($companyFavDeveloper)) {
            $this->companyFavDevelopers->add($companyFavDeveloper);
            $companyFavDeveloper->setDeveloper($this);
        }

        return $this;
    }

    public function removeCompanyFavDeveloper(CompanyFavDeveloper $companyFavDeveloper): static
    {
        if ($this->companyFavDevelopers->removeElement($companyFavDeveloper)) {
            // set the owning side to null (unless already changed)
            if ($companyFavDeveloper->getDeveloper() === $this) {
                $companyFavDeveloper->setDeveloper(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyVisiteDeveloper>
     */
    public function getCompanyVisiteDevelopers(): Collection
    {
        return $this->companyVisiteDevelopers;
    }

    public function addCompanyVisiteDeveloper(CompanyVisiteDeveloper $companyVisiteDeveloper): static
    {
        if (!$this->companyVisiteDevelopers->contains($companyVisiteDeveloper)) {
            $this->companyVisiteDevelopers->add($companyVisiteDeveloper);
            $companyVisiteDeveloper->setDeveloper($this);
        }

        return $this;
    }

    public function removeCompanyVisiteDeveloper(CompanyVisiteDeveloper $companyVisiteDeveloper): static
    {
        if ($this->companyVisiteDevelopers->removeElement($companyVisiteDeveloper)) {
            // set the owning side to null (unless already changed)
            if ($companyVisiteDeveloper->getDeveloper() === $this) {
                $companyVisiteDeveloper->setDeveloper(null);
            }
        }

        return $this;
    }
}

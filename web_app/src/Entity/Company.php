<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'company', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Poste>
     */
    #[ORM\OneToMany(targetEntity: Poste::class, mappedBy: 'company', orphanRemoval: true)]
    private Collection $postes;

    // /**
    //  * @var Collection<int, Developer>
    //  */
    // #[ORM\ManyToMany(targetEntity: Developer::class, mappedBy: 'companies_has_developers')]
    // private Collection $fav_developers;

    // /**
    //  * @var Collection<int, Developer>
    //  */
    // #[ORM\ManyToMany(targetEntity: Developer::class, mappedBy: 'companies_visite_developers')]
    // private Collection $visited_developers;

    public function __construct()
    {
        $this->postes = new ArrayCollection();
        // $this->fav_developers = new ArrayCollection();
        // $this->visited_developers = new ArrayCollection();
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Poste>
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(Poste $poste): static
    {
        if (!$this->postes->contains($poste)) {
            $this->postes->add($poste);
            $poste->setCompany($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): static
    {
        if ($this->postes->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getCompany() === $this) {
                $poste->setCompany(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Developer>
    //  */
    // public function getFavDevelopers(): Collection
    // {
    //     return $this->fav_developers;
    // }

    // public function addFavDeveloper(Developer $favDeveloper): static
    // {
    //     if (!$this->fav_developers->contains($favDeveloper)) {
    //         $this->fav_developers->add($favDeveloper);
    //         $favDeveloper->addCompaniesHasDeveloper($this);
    //     }

    //     return $this;
    // }

    // public function removeFavDeveloper(Developer $favDeveloper): static
    // {
    //     if ($this->fav_developers->removeElement($favDeveloper)) {
    //         $favDeveloper->removeCompaniesHasDeveloper($this);
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Developer>
    //  */
    // public function getVisitedDevelopers(): Collection
    // {
    //     return $this->visited_developers;
    // }

    // public function addVisitedDeveloper(Developer $visitedDeveloper): static
    // {
    //     if (!$this->visited_developers->contains($visitedDeveloper)) {
    //         $this->visited_developers->add($visitedDeveloper);
    //         $visitedDeveloper->addCompaniesVisiteDeveloper($this);
    //     }

    //     return $this;
    // }

    // public function removeVisitedDeveloper(Developer $visitedDeveloper): static
    // {
    //     if ($this->visited_developers->removeElement($visitedDeveloper)) {
    //         $visitedDeveloper->removeCompaniesVisiteDeveloper($this);
    //     }

    //     return $this;
    // }
}

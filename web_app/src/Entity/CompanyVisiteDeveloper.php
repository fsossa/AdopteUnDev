<?php

namespace App\Entity;

use App\Repository\CompanyVisiteDeveloperRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyVisiteDeveloperRepository::class)]
class CompanyVisiteDeveloper
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'companyVisiteDevelopers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'companyVisiteDevelopers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Developer $developer = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDeveloper(): ?Developer
    {
        return $this->developer;
    }

    public function setDeveloper(?Developer $developer): static
    {
        $this->developer = $developer;

        return $this;
    }
}

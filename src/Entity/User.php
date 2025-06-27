<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $role = null;

    /**
     * @var Collection<int, Historique>
     */
    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'admin', orphanRemoval: true)]
    private Collection $Historiques;

    public function __construct()
    {
        $this->Historiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistoriques(): Collection
    {
        return $this->Historiques;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->Historiques->contains($historique)) {
            $this->Historiques->add($historique);
            $historique->setAdmin($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->Historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getAdmin() === $this) {
                $historique->setAdmin(null);
            }
        }

        return $this;
    }
}

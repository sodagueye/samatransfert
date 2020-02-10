<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Secured resource.
 *
 * @ApiResource(
 *     attributes={"acces_control"="is_granted('POST_EDIT')"},
 *     collectionOperations={
 *         "get",
 *         "post"={"acces_control"="is_granted('POST_EDIT')"}
 *     },
 *     itemOperations={
 *         "get",
 *         "put"={"acces_control"="is_granted('POST_EDIT', object) or object.owner == user"},
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="users")
     */
    private $profil;
    
    private $roles=[];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partenaire", mappedBy="user")
     */
    private $partenaires;

    public function __construct()
    {
        $this->partenaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function getRoles()
    {
        return $this->roles=['ROLE_'.strtoupper($this->getProfil()->getLibelle())];
    }

    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
        return null;
    }

    /**
     * @return Collection|Partenaire[]
     */
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires[] = $partenaire;
            $partenaire->setUser($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->contains($partenaire)) {
            $this->partenaires->removeElement($partenaire);
            // set the owning side to null (unless already changed)
            if ($partenaire->getUser() === $this) {
                $partenaire->setUser(null);
            }
        }

        return $this;
    }
    
}

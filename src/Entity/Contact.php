<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

    // L'objet UniqueEntity permet de préciser les champs qui attendent des données uniques. Ici, les champs "email" et "phone".

    /**
     * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
     * @UniqueEntity(
     *  fields = {"email", "phone"},
     *  message = "Ces coordonées sont déjà associées à un compte."
     * )
     * 
     */

    /**
     * @ORM\Entity(repositoryClass=ContactRepository::class)
     */
class Contact
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    // La contrainte Type impose un type de données attendu. Ici, le numéro de téléphone doit être de valeur numérique.
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type(type = {"digit"},
     * message = "Ce champ ne doit contenir que des caractères numériques.")
     */

    
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     * message="Cette adresse email n'est pas valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="300", maxMessage="Votre message est limité à 300 caractères.")
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

// L'objet UniqueEntity permet de préciser les champs qui attendent des données uniques. Ici, le champ "email".
// On précise ici à Symfony qu'Utilisateur est la table contenant tous les utilisateurs du site.
// Pour pouvoir encoder le mot de passe, il faut que notre entité User implemente l'interface UserInterface.

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 *  fields = {"email"},
 *  message = "Cette adresse email est déjà associée à un compte."
 * )
 * 
 */

 
class Utilisateur implements UserInterface
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;


    //  On appelle l'objet Assert et on pointe sur la contrainte Email pour transformer le champ en type ="email"
    // Cette contrainte fait en sorte que l'email que soit unique dans la BDD pour éviter les doublons.

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *  message="Cette adresse email '{{ value }}' n'est pas valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;


    // On importe l'objet Assert (cf l.7) et on pioche les méthodes Length() et EqualTo().
    // Length est une contrainte de longueur.
    // EqualTo est une contrainte qui requiert que la valeur du champ password soit égale à celle du champ confirm_password

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit contenir 8 caractères minimum.")
     *
     */
    private $password;
    
    
    // On ajoute une propriété public qui sera en charge de comparer le mot de passe
    // au mot de passe renseigné dans le formulaire.
    // Inutile d'ajouter une annotation ORM, ni d'ajouter des seters et geters
    // car ils ne seront pas ajoutés en BDD.

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne correspondent pas.")
     * 
     */
    public $confirm_password;
    
    // Par défaut, aucun utilisateur n'est premium.
    /**
     * @ORM\Column(type="string", length=255)
     */
   
    private $premium = 'non';

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $document;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $commentaire;



    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    /*
        Pour pouvoir encoder le mot de passe, il faut que notre entité Utilisateur implemente l'interface UserInterface.
        Cette interface contient des méthodes que nous sommes obligés de déclarer :
        getPassword(), getUsername(), getRoles(), getSalt() et eraseCredentials().    
    */

    // Cette méthode est uniquement destinée à nettoyer les mots de passe en texte brut (en clair) éventuellement stockés en BDD.
    public function eraseCredentials()
    {

    }

    // Cette méthode renvoie la chaîne de caractères non encodée que l'utilisateur a saisi et qui, à l'origine,
    // a été utilisée pour encoder le mot de passe. 
    public function getSalt()
    {

    }


    public function getPremium(): ?string
    {
        return $this->premium;
    }

    public function setPremium(string $premium): self
    {
        $this->premium = $premium;

        return $this;
    }

    
    // Cette méthode renvoie un tableau de chaînes de caractères où sont stockés les rôles(droits) accordés à l'utilisateur.
    public function getRoles(): ?array
    {
            // Cette méthide ne retourne que les ROLE_USER de la BDD. Les administrateurs n'ont pas accès au site car ils ont un ROLE_ADMIN
            // qui n'est pas retourné par cette méthode.
            
            return ['ROLE_USER'];

    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getDocument(): ?self
    {
        return $this->document;
    }

    public function setDocument(?self $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getCommentaire(): ?self
    {
        return $this->commentaire;
    }

    public function setCommentaire(?self $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

 
}

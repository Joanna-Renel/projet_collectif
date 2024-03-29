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
    private $roles = ["ROLE_USER"];

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Docs::class, mappedBy="utilisateur", orphanRemoval=true)
     */
    private $docs;

    public function __construct()
    {
        $this->docs = new ArrayCollection();
    }
    
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
            
            return $this->roles;

    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUtilisateur($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUtilisateur() === $this) {
                $comment->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Docs[]
     */
    public function getDocs(): Collection
    {
        return $this->docs;
    }

    public function addDoc(Docs $doc): self
    {
        if (!$this->docs->contains($doc)) {
            $this->docs[] = $doc;
            $doc->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDoc(Docs $doc): self
    {
        if ($this->docs->contains($doc)) {
            $this->docs->removeElement($doc);
            // set the owning side to null (unless already changed)
            if ($doc->getUtilisateur() === $this) {
                $doc->setUtilisateur(null);
            }
        }

        return $this;
    }

 
}

<?php

namespace MessagerieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Membre
 *
 * @ORM\Table(name="membres")
 * @ORM\Entity(repositoryClass="MessagerieBundle\Repository\MembreRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Membre implements EquatableInterface, UserInterface, \Serializable, \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", length=255, nullable=true)
     */
    private $job;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="longname", type="string", length=255)
     */
    private $longname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true)
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLogin", type="datetimetz", nullable=true)
     */
    private $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastOnline", type="datetimetz", nullable=true)
     */
    private $lastOnline;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", unique=false)
     */
    private $roles;

    /**
     * @var Discussion
     *
     * @ORM\OneToMany(targetEntity="Discussion", mappedBy="creator")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discussions;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = array('ROLE_USER');

        $this->salt = sha1(uniqid().time());
    }

    public function eraseCredentials() {
        // Ici nous n'avons rien à effacer. 
        // Cela aurait été le cas si nous avions un mot de passe en clair.
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof Membre) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }

        return true;
    }


    public function hasRole($role, $strict = false) {
        if(!$strict && in_array('ROLE_ADMIN', $this->roles) || in_array('ROLE_SUPER_ADMIN', $this->roles)){
            return true;
        }

        return in_array($role, $this->roles);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preFlush()
    {
        $this->longname = $this->name.' '.$this->surname;
    }

        /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            $this->salt
        ) = unserialize($serialized);
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Membre
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set job
     *
     * @param string $job
     *
     * @return Membre
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Membre
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Membre
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set longname
     *
     * @param string $longname
     *
     * @return Membre
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string
     */
    public function getLongname()
    {
        return $this->longname;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Membre
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return Membre
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set lastOnline
     *
     * @param \DateTime $lastOnline
     *
     * @return Membre
     */
    public function setLastOnline($lastOnline)
    {
        $this->lastOnline = $lastOnline;

        return $this;
    }

    /**
     * Get lastOnline
     *
     * @return \DateTime
     */
    public function getLastOnline()
    {
        return $this->lastOnline;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Membre
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return Membre
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set photo
     *
     * @param \MessagerieBundle\Entity\Image $photo
     *
     * @return Membre
     */
    public function setPhoto($photo = null)
    {
        if($photo instanceof \Symfony\Component\HttpFoundation\File\UploadedFile){
            $photo = new \MessagerieBundle\Entity\Image($photo);
        }
        if($photo != null) {
            $this->photo = $photo;
        }

        return $this;
    }

    /**
     * Get photo
     *
     * @return \MessagerieBundle\Entity\Image
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Add discussion
     *
     * @param \MessagerieBundle\Entity\Discussion $discussion
     *
     * @return Membre
     */
    public function addDiscussion(\MessagerieBundle\Entity\Discussion $discussion)
    {
        $this->discussions[] = $discussion;

        return $this;
    }

    /**
     * Remove discussion
     *
     * @param \MessagerieBundle\Entity\Discussion $discussion
     */
    public function removeDiscussion(\MessagerieBundle\Entity\Discussion $discussion)
    {
        $this->discussions->removeElement($discussion);
    }

    /**
     * Get discussions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiscussions()
    {
        return $this->discussions;
    }

    public function jsonSerialize() {
        $obj = [];
        $obj['id'] = $this->getId();
        $obj['longname'] = $this->longname;
        $obj['username'] = $this->username;
        $obj['lastOnline'] = $this->lastOnline;
        $obj['job'] = $this->job;
        if($this->photo) {
            $obj['photo'] = $this->photo->getWebPath();
        }else{
            $obj['photo'] = '/assets/img/avatar.png';
        }
        
        return $obj;
    }
}

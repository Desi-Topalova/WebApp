<?php

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     *@Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Потребителското име трябва да е минимум 2 символа",
     *      maxMessage = "Потребителското име трябва да е максимум 20 символа"
     * )
     *
     * @Assert\Regex(
     *     pattern="/^[a-z0-9]+$/",
     *     match=true,
     *     message="Потребителското име трябва да съдържа малки букви и цифри!"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     *@Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Името трябва да е минимум 4 символа",
     *      maxMessage = "Името трябва да е максимум 20 символа"
     * )
     * @Assert\Regex(
     *     pattern="/^[A-Za-z]+$/",
     *     match=true,
     *     message="Името не трябва да съдържа цифри!"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "Паролата трябва да е минимум 4 символа",
     *      maxMessage = "Паролата трябва да е максимум 10 символа"
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="Паролата може да съдържа само цифри!"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Problem",mappedBy="creator")
     * @ORM\JoinColumn(name="creatorId",referencedColumnName="id")
     */

    private $problems;
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role",)
     * @ORM\JoinTable(name="users_roles",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id",referencedColumnName="id")})
     */
        private $roles;

    /**
     * @var ArrayCollection|Solution[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Solution", mappedBy="creator")
     */
    private $solutions;

    /**
     * @var ArrayCollection|Message[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message", mappedBy="sender")
     */
    private $senders;

    /**
     * @var ArrayCollection|Message[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Message", mappedBy="receiver")
     */
    private $receiver;


    public function __construct()
    {
        $this->problems=new ArrayCollection();
        $this->roles=new ArrayCollection();
        $this->solutions=new ArrayCollection();
        $this->senders=new ArrayCollection();
        $this->receiver=new ArrayCollection();

    }


    /**
     * Get id
     *
     * @return int
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
     * @return User
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
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password)
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
     * Returns the roles granted to the home.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the home object
     * is created.
     *
     * @return (Role|string)[] The home roles
     */
    public function getRoles()
    {
        $stringRoles = [];

        foreach ($this->roles as $role){
            /** @var Role $role */
            $stringRoles[] = $role->getRole();
        }

        return $stringRoles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the home.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @param Role $role
     * @return User
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    /**
     * @param Problem $problem
     * @return bool
     */
    public function isCreator(Problem $problem){
        return $problem->getCreator()->getId()===$this->getId();
    }

    /**
     * @return bool
     */
    public function isAdmin(){
        return in_array("ROLE_ADMIN", $this->getRoles());
    }
    public function isPsychologist(){
        return in_array("ROLE_PSYCHOLOGIST",$this->getRoles());
    }

    /**
     * @return Solution[]|ArrayCollection
     */
    public function getSolutions()
    {
        return $this->solutions;
    }

    /**
     * @param Solution $solutions
     * @return User
     */
    public function setSolutions(Solution $solutions)
    {
        $this->solutions[] = $solutions;
        return $this;
    }

    /**
     * @return Message[]|ArrayCollection
     */
    public function getSenders()
    {
        return $this->senders;
    }

    /**
     * @param Message[]|ArrayCollection $senders
     */
    public function setSenders($senders): void
    {
        $this->senders = $senders;
    }

    /**
     * @return ArrayCollection|Message[]
     */
    public function getSenderMessages()
    {
        return $this->senders;
    }

    /**
     * @return ArrayCollection|Message[]
     */
    public function getReceiverMessages()
    {
        return $this->receiver;
    }
}

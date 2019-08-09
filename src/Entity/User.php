<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=500)
     */
    private $password;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    public function __construct($username)
    {
        $this->isActive = true;
        $this->username = $username;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getSalt()
    {
        return null;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getRoles()
    {
        return array('ROLE_USER');
    }
    public function eraseCredentials()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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
}
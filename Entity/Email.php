<?php

namespace CeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fresh\Bundle\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use CeBundle\Entity\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="CeBundle\Entity\Repository\EmailRepository")
 */
class Email
{
    use TimestampableEntity;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\NotBlank(message="fos_user.email.blank")
     * @Assert\Email(message="fos_user.email.invalid")
     * @Assert\Length(max = "100", maxMessage="fos_user.email.long")
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=100)
     */
    protected $token;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_confirm", type="boolean")
     */
    protected $isConfirm = false;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }


    /**
     * @param string $token
     * @return Email
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param boolean $isConfirm
     * @return Email
     */
    public function setIsConfirm($isConfirm)
    {
        $this->isConfirm = $isConfirm;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsConfirm()
    {
        return $this->isConfirm;
    }

    /**
     * @return string
     */
    public function isConfirmed()
    {
        return $this->isConfirm ? 'confirmed' : 'notconfirmed';
    }

    /**
     * @return array
     */
    public function toArray(){
        return array($this->email, $this->isConfirmed());
    }

}

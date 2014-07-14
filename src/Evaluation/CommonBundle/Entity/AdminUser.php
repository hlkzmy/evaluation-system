<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * AdminUser
 *
 * @ORM\Table(name="admin_user")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\AdminUserRepository")
 */
class AdminUser implements UserInterface,\Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40, nullable=false)
     */
    private $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=10, nullable=true)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="realname", type="string", length=255, nullable=true)
     */
    private $realname;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $insertTime = '0000-00-00 00:00:00';
    
    /**
     * Set insertTime
     *
     * @param \DateTime $insertTime
     * @return EvaluatedPerson
     */
    public function setInsertTime($insertTime)
    {
    	$this->insertTime = $insertTime;
    
    	return $this;
    }
    
    /**
     * Get insertTime
     *
     * @return \DateTime
     */
    public function getInsertTime()
    {
    	return $this->insertTime;
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
     * @return AdminUser
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
     * Set password
     *
     * @param string $password
     * @return AdminUser
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
     * Set salt
     *
     * @param string $salt
     * @return AdminUser
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
     * Set realname
     *
     * @param string $realname
     * @return AdminUser
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname()
    {
        return $this->realname;
    }
    
    
    /**
     * @inheritDoc
     * 因为现在的逻辑是后台只能有一种用户可以登录，
     * 所以直接返回一个跟防火墙中配置相同的用户就可以了
     */
    public function getRoles()
    {
    	return array('ROLE_ADMIN_USER');
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    
    
    /**
     * 序列化用户的相关信息,用来把用户的信息存储到session中
     */
    public function serialize(){
    	
    	return serialize(array(
    			$this->id,
    			$this->username,
    			$this->password,
    			$this->realname,
    			$this->salt
    	));
    }//function serialize() end
    
    /**
     * 反序列化用户的相关信息，从session中得到用户相关信息
     */
    
    public function unserialize($serialized){
    	
    	list ( $this->id,$this->username,$this->password,$this->realname,$this->salt) = unserialize($serialized);
    			
    }//function unserialize() end
    
    
    
    
    
}

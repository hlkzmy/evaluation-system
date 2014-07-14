<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * EvaluateUser
 *
 * @ORM\Table(name="evaluate_user")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\EvaluateUserRepository")
 */
class EvaluateUser implements UserInterface,\Serializable
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
     * @var integer
     *
     * @ORM\Column(name="evaluation_id", type="integer", nullable=true)
     */
    private $evaluationId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=6, nullable=true)
     */
    private $password;



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
     * Set evaluationId
     *
     * @param integer $evaluationId
     * @return EvaluateUser
     */
    public function setEvaluationId($evaluationId)
    {
        $this->evaluationId = $evaluationId;

        return $this;
    }

    /**
     * Get evaluationId
     *
     * @return integer 
     */
    public function getEvaluationId()
    {
        return $this->evaluationId;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return EvaluateUser
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
     * @return EvaluateUser
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
     * @inheritDoc
     * 因为现在的逻辑是后台只能有一种用户可以登录，
     * 所以直接返回一个跟防火墙中配置相同的用户就可以了
     */
    public function getRoles()
    {
    	return array('ROLE_WEB_USER');
    	
    }
    
    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
    	
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
    			$this->password
    	));
    }//function serialize() end
    
    /**
     * 反序列化用户的相关信息，从session中得到用户相关信息
     */
    
    public function unserialize($serialized){
    	 
    	list ( $this->id,$this->username,$this->password) = unserialize($serialized);
    	 
    }//function unserialize() end
    
}

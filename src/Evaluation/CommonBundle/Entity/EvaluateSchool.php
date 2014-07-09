<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluateSchool
 *
 * @ORM\Table(name="evaluate_school")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\EvaluateSchoolRepository")
 */
class EvaluateSchool
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
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_admin_user", type="integer", nullable=false)
     */
    private $createAdminUser = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $insertTime = '0000-00-00 00:00:00';



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
     * Set name
     *
     * @param string $name
     * @return EvaluateSchool
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
     * Set createAdminUser
     *
     * @param integer $createAdminUser
     * @return EvaluateSchool
     */
    public function setCreateAdminUser($createAdminUser)
    {
        $this->createAdminUser = $createAdminUser;

        return $this;
    }

    /**
     * Get createAdminUser
     *
     * @return integer 
     */
    public function getCreateAdminUser()
    {
        return $this->createAdminUser;
    }

    /**
     * Set insertTime
     *
     * @param \DateTime $insertTime
     * @return EvaluateSchool
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
}

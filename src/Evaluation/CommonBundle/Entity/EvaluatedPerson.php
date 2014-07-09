<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluatedPerson
 *
 * @ORM\Table(name="evaluated_person")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\EvaluatedPersonRepository")
 */
class EvaluatedPerson
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
     * @ORM\Column(name="realname", type="string", length=100, nullable=false)
     */
    private $realname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="school_id", type="string", length=255, nullable=true)
     */
    private $schoolId;

    /**
     * @var string
     *
     * @ORM\Column(name="create_admin_user", type="string", length=255, nullable=true)
     */
    private $createAdminUser;

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
     * Set realname
     *
     * @param string $realname
     * @return EvaluatedPerson
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
     * Set position
     *
     * @param string $position
     * @return EvaluatedPerson
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set schoolId
     *
     * @param string $schoolId
     * @return EvaluatedPerson
     */
    public function setSchoolId($schoolId)
    {
        $this->schoolId = $schoolId;

        return $this;
    }

    /**
     * Get schoolId
     *
     * @return string 
     */
    public function getSchoolId()
    {
        return $this->schoolId;
    }

    /**
     * Set createAdminUser
     *
     * @param string $createAdminUser
     * @return EvaluatedPerson
     */
    public function setCreateAdminUser($createAdminUser)
    {
        $this->createAdminUser = $createAdminUser;

        return $this;
    }

    /**
     * Get createAdminUser
     *
     * @return string 
     */
    public function getCreateAdminUser()
    {
        return $this->createAdminUser;
    }

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
}

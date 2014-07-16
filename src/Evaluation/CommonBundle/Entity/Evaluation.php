<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Evaluation\CommonBundle\Entity\EvaluatedPersonResult;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\EvaluationRepository")
 */
class Evaluation
{
	//存储一个评价人对于多个评价对象的评价结果，一个民主评价对应多个结果
	private $personResult;
	
    //存储一个评价人对于一个学校的唯一评价结果，一个民主评价对应一个结果
	private $schoolResult;
	
	public function __construct(){
		$this->personResult = new ArrayCollection();
	}
	
	public function getPersonResult(){
		return $this->personResult;
	}
	
	public function setPersonResult($personResult){
		$this->personResult = $personResult;
		return $this;
	}

	public function getSchoolResult(){
		return $this->schoolResult;
	}
	
	public function setSchoolResult($schoolResult){
		$this->schoolResult = $schoolResult;
		return $this;
	}
	
	
	
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="school_id", type="integer", nullable=false)
     */
    private $schoolId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="evaluated_person", type="text", nullable=false)
     */
    private $evaluatedPerson;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=false)
     */
    private $startTime = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=false)
     */
    private $endTime = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="evaluate_user_count", type="string", length=255, nullable=true)
     */
    private $evaluateUserCount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="create_admin_user", type="string", length=255, nullable=false)
     */
    private $createAdminUser = '';
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insert_time", type="datetime", nullable=false)
     */
    private $insertTime = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    private $status = 'N';



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
     * @return Evaluation
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
     * Set schoolId
     *
     * @param integer $schoolId
     * @return Evaluation
     */
    public function setSchoolId($schoolId)
    {
        $this->schoolId = $schoolId;

        return $this;
    }

    /**
     * Get schoolId
     *
     * @return integer 
     */
    public function getSchoolId()
    {
        return $this->schoolId;
    }

    /**
     * Set evaluatedPerson
     *
     * @param string $evaluatedPerson
     * @return Evaluation
     */
    public function setEvaluatedPerson($evaluatedPerson)
    {
        $this->evaluatedPerson = $evaluatedPerson;

        return $this;
    }

    /**
     * Get evaluatedPerson
     *
     * @return string 
     */
    public function getEvaluatedPerson()
    {
        return $this->evaluatedPerson;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Evaluation
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Evaluation
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

   

   

    /**
     * Set evaluateUserCount
     *
     * @param string $evaluateUserCount
     * @return Evaluation
     */
    public function setEvaluateUserCount($evaluateUserCount)
    {
        $this->evaluateUserCount = $evaluateUserCount;

        return $this;
    }

    /**
     * Get evaluateUserCount
     *
     * @return string 
     */
    public function getEvaluateUserCount()
    {
        return $this->evaluateUserCount;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Evaluation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
    

    /**
     * Set status
     *
     * @param string $status
     * @return Evaluation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}

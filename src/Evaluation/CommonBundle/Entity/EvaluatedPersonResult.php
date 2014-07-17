<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluatedPersonResult
 *
 * @ORM\Table(name="evaluated_person_result")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\EvaluatedPersonResultRepository")
 */
class EvaluatedPersonResult
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
     * @ORM\Column(name="school_name", type="string", length=100, nullable=true)
     */
    private $schoolName;

    /**
     * @var string
     *
     * @ORM\Column(name="realname", type="string", length=100, nullable=true)
     */
    private $realname = '';
    
    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=100, nullable=true)
     */
    private $position = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;



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
     * @return EvaluatedPersonResult
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
     * Set schoolName
     *
     * @param string $schoolName
     * @return EvaluatedPersonResult
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string 
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }
    


    /**
     * Set realname
     *
     * @param string $realname
     * @return EvaluatedPersonResult
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get Realname
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
     * @return EvaluatedPersonResult
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
     * Set score
     *
     * @param boolean $score
     * @return EvaluatedPersonResult
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return boolean 
     */
    public function getScore()
    {
        return $this->score;
    }
}

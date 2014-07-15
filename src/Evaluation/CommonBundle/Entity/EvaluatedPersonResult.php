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
     * @var integer
     *
     * @ORM\Column(name="school_id", type="integer", nullable=true)
     */
    private $schoolId;

    /**
     * @var string
     *
     * @ORM\Column(name="evaluated_person_realname", type="string", length=100, nullable=true)
     */
    private $evaluatedPersonRealname = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="score", type="boolean", nullable=true)
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
     * Set schoolId
     *
     * @param integer $schoolId
     * @return EvaluatedPersonResult
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
     * Set evaluatedPersonRealname
     *
     * @param string $evaluatedPersonRealname
     * @return EvaluatedPersonResult
     */
    public function setEvaluatedPersonRealname($evaluatedPersonRealname)
    {
        $this->evaluatedPersonRealname = $evaluatedPersonRealname;

        return $this;
    }

    /**
     * Get evaluatedPersonRealname
     *
     * @return string 
     */
    public function getEvaluatedPersonRealname()
    {
        return $this->evaluatedPersonRealname;
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

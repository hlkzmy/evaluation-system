<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluatedSchoolResult
 *
 * @ORM\Table(name="evaluated_school_result")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\EvaluatedSchoolResultRepository")
 */
class EvaluatedSchoolResult
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
     * @var boolean
     *
     * @ORM\Column(name="score", type="boolean", nullable=true)
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;



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
     * @return EvaluatedSchoolResult
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
     * @return EvaluatedSchoolResult
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
     * Set score
     *
     * @param boolean $score
     * @return EvaluatedSchoolResult
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

    /**
     * Set comment
     *
     * @param string $comment
     * @return EvaluatedSchoolResult
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }
}

<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluateResult
 *
 * @ORM\Table(name="evaluate_result")
 * @ORM\Entity(repositoryClass="Evaluation\CommonBundle\Entity\EvaluateResultRepository")
 */
class EvaluateResult
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
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
     * @ORM\Column(name="evaluate_username", type="string", length=255, nullable=true)
     */
    private $evaluateUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="json_result", type="string", length=255, nullable=true)
     */
    private $jsonResult;



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
     * @return EvaluateResult
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
     * Set evaluateUsername
     *
     * @param string $evaluateUsername
     * @return EvaluateResult
     */
    public function setEvaluateUsername($evaluateUsername)
    {
        $this->evaluateUsername = $evaluateUsername;

        return $this;
    }

    /**
     * Get evaluateUsername
     *
     * @return string 
     */
    public function getEvaluateUsername()
    {
        return $this->evaluateUsername;
    }

    /**
     * Set jsonResult
     *
     * @param string $jsonResult
     * @return EvaluateResult
     */
    public function setJsonResult($jsonResult)
    {
        $this->jsonResult = $jsonResult;

        return $this;
    }

    /**
     * Get jsonResult
     *
     * @return string 
     */
    public function getJsonResult()
    {
        return $this->jsonResult;
    }
}

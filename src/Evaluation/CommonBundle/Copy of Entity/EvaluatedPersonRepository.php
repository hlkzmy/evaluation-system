<?php

namespace Evaluation\CommonBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EvaluatedPersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvaluatedPersonRepository extends EntityRepository
{
	
	public function isPasswordLegal(){
		return false;
	}
}

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
	
	/**
	 * 为了方便在选择评价对象的时候的操作，在评价对象的真实姓名之前附加学校的名称
	 */
	
	public function getPersonList(){
		
		$result = $this->getEntityManager()->createQuery(
													"SELECT p.id,p.realname,p.position,p.insertTime,
															s.name as schoolName
													 FROM EvaluationCommonBundle:EvaluatedPerson p,
													 	  EvaluationCommonBundle:EvaluateSchool s
													 WHERE  p.schoolId = s.id"
											)->getArrayResult();
		
		return $result;
	}
	
	
	
}

<?php

namespace Msg\MessagerieBundle\Repository;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
	public function findBydDiscAndMsg($discussionId, $idLastMsg){
		$qb = $this->_em->createQueryBuilder();
		$qb->select('m')
		->from('MsgMessagerieBundle:Message', 'm')
		->where('m.discussion = :discussionId')
		->setParameter('discussionId', $discussionId)
		->andWhere('m.id > :idLastMsg')
		->setParameter('idLastMsg', $idLastMsg);
		return $qb->getQuery()
		->getResult();
	}
}

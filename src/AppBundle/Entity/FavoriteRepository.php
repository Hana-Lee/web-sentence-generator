<?php
/**
 * Created by PhpStorm.
 * User: Hana Lee
 * Date: 2015-08-25
 * Time: 12:16
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class FavoriteRepository extends EntityRepository
{
    public function getCountByParentId($parentId)
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(f)")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.parentId = :parentId")
            ->setParameters(array("enabled" => 1, "parentId" => $parentId))
            ->getQuery()->getSingleScalarResult();

        return $count;
    }

    public function getCountByRate($rate)
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(f)")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.rate = :rate")
            ->setParameters(array("enabled" => 1, "rate" => $rate))
            ->getQuery()->getSingleScalarResult();

        return $count;
    }

    public function findByRate($rate)
    {
        $favorites = $this->getEntityManager()->createQueryBuilder()
            ->select("f")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.rate = :rate")
            ->setParameters(array("enabled" => 1, "rate" => $rate))
            ->orderBy("f.created", "DESC")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$favorites) {
            return array();
        } else {
            return $favorites;
        }
    }

    public function findByParentId($parentId)
    {
        $favorites = $this->getEntityManager()->createQueryBuilder()
            ->select("f")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.parentId = :parentId")
            ->setParameters(array("enabled" => 1, "parentId" => $parentId))
            ->orderBy("f.created", "DESC")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$favorites) {
            return array();
        } else {
            return $favorites;
        }
    }
}
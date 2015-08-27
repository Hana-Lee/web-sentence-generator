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

        if (!$count) {
            $count = 0;
        }

        return $count;
    }

    public function getCountByRate($rate)
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(f)")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.rate = :rate")
            ->setParameters(array("enabled" => 1, "rate" => $rate))
            ->getQuery()->getSingleScalarResult();

        if (!$count) {
            $count = 0;
        }

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
            $favorites = array();
        }

        return $favorites;
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
            $favorites = array();
        }

        return $favorites;
    }

    public function create($newValue, $parentId, $genreType, $created)
    {
        $newFavorite = new Favorite();
        $newFavorite->setSentence($newValue);
        $newFavorite->setParentId($parentId);
        $newFavorite->setGenreType($genreType);
        $newFavorite->setEnabled(1);
        $newFavorite->setBackup(0);
        $newFavorite->setRate(1);
        $newFavorite->setCreated($created);
        $newFavorite->setModified(0);

        $this->getEntityManager()->persist($newFavorite);
        $this->getEntityManager()->flush();

        return $newFavorite;
    }

    public function updateRate($id, $rate)
    {
        $favorite = $this->find($id);
        $favorite->setRate($rate);

        $this->getEntityManager()->flush();
    }

    public function updateParentId($id, $parentId)
    {
        $favorite = $this->find($id);
        $favorite->setParentId($parentId);

        $this->getEntityManager()->flush();
    }

    public function delete($id)
    {
        $favorite = $this->find($id);
        $favorite->setEnabled(0);
        $favorite->setModified(1);

//        $this->getEntityManager()->remove($favorite);
        $this->getEntityManager()->flush();
    }
}
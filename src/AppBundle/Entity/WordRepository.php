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

class WordRepository extends EntityRepository
{
    public function findByWordTypeAndGenreType($wordType, $genreType)
    {
        $words = $this->getEntityManager()->createQueryBuilder()
            ->select("w")
            ->from("AppBundle:Word", "w")
            ->where("w.wordType = :wordType")->andWhere("w.genreType = :genreType")->andWhere("w.enabled = :enabled")
            ->orderBy("w.word", "ASC")->addOrderBy("w.created", "DESC")
            ->setParameters(array("wordType" => $wordType, "genreType" => $genreType, "enabled" => 1))
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$words) {
            $words = array();
        }

        return $words;
    }

    public function findByWordType($wordType)
    {
        $words = $this->getEntityManager()->createQueryBuilder()
            ->select("w")
            ->from("AppBundle:Word", "w")
            ->where("w.wordType = :wordType")->andWhere("w.enabled = :enabled")
            ->orderBy("w.word", "ASC")->addOrderBy("w.created", "DESC")
            ->setParameters(array("wordType" => $wordType, "enabled" => 1))
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$words) {
            $words = array();
        }

        return $words;
    }

    public function getCount()
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(w)")
            ->from("AppBundle:Word", "w")->where("w.enabled = :enabled")
            ->setParameter("enabled", 1)
            ->getQuery()->getSingleScalarResult();

        if (!$count) {
            $count = 0;
        }

        return $count;
    }

    public function getCountByGenreType($genreType)
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(w)")
            ->from("AppBundle:Word", "w")
            ->where("w.genreType = :genreType")->andWhere("w.enabled = :enabled")
            ->setParameters(array("genreType" => $genreType, "enabled" => 1))
            ->getQuery()->getSingleScalarResult();

        if (!$count) {
            $count = 0;
        }

        return $count;
    }

    public function create($wordType, $genreType, $newValue, $created)
    {
        $newWord = new Word();
        $newWord->setWordType($wordType);
        $newWord->setWord($newValue);
        $newWord->setGenreType($genreType);
        $newWord->setBackup(0);
        $newWord->setCreated($created);
        $newWord->setModified(0);
        $newWord->setEnabled(1);

        $this->getEntityManager()->persist($newWord);
        $this->getEntityManager()->flush();

        return $newWord;
    }

    public function getCountByWordTypeAndGenreType($wordType, $genreType)
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(w)")
            ->from("AppBundle:Word", "w")
            ->where("w.wordType = :wordType")->andWhere("w.genreType = :genreType")->andWhere("w.enabled = :enabled")
            ->setParameters(array("wordType" => $wordType, "genreType" => $genreType, "enabled" => 1))
            ->getQuery()->getSingleScalarResult();

        if (!$count) {
            $count = 0;
        }

        return $count;
    }

    public function update($id, $newValue)
    {
        $word = $this->find($id);
        $word->setWord($newValue);
        $word->setModified(1);

        $this->getEntityManager()->flush();

        return $word;
    }

    public function delete($params)
    {
        $word = $this->find($params["id"]);
        $word->setEnabled(0);
        $word->setModified(1);

//        $this->getEntityManager()->remove($word);
        $this->getEntityManager()->flush();
    }
}

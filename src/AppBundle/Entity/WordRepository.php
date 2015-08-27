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
            ->where("w.wordType = :wordType")->andWhere("w.genreType = :genreType")
            ->orderBy("w.word", "ASC")->addOrderBy("w.created", "DESC")
            ->setParameters(array("wordType" => $wordType, "genreType" => $genreType))
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
            ->where("w.wordType = :wordType")
            ->orderBy("w.word", "ASC")->addOrderBy("w.created", "DESC")
            ->setParameter("wordType", $wordType)
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
            ->from("AppBundle:Word", "w")
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
            ->from("AppBundle:Word", "w")->where("w.genreType = :genreType")
            ->setParameter("genreType", $genreType)
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

        $this->getEntityManager()->persist($newWord);
        $this->getEntityManager()->flush();

        return $newWord;
    }

    public function getCountByWordTypeAndGenreType($wordType, $genreType)
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(w)")
            ->from("AppBundle:Word", "w")
            ->where("w.wordType = :wordType")->andWhere("w.genreType = :genreType")
            ->setParameters(array("wordType" => $wordType, "genreType" => $genreType))
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

    public function delete($id)
    {
        $word = $this->find($id);
        $word->setEnabled(0);

//        $this->getEntityManager()->remove($word);
        $this->getEntityManager()->flush();
    }
}

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

        return $words;
    }

    public function getCountByGenreType($genreType)
    {
        $count = $this->getEntityManager()->createQueryBuilder()
            ->select("count(w)")
            ->from("AppBundle:Word", "w")->where("w.genreType = :genreType")
            ->setParameter("genreType", $genreType)
            ->getQuery()->getSingleScalarResult();

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

        $this->getEntityManager()->persist($newWord);
        $this->getEntityManager()->flush();

        return $newWord;
    }
}

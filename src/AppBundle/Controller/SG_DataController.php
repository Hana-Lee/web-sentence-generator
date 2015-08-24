<?php
/**
 * Created by PhpStorm.
 * User: Hana
 * Date: 2015-08-21
 * Time: 오전 12:09
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\Query;

use AppBundle\Entity\Word;

class SG_DataController extends Controller
{
    const WORD_NOUN = 0;
    const WORD_VERB = 1;
    const WORD_ADVERB = 2;
    const WORD_ADJECTIVE = 3;

    const GENRE_POETRY = 0;
    const GENRE_NURSERY_RIME = 1;
    const GENRE_NOVEL = 2;
    const GENRE_ESSAY = 3;
    const GENRE_FAIRY_TAIL = 4;
    const GENRE_ETC = 5;

    const FAV_NAME = 0;
    const FAV_RATE = 1;

    /**
     * @Route("/get/word/{wordType}/{genreType}", defaults={"wordType" : 0, "genreType" : 0})
     *
     * @param $wordType
     * @param $genreType
     * @return Response
     */
    public function wordAction($wordType, $genreType)
    {
        $wordList = $this->fetchWordListByTypeAndGenre($wordType, $genreType);

        return new Response(json_encode($wordList));
    }

    /**
     * @Route("/get/word/count/genre", defaults={"genreType" = 0})
     * @Route("/get/word/count/genre/{genreType}")
     *
     * @param $genreType
     * @return Response
     */
    public function genreCountAction($genreType)
    {
        $genreCount = $this->fetchGenreCount($genreType);

        return new Response($genreCount);
    }

    /**
     * @Route("/get/favorite/count", defaults={"favoriteType" = 0})
     * @Route("/get/favorite/count/{favoriteType}")
     *
     * @param $favoriteType
     * @return Response
     */
    public function favoriteCount($favoriteType)
    {
        if ($favoriteType == self::FAV_NAME)
        {
            $favoriteCount = $this->fetchFavoriteCountByName();
        }
        else
        {
            $favoriteCount = $this->fetchFavoriteCountByRate();
        }

        return new Response($favoriteCount);
    }

    /**
     * @Route("/add/word/{wordType}/{genreType}/{newWord}/{created}")
     *
     * @param $wordType
     * @param $genreType
     * @param $newWord
     * @param $created
     * @return Response
     */
    public function addNewWord($wordType, $genreType, $newWord, $created)
    {
        $addResult = $this->addNewWordToDatabase($wordType, $genreType, $newWord, $created);
        $serializer = new Serializer($this->getManager());
        $newWordArray = $serializer->serialize($addResult);
        return new Response(json_encode($newWordArray));
    }

    private function objectToArrayConvert($targetObject)
    {
        $newArray = array();
        $nValue = get_object_vars($targetObject);
        $nValue = (array) $targetObject;
        foreach ($targetObject as $key => $value)
        {
            $newArray[$key] = $value;
        }

        return $newArray;
    }

    private function fetchWordListByTypeAndGenre($wordType, $genreType)
    {
        $words = $this->getManager()->createQueryBuilder()
            ->select("w")
            ->from("AppBundle:Word", "w")->where("w.wordType = :wordType")->andWhere("w.genreType = :genreType")
            ->orderBy("w.word", "ASC")->addOrderBy("w.created", "DESC")
            ->setParameters(array("wordType" => $wordType, "genreType" => $genreType))
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        if (!$words) {
            throw $this->createNotFoundException(
                "No Words found for word type : " . $wordType
            );
        } else {
            return $words;
        }
    }

    private function fetchGenreCount($genreType)
    {
        $count = $this->getManager()->createQueryBuilder()
            ->select("count(w)")
            ->from("AppBundle:Word", "w")->where("w.genreType = :genreType")->setParameter("genreType", $genreType)
            ->getQuery()->getSingleScalarResult();

        return $count;
    }

    private function getManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    private function fetchFavoriteCountByName()
    {
        $count = $this->getManager()->createQueryBuilder()
            ->select("count(fc)")
            ->from("AppBundle:FavoriteCategory", "fc")->where("fc.enabled = :enabled")->setParameter("enabled", 1)
            ->getQuery()->getSingleScalarResult();

        return $count;
    }

    private function fetchFavoriteCountByRate()
    {
        $count = $this->getManager()->createQueryBuilder()
            ->select("count(f)")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->setParameter("enabled", 1)
            ->getQuery()->getSingleScalarResult();

        return $count;
    }

    private function addNewWordToDatabase($wordType, $genreType, $newWord, $created)
    {
        $newWordObj = new Word();
        $newWordObj->setWord($newWord);
        $newWordObj->setCreated($created);
        $newWordObj->setBackup(0);
        $newWordObj->setGenreType($genreType);
        $newWordObj->setWordType($wordType);

        $this->getManager()->persist($newWordObj);
        $this->getManager()->flush();

        return $newWordObj;
    }
}

/**
 * Class Serializer
 *
 * @author Steffen Brem
 * @link <a href="http://stackoverflow.com/a/17503598">
 */
class Serializer
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $_em;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->_em = $em;
    }

    /**
     * Serialize entity to array
     *
     * @param $entityObject
     * @return array
     */
    public function serialize($entityObject)
    {
        $data = array();

        $className = get_class($entityObject);
        $metaData = $this->_em->getClassMetadata($className);

        foreach ($metaData->fieldMappings as $field => $mapping)
        {
            $method = "get" . ucfirst($field);
            $data[$field] = call_user_func(array($entityObject, $method));
        }

        foreach ($metaData->associationMappings as $field => $mapping)
        {
            // Sort of entity object
            $object = $metaData->reflFields[$field]->getValue($entityObject);

            $data[$field] = $this->serialize($object);
        }

        return $data;
    }
}
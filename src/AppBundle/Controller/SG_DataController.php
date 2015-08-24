<?php
/**
 * Created by PhpStorm.
 * User: Hana
 * Date: 2015-08-21
 * Time: 오전 12:09
 */
namespace AppBundle\Controller;

use Proxies\__CG__\AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\Query;

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
     * @Route("/get/word/{wordType}/{genreType}")
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
     * @Route("/get/favorite/rate/count/{rate}")
     *
     * @param $rate
     * @return Response
     */
    public function favoriteRateItemCountAction($rate)
    {
        $favoriteCount = $this->fetchFavoriteCountByRate($rate);

        return new Response($favoriteCount);
    }

    /**
     * @Route("/get/favorite/category/item/count/{categoryId}")
     *
     * @param $categoryId
     * @return Response
     */
    public function favoriteCategoryItemCountAction($categoryId)
    {
        $favoriteCategoryItemCount = $this->fetchFavoriteCategoryItemCountById($categoryId);

        return new Response($favoriteCategoryItemCount);
    }

    /**
     * @Route("/get/favorite/category")
     *
     * @return Response
     */
    public function favoriteCategoryAction() {
        $fetchResult = $this->fetchFavoriteCategory();

        return new Response(json_encode($fetchResult));
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
    public function addNewWordAction($wordType, $genreType, $newWord, $created)
    {
        $addResult = $this->addNewWordToDatabase($wordType, $genreType, $newWord, $created);
        $serializer = new Serializer($this->getManager());
        $newWordArray = $serializer->serialize($addResult);
        return new Response(json_encode($newWordArray));
    }

    /**
     * @Route("/get/favorite/rate/item/{rate}")
     *
     * @param $rate
     * @return Response
     */
    public function favoriteItemByRateAction($rate)
    {
        $favoriteRateItemResult = $this->fetchFavoriteItemByRate($rate);

        return new Response(json_encode($favoriteRateItemResult));
    }

    /**
     * @Route("/get/favorite/item/{categoryId}")
     *
     * @param $categoryId
     * @return Response
     */
    public function favoriteItemByCategoryIdAction($categoryId)
    {
        $favoriteItemResult = $this->fetchFavoriteItemByCategoryId($categoryId);

        return new Response(json_encode($favoriteItemResult));
    }

    private function fetchWordListByTypeAndGenre($wordType, $genreType)
    {
        $words = $this->getManager()->createQueryBuilder()
            ->select("w")
            ->from("AppBundle:Word", "w")->where("w.wordType = :wordType")->andWhere("w.genreType = :genreType")
            ->orderBy("w.word", "ASC")->addOrderBy("w.created", "DESC")
            ->setParameters(array("wordType" => $wordType, "genreType" => $genreType))
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        if (!$words)
        {
            return array();
        }
        else
        {
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

    private function fetchFavoriteCategoryItemCountById($categoryId)
    {
        $count = $this->getManager()->createQueryBuilder()
            ->select("count(f)")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.parentId = :parentId")
            ->setParameters(array("enabled" => 1, "parentId" => $categoryId))
            ->getQuery()->getSingleScalarResult();

        return $count;
    }

    private function fetchFavoriteCountByRate($rate)
    {
        $count = $this->getManager()->createQueryBuilder()
            ->select("count(f)")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.rate = :rate")
            ->setParameters(array("enabled" => 1, "rate" => $rate))
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

    private function fetchFavoriteCategory()
    {
        $favoriteCategories = $this->getManager()->createQueryBuilder()
            ->select("fc")
            ->from("AppBundle:FavoriteCategory", "fc")->where("fc.enabled = :enabled")
            ->setParameter("enabled", 1)
            ->orderBy("fc.created", "DESC")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$favoriteCategories)
        {
            return array();
        }
        else
        {
            return $favoriteCategories;
        }
    }

    private function fetchFavoriteItemByRate($rate)
    {
        $favoriteRateItem = $this->getManager()->createQueryBuilder()
            ->select("f")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.rate = :rate")
            ->setParameters(array("enabled" => 1, "rate" => $rate))
            ->orderBy("f.created", "DESC")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$favoriteRateItem)
        {
            return array();
        }
        else
        {
            return $favoriteRateItem;
        }
    }

    private function fetchFavoriteItemByCategoryId($categoryId)
    {
        $favoriteItem = $this->getManager()->createQueryBuilder()
            ->select("f")
            ->from("AppBundle:Favorite", "f")->where("f.enabled = :enabled")->andWhere("f.parentId = :parentId")
            ->setParameters(array("enabled" => 1, "parentId" => $categoryId))
            ->orderBy("f.created", "DESC")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$favoriteItem)
        {
            return array();
        }
        else
        {
            return $favoriteItem;
        }
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
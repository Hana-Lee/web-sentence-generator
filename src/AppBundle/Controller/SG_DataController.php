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
     *
     * @return Response
     */
    public function wordAction($wordType, $genreType)
    {
        $wordArray = $this->getWordRepository()->findByWordTypeAndGenreType($wordType, $genreType);

        return new Response(json_encode($wordArray));
    }

    /**
     * @Route("/get/word/count/genre/{genreType}")
     *
     * @param $genreType
     *
     * @return Response
     */
    public function genreCountAction($genreType)
    {
        $genreCount = $this->getWordRepository()->getCountByGenreType($genreType);

        return new Response($genreCount);
    }

    /**
     * @Route("/get/favorite/rate/count/{rate}")
     *
     * @param $rate
     *
     * @return Response
     */
    public function favoriteCountByRateAction($rate)
    {
        $favoriteCount = $this->getFavoriteRepository()->getCountByRate($rate);

        return new Response($favoriteCount);
    }

    /**
     * @Route("/get/favorite/category/item/count/{categoryId}")
     *
     * @param $categoryId
     *
     * @return Response
     */
    public function favoriteCountByParentIdAction($categoryId)
    {
        $favoriteCount = $this->getFavoriteRepository()->getCountByParentId($categoryId);

        return new Response($favoriteCount);
    }

    /**
     * @Route("/get/favorite/category")
     *
     * @return Response
     */
    public function favoriteCategoryAction() {
        $favoriteCategoryArray = $this->getFavoriteCategoryRepository()->findByEnabled();

        return new Response(json_encode($favoriteCategoryArray));
    }

    /**
     * @Route("/new/word/{wordType}/{genreType}/{newValue}/{created}")
     *
     * @param $wordType
     * @param $genreType
     * @param $newValue
     * @param $created
     *
     * @return Response
     */
    public function newWordAction($wordType, $genreType, $newValue, $created)
    {
        $newWord = $this->getWordRepository()->create($wordType, $genreType, $newValue, $created);

        $serializer = new Serializer($this->getDoctrine()->getEntityManager());
        $newWordArray = $serializer->serialize($newWord);

        return new Response(json_encode($newWordArray));
    }

    /**
     * @Route("/get/favorite/rate/item/{rate}")
     *
     * @param $rate
     *
     * @return Response
     */
    public function favoritesByRateAction($rate)
    {
        $favoriteArray = $this->getFavoriteRepository()->findByRate($rate);

        return new Response(json_encode($favoriteArray));
    }

    /**
     * @Route("/get/favorite/item/{categoryId}")
     *
     * @param $categoryId
     *
     * @return Response
     */
    public function favoritesByCategoryIdAction($categoryId)
    {
        $favoriteArray = $this->getFavoriteRepository()->findByParentId($categoryId);

        return new Response(json_encode($favoriteArray));
    }

    /**
     * @Route("/get/word/count/type/{wordType}/genre/{genreType}")
     *
     * @param $wordType
     * @param $genreType
     *
     * @return Response
     */
    public function wordCountByWordTypeAndGenreTypeAction($wordType, $genreType)
    {
        $count = $this->getWordRepository()->getCountByWordTypeAndGenreType($wordType, $genreType);

        return new Response($count);
    }

    private function getWordRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository("AppBundle:Word");
    }

    private function getFavoriteRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository("AppBundle:Favorite");
    }

    private function getFavoriteCategoryRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository("AppBundle:FavoriteCategory");
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
<?php
/**
 * Created by PhpStorm.
 * User: Hana
 * Date: 2015-08-21
 * Time: 오전 12:09
 */
namespace AppBundle\Controller;

use AppBundle\Model\Constants;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\Query;

use AppBundle\Entity\Word;

class SG_DataController extends Controller
{
    /**
     * @Route("/get/word", defaults={"wordType" = 1})
     * @Route("/get/word/{wordType}")
     *
     * @param $wordType
     * @return Response
     */
    public function numberAction($wordType)
    {
        $wordList = $this->fetchWordListByType($wordType);

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
     * @Route("/get/favorite/count/{$favoriteType}")
     *
     * @param $favoriteType
     * @return Response
     */
    public function favoriteCount($favoriteType)
    {
        if ($favoriteType == 0)
        {
            $favoriteCount = $this->fetchFavoriteCountByName();
        }
        else
        {
            $favoriteCount = $this->fetchFavoriteCountByRate();
        }

        return new Response($favoriteCount);
    }

    private function fetchWordListByType($wordType)
    {
        $words = $this->getManager()->createQueryBuilder()
            ->select("w")
            ->from("AppBundle:Word", "w")->where("w.wordType = :wordType")->setParameter("wordType", $wordType)
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
}
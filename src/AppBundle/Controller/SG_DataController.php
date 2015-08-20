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
    /**
     * @Route("/get/word", defaults={"wordType" = 1})
     * @Route("/get/word/{wordType}")
     */
    public function numberAction($wordType)
    {
        $wordList = $this->showAction($wordType);

        return new Response(json_encode($wordList));
    }

    public function showAction($wordType) {

        $repository = $this->getDoctrine()->getRepository("AppBundle:Word");

        $manager = $this->getDoctrine()->getEntityManager();
        $words = $repository->createQueryBuilder("w")
            ->where("w.wordType = :wordType")->setParameter("wordType", $wordType)
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$words) {
            throw $this->createNotFoundException(
                "No Words found for word type : " . $wordType
            );
        } else {
            return $words;
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Hana
 * Date: 2015-08-25
 * Time: 12:14
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class FavoriteCategoryRepository extends EntityRepository
{
    public function findByEnabled()
    {
        $favoriteCategories = $this->getEntityManager()->createQueryBuilder()
            ->select("fc")
            ->from("AppBundle:FavoriteCategory", "fc")->where("fc.enabled = :enabled")
            ->setParameter("enabled", 1)
            ->orderBy("fc.created", "DESC")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if (!$favoriteCategories) {
            return array();
        } else {
            return $favoriteCategories;
        }
    }
}

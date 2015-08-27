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
            $favoriteCategories = array();
        }

        return $favoriteCategories;
    }

    public function create($name, $created, $genreType)
    {
        $newFavoriteCategory = new FavoriteCategory();
        $newFavoriteCategory->setName($name);
        $newFavoriteCategory->setRate(1);
        $newFavoriteCategory->setCreated($created);
        $newFavoriteCategory->setBackup(0);
        $newFavoriteCategory->setEnabled(1);
        $newFavoriteCategory->setGenreType($genreType);
        $newFavoriteCategory->setModified(0);

        $this->getEntityManager()->persist($newFavoriteCategory);
        $this->getEntityManager()->flush();

        return $newFavoriteCategory;
    }

    public function updateName($id, $categoryName)
    {
        $favoriteCategory = $this->find($id);
        $favoriteCategory->setName($categoryName);

        $this->getEntityManager()->flush();
    }

    public function delete($id)
    {
        $favoriteCategory = $this->find($id);
        $favoriteCategory->setEnabled(0);
        $favoriteCategory->setModified(1);

        $this->getEntityManager()->flush();
    }
}

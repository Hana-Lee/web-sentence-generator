<?php
/**
 * Created by PhpStorm.
 * User: Hana
 * Date: 2015-08-21
 * Time: 20:21
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sg_favorite")
 */
class Favorite
{
    /**
     * @ORM\Column(name="_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="parent", type="integer")
     */
    protected $parentId;

    /**
     * @ORM\Column(type="text")
     */
    protected $sentence;

    /**
     * @ORM\Column(name="genre", type="integer")
     */
    protected $genreType;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $enabled;

    /**
     * @ORM\Column(type="text")
     */
    protected $created;

    /**
     * @ORM\Column(type="integer")
     */
    protected $backup;
}
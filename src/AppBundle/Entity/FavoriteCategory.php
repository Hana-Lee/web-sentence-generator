<?php
/**
 * Created by PhpStorm.
 * User: Hana
 * Date: 2015-08-21
 * Time: 오전 12:22
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FavoriteCategoryRepository")
 * @ORM\Table(name="sg_fav_cate")
 */
class FavoriteCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="genre", type="integer")
     */
    private $genreType;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $created;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $backup;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $modified;

    /**
     * Get Favorite category ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Favorite category name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Favorite category name
     *
     * @param string $name
     * @return FavoriteCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get genre type
     *
     * @return integer
     */
    public function getGenreType()
    {
        return $this->genreType;
    }

    /**
     * Set genre type
     *
     * @param integer $genreType
     * @return FavoriteCategory
     */
    public function setGenreType($genreType)
    {
        $this->genreType = $genreType;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     * @return FavoriteCategory
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return integer
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     * @return FavoriteCategory
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get created timestamp
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created timestamp
     *
     * @param string $created
     * @return FavoriteCategory
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get backup
     *
     * @return integer
     */
    public function getBackup()
    {
        return $this->backup;
    }

    /**
     * Set backup
     *
     * @param integer $backup
     * @return FavoriteCategory
     */
    public function setBackup($backup)
    {
        $this->backup = $backup;

        return $this;
    }

    /**
     * Get modified
     *
     * @return integer
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set modified
     *
     * @param integer $modified
     * @return FavoriteCategory
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }
}
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
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FavoriteRepository")
 * @ORM\Table(name="sg_favorite")
 */
class Favorite
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
     * @var integer
     *
     * @ORM\Column(name="parent", type="integer")
     */
    private $parentId;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $sentence;

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
     * Get favorite ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get parent ID
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set parent ID
     *
     * @param integer $parentId
     * @return Favorite
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get sentence
     *
     * @return string
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * Set sentence
     *
     * @param string $sentence
     * @return Favorite
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;

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
     * @return Favorite
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
     * @return Favorite
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
     * @return Favorite
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
     * Set create timestamp
     *
     * @param string $created
     * @return Favorite
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
     * @return Favorite
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
     * @return Favorite
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }
}
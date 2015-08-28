<?php
/**
 * Created by PhpStorm.
 * User: Hana Lee
 * Date: 2015-08-28
 * Time: 20:15
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SettingRepository")
 * @ORM\Table(name="sg_setting")
 */
class Setting
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
     * @ORM\Column(name="sentence_count", type="integer")
     */
    private $sentenceCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="first_type", type="integer")
     */
    private $firstType;

    /**
     * @var integer
     *
     * @ORM\Column(name="second_type", type="integer")
     */
    private $secondType;

    /**
     * @var integer
     *
     * @ORM\Column(name="third_type", type="integer")
     */
    private $thirdType;

    /**
     * @var integer
     *
     * @ORM\Column(name="fourth_type", type="integer")
     */
    private $fourthType;

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
     * Get sentence generate count
     *
     * @return integer
     */
    public function getSentenceCount()
    {
        return $this->sentenceCount;
    }

    /**
     * Set sentence generate count
     *
     * @param integer $sentenceCount
     * @return Setting
     */
    public function setSentenceCount($sentenceCount)
    {
        $this->sentenceCount = $sentenceCount;

        return $this;
    }

    /**
     * Get first word type
     *
     * @return integer
     */
    public function getFirstType()
    {
        return $this->firstType;
    }

    /**
     * Set first word type
     *
     * @param integer $firstType
     * @return Setting
     */
    public function setFirstType($firstType)
    {
        $this->firstType = $firstType;

        return $this;
    }

    /**
     * Get second word type
     *
     * @return integer
     */
    public function getSecondType()
    {
        return $this->secondType;
    }

    /**
     * Set second word type
     *
     * @param integer $secondType
     * @return Setting
     */
    public function setSecondType($secondType)
    {
        $this->secondType = $secondType;

        return $this;
    }

    /**
     * Get third word type
     *
     * @return integer
     */
    public function getThirdType()
    {
        return $this->thirdType;
    }

    /**
     * Set third word type
     *
     * @param integer $thirdType
     * @return Setting
     */
    public function setThirdType($thirdType)
    {
        $this->thirdType = $thirdType;

        return $this;
    }

    /**
     * Get fourth word type
     *
     * @return integer
     */
    public function getFourthType()
    {
        return $this->fourthType;
    }

    /**
     * Set fourth word type
     *
     * @param integer $fourthType
     * @return Setting
     */
    public function setFourthType($fourthType)
    {
        $this->fourthType = $fourthType;

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
     * @return Setting
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
     * @return Setting
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
     * @return Setting
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }
}
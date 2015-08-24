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
 * @ORM\Entity
 * @ORM\Table(name="sg_word")
 */
class Word
{
    /**
     * @ORM\Column(name="_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $word;

    /**
     * @ORM\Column(name="type", type="integer")
     */
    protected $wordType;

    /**
     * @ORM\Column(name="genre", type="integer")
     */
    protected $genreType;

    /**
     * @ORM\Column(type="text")
     */
    protected $created;

    /**
     * @ORM\Column(type="integer")
     */
    protected $backup;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }

    /**
     * @return mixed
     */
    public function getWordType()
    {
        return $this->wordType;
    }

    /**
     * @param mixed $wordType
     */
    public function setWordType($wordType)
    {
        $this->wordType = $wordType;
    }

    /**
     * @return mixed
     */
    public function getGenreType()
    {
        return $this->genreType;
    }

    /**
     * @param mixed $genreType
     */
    public function setGenreType($genreType)
    {
        $this->genreType = $genreType;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getBackup()
    {
        return $this->backup;
    }

    /**
     * @param mixed $backup
     */
    public function setBackup($backup)
    {
        $this->backup = $backup;
    }


}
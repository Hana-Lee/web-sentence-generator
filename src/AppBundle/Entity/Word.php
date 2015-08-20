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
}
<?php
/**
 * Created by PhpStorm.
 * User: flackovic
 * Date: 26/08/2018
 * Time: 19:37
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class School
 * @ORM\Entity()
 */
class School extends Organization
{
    /**
     * @Assert\Type(type="App\Entity\SchoolNetwork")
     */
    protected $parent;

    /**
     * @Assert\IsNull()
     */
    protected $children = null;
}
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
 * Class District
 * @ORM\Entity()
 */
class District extends Organization
{
    /**
     * @Assert\IsNull()
     */
    protected $parent = null;

    /**
     * @Assert\All({
     *     @Assert\Type(type="App\Entity\SchoolNetwork")
     * })
     */
    protected $children;
}
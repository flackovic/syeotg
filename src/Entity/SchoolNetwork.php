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
 * Class SchoolNetwork
 * @ORM\Entity()
 */
class SchoolNetwork extends Organization
{
    /**
     * @Assert\Type(type="App\Entity\District")
     */
    protected $parent;

    /**
     * @Assert\All({
     *     @Assert\Type(type="App\Entity\School")
     * })
     */
    protected $children;
}
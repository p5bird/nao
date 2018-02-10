<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/6/18
 * Time: 5:42 PM
 */

namespace UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="nao_group")
 */
class Group extends BaseGroup {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}

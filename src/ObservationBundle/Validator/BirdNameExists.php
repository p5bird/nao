<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BirdNameExists extends Constraint
{
  public $message = "Ce nom d'oiseau est inconnu => corrigez le ou cochez la case inconnu";
}
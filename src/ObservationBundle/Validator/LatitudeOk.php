<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class LatitudeOk extends Constraint
{
  public $message = "Cette latitude est invalide";
}
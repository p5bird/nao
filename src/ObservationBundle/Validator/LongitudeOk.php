<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class LongitudeOk extends Constraint
{
  public $message = "Cette longitude est invalide";
}
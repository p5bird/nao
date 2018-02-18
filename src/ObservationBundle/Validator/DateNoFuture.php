<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DateNoFuture extends Constraint
{
  public $message = "Cette date est invalide";
}
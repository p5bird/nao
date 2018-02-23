<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CopyrightFreeRequired extends Constraint
{
  public $message = "Vous devez céder vos droits pour ajouter une image.";

  public function getTargets()
  {
  	return self::CLASS_CONSTRAINT;
  }
}
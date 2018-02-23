<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class LatitudeOkValidator extends ConstraintValidator
{
	public function validate($latitude, Constraint $constraint)
	{	
		if (!preg_match("/^[-]?(([0-8]?[0-9])(\.(\d+))?)|(90(\.0+)?)$/", $latitude))
		{
			$this->context
				->buildViolation($constraint->message)
				->addViolation();
			return;
		}
	}
}
<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class LongitudeOkValidator extends ConstraintValidator
{
	public function validate($longitude, Constraint $constraint)
	{	
		if (!preg_match("/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/", $longitude))
		{
			$this->context
				->buildViolation($constraint->message)
				->addViolation();
			return;
		}
	}
}
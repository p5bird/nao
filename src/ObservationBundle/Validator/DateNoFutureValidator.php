<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class DateNoFutureValidator extends ConstraintValidator
{
	public function validate($date, Constraint $constraint)
	{	
		if ($date > new \DateTime('now'))
		{
			$this->context
				->buildViolation($constraint->message)
				->addViolation();
			return;
		}
	}
}
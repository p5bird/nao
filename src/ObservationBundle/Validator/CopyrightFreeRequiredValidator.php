<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;
use ObservationBundle\Entity\Image;


class CopyrightFreeRequiredValidator extends ConstraintValidator
{
	public function validate($image, Constraint $constraint)
	{	
		if (!is_null($image->getImageFile()) and !$image->getAuthorization())
		{
			$this->context->buildViolation($constraint->message)
				->atPath('authorization')
				->addViolation();
		}
	}
}
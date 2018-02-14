<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;


class BirdNameExistsValidator extends ConstraintValidator
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function validate($birdName, Constraint $constraint)
	{	
		$taxons = $this->entityManager
			->getRepository('ObservationBundle:Taxon')
			->findByNameVern($birdName);
		if (empty($taxons) or empty($taxons[0]))
		{
			$this->context->addViolation($constraint->message);
		}
	}
}
<?php

namespace ObservationBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;
use ObservationBundle\Entity\Observation;


class BirdNameExistsValidator extends ConstraintValidator
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function validate($observation, Constraint $constraint)
	{	
		$taxon = $this->entityManager
			->getRepository('ObservationBundle:Taxon')
			->findByNameVern($observation->getBirdName());
		if (is_null($taxon) and !$observation->getNoName())
		{
			$this->context->buildViolation($constraint->message)
				->atPath('birdName')
				->addViolation();
		}
	}
}
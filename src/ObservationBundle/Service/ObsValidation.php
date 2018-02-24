<?php

namespace ObservationBundle\Service;

use ObservationBundle\Entity\Validation;

class ObsValidation
{
	private $tokenStorage;
	private $entityManager;

	public function __construct($tokenStorage, $entityManager)
	{
		$this->tokenStorage = $tokenStorage;
		$this->entityManager = $entityManager;
	}

	public function setGranted($observation)
	{
		$user = $this->tokenStorage->getToken()->getUser();

        $validation = new Validation();
        $validation->setAuthor($user);
        $validation->setDate(new \DateTime());
        $validation->setGranted(true);
        $observation->setValidation($validation);

        return $observation;
	}
}
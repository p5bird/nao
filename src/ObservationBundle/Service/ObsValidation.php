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

	private function setValidation($observation = null)
	{
		if (!is_null($observation) and !is_null($observation->getValidation()))
		{
			$validation = $observation->getValidation();
		}
		else
		{
			$validation = new Validation();
		}

		$user = $this->tokenStorage->getToken()->getUser();
        $validation->setAuthor($user);
        $validation->setDate(new \DateTime());

        return $validation;
	}

	public function setGranted($observation)
	{
		$validation = $this->setValidation($observation);

        $validation->setGranted(true);
        $validation->setRejected(false);

        $observation->setValidation($validation);

        return $observation;
	}

	public function setRejected($observation)
	{
		$validation = $this->setValidation($observation);
        
        $validation->setRejected(true);
        $validation->setGranted(false);

        $observation->setValidation($validation);

        return $observation;
	}


	public function cancelValidation($observation)
	{
		$validation = $observation->getValidation();
		if (!is_null($validation))
		{
			$validation->setGranted(false);
        	$observation->setValidation($validation);
        }

        return $observation;
	}
}
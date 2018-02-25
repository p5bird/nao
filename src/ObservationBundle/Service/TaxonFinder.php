<?php

namespace ObservationBundle\Service;

class TaxonFinder
{

	private $entityManager;

	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function setTaxonToObservation($observation)
	{
		if (empty($observation->getBirdName()))
		{
			$observation->setTaxon(null);
			return $observation;
		}

	    $taxonRepository = $this->entityManager->getRepository('ObservationBundle:Taxon');
	    $taxon = $taxonRepository->findByNameVern($observation->getBirdName());
	    $observation->setTaxon($taxon);

        return $observation;
	}
}
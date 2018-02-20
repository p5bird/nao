<?php

namespace ObservationBundle\Service;

class SearchFiltered
{
	private $entityManager;

	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}



	public function searchObservations($search)
	{

		//

	}


	/**
	 * Query bird families names 
	 * and convert result to choice list standard
	 * @return array
	 */
	public function getBirdFamiliesChoices()
	{
		$families = $this
			->entityManager
			->getRepository('ObservationBundle:Taxon')
			->getFamilies()
		;

		return $this->convertToChoices($families);
	}


	/**
	 * Query bird orders names 
	 * and convert result to choice list standard
	 * @return array
	 */
	public function getBirdOrdersChoices()
	{
		$orders = $this
			->entityManager
			->getRepository('ObservationBundle:Taxon')
			->getOrders()
		;

		return $this->convertToChoices($orders);
	}

	/**
	 * Convert array from Repository Query to acceptable list choice form
	 * @param  array $array array to convert [[k=>v],[k=>v],[k=>v]]
	 * @return array 		array converted [k=>v,k=>v,k=>v] where k = v
	 */
	private function convertToChoices($array)
	{
		$arrayChoices = [];
		foreach ($array as $arrayChoice) {
			array_push($arrayChoices, $arrayChoice[key($arrayChoice)]);
		}

		$arrayChoices = array_flip($arrayChoices);
		foreach ($arrayChoices as $key => $value) {
			$arrayChoices[$key] = $key;
		}

		$defaultOption = ['' => 'notValid'];
		$arrayChoices = array_merge($defaultOption, $arrayChoices);

		return $arrayChoices;
	}
}
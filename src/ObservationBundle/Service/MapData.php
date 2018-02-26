<?php

namespace ObservationBundle\Service;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MapData
{

	private $entityManager;
	private $helper;
	private $router;

	public function __construct($entityManager,  $helper, $router)
	{
		$this->entityManager = $entityManager;
		$this->helper = $helper;
		$this->router = $router;
	}

	/**
	 * Use Google API to obtain locations informations for one geo location (lat,lng)
	 * @param  Entity\Observation $observation
	 * @return array  List of location infos
	 * street_number / route / locality / administrative_area_level_2 / administrative_area_level_1 / country / postal_code
	 */
	public function setMapMarkers($observations)
	{
		$obsJson = [];
        
		if (empty($observations))
		{
			return json_encode($obsJson);
		}

        foreach ($observations as $obs) {

            array_push($obsJson, [
                'id'        => $obs->getId(),
                'birdName'  => $obs->getBirdName(),
                'latitude'  => $obs->getLatitude(),
                'longitude' => $obs->getLongitude(),
                'obsUrl'       => $this->router->generate('nao_obs_show', ['id' => $obs->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                'nameValid'  => $obs->getTaxon()->getNameValid(),
                'date'       => $obs->getDay()->format('d/m/Y H:m'),
                'imageUrl'      => is_null($obs->getImage()) ? "default" : $this->helper->asset($obs->getImage(), 'imageFile'),
                'authorName' => $obs->getAuthor()->getUsername(),
                'authorUrl'   => $this->router->generate('nao_show_user', ['id' => $obs->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                'nbBirds'    => is_null($obs->getDescription()) ? 1 : is_null($obs->getDescription()->getNumber()) ? 1 : $obs->getDescription()->getNumber()  
            ]);
        }

        return json_encode($obsJson);
	}
}
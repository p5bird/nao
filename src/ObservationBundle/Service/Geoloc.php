<?php

namespace ObservationBundle\Service;

class Geoloc
{

	private $googleApiKey;

	public function __construct($googleApiKey)
	{
		$this->googleApiKey = $googleApiKey;
	}

	/**
	 * Use Google API to obtain locations informations for one geo location (lat,lng)
	 * @param  Entity\Observation $observation
	 * @return array  List of location infos
	 * street_number / route / locality / administrative_area_level_2 / administrative_area_level_1 / country / postal_code
	 */
	public function getLocationInfos($observation)
	{
        $query = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . 
            $observation->getLatAndLng() . "&key=" . $this->googleApiKey;
        $result = file_get_contents($query);
        $result = json_decode($result, true);

        $addressComponents = $result['results'][0]["address_components"];
        $locationInfos = [];
        foreach ($addressComponents as $componentKey => $componentValue) {
            $locationInfos[$componentValue['types'][0]] = $componentValue['long_name'];
        }
        return $locationInfos;
	}
}
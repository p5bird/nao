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

	public function setLocationInfos($observation)
	{
		$locationInfos = $this->getLocationInfos($observation);

		$address = "";
		if (array_key_exists('street_number', $locationInfos))
		{
			$address .= $locationInfos['street_number'];
		}
		if (array_key_exists('route', $locationInfos) and $locationInfos['route'] != 'Unnamed Road')
		{
			$address .= empty($address) ? "" : " ";
			$address .= $locationInfos['route'];
		}

		if (array_key_exists('locality', $locationInfos))
		{
			$observation->setLocLocality($locationInfos['locality']);
			$address .= empty($address) ? "" : ", ";
			$address .= $locationInfos['locality'];
		}

		if (array_key_exists('administrative_area_level_2', $locationInfos))
		{
			$observation->setLocCounty($locationInfos['administrative_area_level_2']);
		}

		if (array_key_exists('administrative_area_level_1', $locationInfos))
		{
			$observation->setLocRegion($locationInfos['administrative_area_level_1']);
		}

		if (array_key_exists('country', $locationInfos))
		{
			$observation->setLocCountry($locationInfos['country']);
			$address .= empty($address) ? "" : ", ";
			$address .= $locationInfos['country'];
		}

		if (array_key_exists('postal_code', $locationInfos))
		{
			$observation->setLocPostalCode($locationInfos['postal_code']);
		}

		if (!empty($address))
		{
			$observation->setLocAddress($address);
		}
		
		return $observation;
	}
}
<?php

namespace Avtonom\GeocoderBundle\Provider;

use Geocoder\Exception\NoResult;
use Geocoder\Exception\UnsupportedOperation;
use Geocoder\Provider\AbstractProvider;
use Geocoder\Provider\Provider;
use YamilovS\SypexGeoBundle\Manager\SypexGeoManager;

class SypexGeo extends AbstractProvider implements Provider
{
    /**
     * @var SypexGeoManager
     */
    private $sypexGeoManager;

    public function __construct($sypexGeoManager)
    {
        parent::__construct();
        $this->sypexGeoManager = $sypexGeoManager;
    }

    /**
     * {@inheritDoc}
     */
    public function geocode($address)
    {
        if (!filter_var($address, FILTER_VALIDATE_IP)) {
            throw new UnsupportedOperation('The SypexGeo provider does not support street addresses, only IPv4 addresses.');
        }

        if ('127.0.0.1' === $address) {
            return $this->returnResults([ $this->getLocalhostDefaults() ]);
        }

        $results = $this->sypexGeoManager->getCity($address);

        if (!is_array($results) || !array_key_exists('city', $results)) {
            throw new NoResult(sprintf('Could not find "%s" IP address in database.', $address));
        }

        return $this->returnResults([
            array_merge($this->getDefaults(), [
                'latitude'    => isset($results['city']['lat']) ? $results['city']['lat']: 0,
                'longitude'   => isset($results['city']['lon']) ? $results['city']['lon']: 0,
                'locality'   => isset($results['city']['name_ru']) ? $results['city']['name_ru']: null,
                'adminLevels'   => isset($results['region']['name_ru']) ? [['name' => $results['region']['name_ru'], 'code' => ( $results['region']['okato'] ? $results['region']['okato'] : null), 'level' => 1]] : [],
                'country'   => isset($results['country']['name_ru']) ? $results['country']['name_ru']: null,
            ])
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function reverse($latitude, $longitude)
    {
        throw new UnsupportedOperation('The SypexGeo provider is not able to do reverse geocoding.');
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sypex_geo';
    }
}

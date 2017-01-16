Geocoder Sypex-geo bundle for Symfony2 bundle for PHP
==================================================

Page bundle: https://github.com/Avtonom/geocoder-bundle

#### To Install

Run the following in your project root, assuming you have composer set up for your project

```sh

composer.phar require avtonom/geocoder-bundle ~1.1

```

Switching `~1.1` for the most recent tag.

Add the bundle to app/AppKernel.php

```php

$bundles(
    ...
            new Bazinga\Bundle\GeocoderBundle\BazingaGeocoderBundle(),
            new YamilovS\SypexGeoBundle\YamilovsSypexGeoBundle(),
            new Avtonom\GeocoderBundle\AvtonomGeocoderBundle(),
    ...
);

```

Configuration options (config.yaml):

``` yaml

yamilovs_sypex_geo:
    database_path: "%kernel.root_dir%/../var/SypexGeoDatabase/SxGeoCity.dat"

bazinga_geocoder:
    providers:
        chain:
            providers: [avtonom_geocoder.geocoder.sypex_geo]

```

Update geo base:

```sh

php ./app/console yamilovs:sypex-geo:update-database-file
or
cd ./var/SypexGeoDatabase/
wget https://sypexgeo.net/files/SxGeoCity_utf8.zip -o  ./SxGeoCity.dat
unzip SxGeoCity_utf8.zip

```

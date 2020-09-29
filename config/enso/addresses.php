<?php

return [
    'onDelete' => 'cascade',
    'loggableMorph' => [
        'addressable' => [Person::class => 'name'],
    ],
    'defaultCountryId' => 184,
    'googleMaps' => [
        'key' => env('GOOGLE_MAPS_KEY'),
        'url' => 'https://maps.googleapis.com/maps/api/geocode/json',
    ],
];

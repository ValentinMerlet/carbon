# Support des jours fériés en France pour la librairie Carbon
Cette librairie est basée sur [Carbon](https://github.com/briannesbitt/Carbon) et permet de calculer les jours fériés en France.

Note: Pour le moment, seule la version 2 de Carbon est supportée.

*Lire dans une autre langue: [English](README.md)*

<a name="install"></a>
## Installation

```
composer require twix/carbon
```

## Exemples
```php
// Vérifie que la date passée est un jour férié
Carbon::isBankHoliday('2020-05-21'); // true
Carbon::isBankHoliday(Carbon::parse('First day of 2000')); // true

Carbon::getEasterMonday(2021); // '2021-04-05'
Carbon::getWhitMonday(2021); // '2021-05-24'

// Sans paramètre, retourne la date pour l'année courante
Carbon::getAscensionThursday(); // '2020-05-21'

// Récupérer tous les jours fériés pour une année donnée
array_map(function (Carbon $carbon): string {
    return $carbon->format('Y-m-d');
}, Carbon::getAllBankHolidaysForOneYear(2021));
/*
[
    '2021-01-01',
    '2021-04-05',
    '2021-05-01',
    '2021-05-08',
    '2021-05-13',
    '2021-05-24',
    '2021-07-14',
    '2021-08-15',
    '2021-11-01',
    '2021-11-11',
    '2021-12-25'
]
*/
```

## Contribuer

1. Cloner le dépôt et installer les dépendances.

```
docker-compose run --rm php /usr/local/bin/composer install
```

2. Lancer les tests

```
docker-compose run --rm php vendor/bin/phpunit
```

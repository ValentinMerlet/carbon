[![Build Status](https://img.shields.io/travis/ValentinMerlet/carbon/master.svg?style=flat-square)](https://travis-ci.com/github/ValentinMerlet/carbon)
[![codecov.io](https://img.shields.io/codecov/c/gh/ValentinMerlet/carbon?style=flat-square)](https://codecov.io/gh/ValentinMerlet/carbon)

# Carbon Support for FR Bank Holidays
This extends [Carbon](https://github.com/briannesbitt/Carbon) and calculates which days are French bank holidays.

Note: For now, it only supports Carbon v2

*Read this in other languages: [Français](README.fr.md)*

<a name="install"></a>
## Installation

```
composer require twix/carbon
```

## Examples
```php
// Checks if the given date is bank holiday
Carbon::isBankHoliday('2020-05-21'); // true
Carbon::isBankHoliday(Carbon::parse('First day of 2000')); // true

Carbon::getEasterMonday(2021); // '2021-04-05'
Carbon::getWhitMonday(2021); // '2021-05-24'

// Without any parameter will return date for the current year
Carbon::getAscensionThursday(); // '2020-05-21'

// Get all bank holidays for one year
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

## Contributing

1. Clone the repo and install dependencies.

```
docker-compose run --rm php /usr/local/bin/composer install
```

2. Run Tests

```
docker-compose run --rm php vendor/bin/phpunit
```

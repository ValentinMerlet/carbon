<?php

declare(strict_types=1);

namespace FRBankHolidays;

final class Carbon extends \Carbon\Carbon
{
    private const TIMEZONE = 'Europe/Paris';

    /**
     * Returns true if the date passed in parameter is a bank holiday
     *
     * @param mixed $date Instance of \Datetime or Y-m-d formatted string
     */
    public static function isBankHoliday($date): bool
    {
        $date = static::getDate($date);

        return 0 < count(
                array_filter(
                    self::getAllBankHolidaysForOneYear($date->year), function (\DateTime $bankHolidayDate) use ($date) {
                    return 0 === abs($bankHolidayDate->diff($date)->format('%a'));
                }
                )
            );
    }

    /**
     * Returns an array containing all the bank holidays for the year passed in parameter
     *
     * @param int $year
     * @return array
     */
    public static function getAllBankHolidaysForOneYear(int $year): array
    {
        $bankHolidays = [];

        // New Year's Day / Jour de l'an
        if ($year > 1810) {
            $bankHolidays[] = self::getDate(sprintf('%d-01-01', $year));
        }

        // Easter Monday / Lundi de pâques
        if ($year >= 1886) {
            $easterMonday = self::getEasterDay($year)->addDay();

            $bankHolidays[] = self::getDate(sprintf('%d-%d-%d', $year, $easterMonday->month, $easterMonday->day));
        }

        // First of may // Fête du travail
        if ($year >= 1920) {
            $bankHolidays[] = self::getDate(sprintf('%d-05-01', $year));
        }

        // Eighth of May / 8 Mai
        if (($year >= 1953 && $year <= 1959) || $year > 1981) {
            $bankHolidays[] = self::getDate(sprintf('%d-05-08', $year));
        }

        // Ascension Thursday / Jeudi de l'ascension
        if ($year >= 1802) {
            $ascensionThursday = self::getEasterDay($year)->addDays(39);

            $bankHolidays[] = self::getDate(
                sprintf(
                    '%d-%d-%d',
                    $year,
                    $ascensionThursday->month,
                    $ascensionThursday->day
                )
            );
        }

        // Whit Monday / Lundi de pentecôte
        if ($year >= 1886) {
            $ascensionThursday = self::getEasterDay($year)->addDays(50);

            $bankHolidays[] = self::getDate(
                sprintf(
                    '%d-%d-%d',
                    $year,
                    $ascensionThursday->month,
                    $ascensionThursday->day
                )
            );
        }

        // National holiday / Fête nationale
        if ($year >= 1880) {
            $bankHolidays[] = self::getDate(sprintf('%d-07-14', $year));
        }

        // Assumption day / Jour de l'Assomption
        if ($year >= 1802) {
            $bankHolidays[] = self::getDate(sprintf('%d-08-15', $year));
        }

        // Feast of all Saints // Fête de la Toussaint
        if ($year >= 1802) {
            $bankHolidays[] = self::getDate(sprintf('%d-11-01', $year));
        }

        // Armistice
        if ($year >= 1918) {
            $bankHolidays[] = self::getDate(sprintf('%d-11-11', $year));
        }

        // Christmas Day / Noël
        if ($year >= 1802) {
            $bankHolidays[] = self::getDate(sprintf('%d-12-25', $year));
        }

        return $bankHolidays;
    }

    private static function getDate($date): self
    {
        if (is_string($date) || is_numeric($date)) {
            return static::parse(
                strlen($date) > 4 ? $date : sprintf('%s-01-01', $date),
                new \DateTimeZone(self::TIMEZONE)
            );
        }

        $date->setTimezone(self::TIMEZONE);
        $date->setHour(0)->setMinute(0)->setSecond(0);

        if (!$date instanceof \DateTime) {
            throw new \InvalidArgumentException('Date should be type of string, int or a DateTime');
        }

        return new self($date);
    }

    private static function getEasterDay(int $year): self
    {
        // Golden Number - 1
        $G = $year % 19;
        $C = floor($year / 100);
        // related to Epact
        $H = ($C - floor($C / 4) - floor((8 * $C + 13) / 25) + 19 * $G + 15) % 30;
        // number of days from 21 March to the Paschal full moon
        $I = $H - floor($H / 28) * (1 - floor(29 / ($H + 1)) * floor((21 - $G) / 11));
        // weekday for the Paschal full moon
        $J = ($year + floor($year / 4) + $I + 2 - $C + floor($C / 4)) % 7;
        // number of days from 21 March to the Sunday on or before the Paschal full moon
        $L = $I - $J;
        $month = 3 + floor(($L + 40) / 44);
        $day = $L + 28 - 31 * floor($month / 4);

        return self::getDate(sprintf('%d-%d-%d', $year, $month, $day));
    }
}

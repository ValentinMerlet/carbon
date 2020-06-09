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
    public static function isBankHoliday($date = null): bool
    {
        $date = static::getDate($date);

        return 0 < count(
                array_filter(
                    self::getAllBankHolidaysForOneYear($date->year),
                    function (\DateTime $bankHolidayDate) use ($date) {
                        return 0 === abs($bankHolidayDate->diff($date)->format('%a'));
                    }
                )
            );
    }

    /**
     * Returns an array containing all the bank holidays for the year passed in parameter
     */
    public static function getAllBankHolidaysForOneYear(?int $year = null): array
    {
        if ($year === null) {
            $year = (int) date('Y');
        }

        $bankHolidays = [];

        // New Year's Day / Jour de l'an
        if ($year > 1810) {
            $bankHolidays[] = self::getDate(self::getNewYearsDay($year));
        }

        // Easter Monday / Lundi de pâques
        if ($year >= 1886) {
            $bankHolidays[] = self::getDate(self::getEasterMonday($year));
        }

        // First of may // Fête du travail
        if ($year >= 1920) {
            $bankHolidays[] = self::getDate(self::getFirstOfMay($year));
        }

        // Eighth of May / 8 Mai
        if (($year >= 1953 && $year <= 1959) || $year > 1981) {
            $bankHolidays[] = self::getDate(self::getEighthOfMay($year));
        }

        // Ascension Thursday / Jeudi de l'ascension
        if ($year >= 1802) {
            $bankHolidays[] = self::getDate(self::getAscensionThursday($year));
        }

        // Whit Monday / Lundi de pentecôte
        if ($year >= 1886) {
            $bankHolidays[] = self::getDate(self::getWhitMonday($year));
        }

        // National holiday / Fête nationale
        if ($year >= 1880) {
            $bankHolidays[] = self::getDate(self::getNationalDay($year));
        }

        // Assumption day / Jour de l'Assomption
        if ($year >= 1802) {
            $bankHolidays[] = self::getDate(self::getAssumptionDay($year));
        }

        // Feast of all Saints // Fête de la Toussaint
        if ($year >= 1802) {
            $bankHolidays[] = self::getDate(self::getFeastOfAllSaintsDay($year));
        }

        // Armistice
        if ($year >= 1918) {
            $bankHolidays[] = self::getDate(self::getArmisticeDay($year));

        }

        // Christmas Day / Noël
        if ($year >= 1802) {
            $bankHolidays[] = self::getDate(self::getChristmasDay($year));
        }

        return $bankHolidays;
    }

    /**
     * Get New Years day as a 'Y-m-d' string
     */
    public static function getNewYearsDay(?int $year = null): string
    {
        return sprintf('%d-01-01', $year ?? date('Y'));
    }

    /**
     * Get Easter monday as a 'Y-m-d' string
     */
    public static function getEasterMonday(?int $year = null): string
    {
        if ($year === null) {
            $year = (int) date('Y');
        }

        $easterMonday = self::getEasterDay($year)->addDay();
        $month = $easterMonday->month;
        $day = $easterMonday->day;

        return sprintf(
            '%d-%s-%s',
            $year,
            strlen((string) $month) === 1 ? sprintf('0%d', $month) : $month,
            strlen((string) $day) === 1 ? sprintf('0%d', $day) : $day
        );
    }

    /**
     * Get First of may as a 'Y-m-d' string
     */
    public static function getFirstOfMay(?int $year = null): string
    {
        return sprintf('%d-05-01', $year ?? date('Y'));
    }

    /**
     * Get Eighth of may as a 'Y-m-d' string
     */
    public static function getEighthOfMay(?int $year = null): string
    {
        return sprintf('%d-05-08', $year ?? date('Y'));
    }

    /**
     * Get Ascension thursday as a 'Y-m-d' string
     */
    public static function getAscensionThursday(?int $year = null): string
    {
        if ($year === null) {
            $year = (int) date('Y');
        }

        $ascensionThursday = self::getEasterDay($year)->addDays(39);
        $month = $ascensionThursday->month;
        $day = $ascensionThursday->day;

        return sprintf(
            '%s-%s-%s',
            $year,
            strlen((string) $month) === 1 ? sprintf('0%d', $month) : $month,
            strlen((string) $day) === 1 ? sprintf('0%d', $day) : $day
        );
    }

    /**
     * Get Whit monday as a 'Y-m-d' string
     */
    public static function getWhitMonday(?int $year = null): string
    {
        if ($year === null) {
            $year = (int) date('Y');
        }

        $whitMonday = self::getEasterDay($year)->addDays(50);
        $month = $whitMonday->month;
        $day = $whitMonday->day;

        return sprintf(
            '%d-%s-%s',
            $year,
            strlen((string) $month) === 1 ? sprintf('0%d', $month) : $month,
            strlen((string) $day) === 1 ? sprintf('0%d', $day) : $day
        );
    }

    /**
     * Get National day as a 'Y-m-d' string
     */
    public static function getNationalDay(?int $year = null): string
    {
        return sprintf('%d-07-14', $year ?? date('Y'));
    }

    /**
     * Get Assumption day as a 'Y-m-d' string
     */
    public static function getAssumptionDay(?int $year = null): string
    {
        return sprintf('%d-08-15', $year ?? date('Y'));
    }

    /**
     * Get Feast of all saints day as a 'Y-m-d' string
     */
    public static function getFeastOfAllSaintsDay(?int $year = null): string
    {
        return sprintf('%d-11-01', $year ?? date('Y'));
    }

    /**
     * Get Armistice day as a 'Y-m-d' string
     */
    public static function getArmisticeDay(?int $year = null): string
    {
        return sprintf('%d-11-11', $year ?? date('Y'));
    }

    /**
     * Get Christmas day as a 'Y-m-d' string
     */
    public static function getChristmasDay(?int $year = null): string
    {
        return sprintf('%d-12-25', $year ?? date('Y'));
    }

    private static function getDate($date): self
    {
        if (is_string($date) || is_numeric($date)) {
            return static::parse(
                strlen($date) > 4 ? $date : sprintf('%s-01-01', $date),
                new \DateTimeZone(self::TIMEZONE)
            );
        }

        if ($date === null) {
            $date = Carbon::now();
        }

        $date->setTimezone(self::TIMEZONE);
        $date->setHour(0)->setMinute(0)->setSecond(0);

        if (!$date instanceof \DateTime) {
            throw new \InvalidArgumentException('Date should be type of string, int or a DateTime');
        }

        return new self($date);
    }

    private static function getEasterDay(?int $year = null): self
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

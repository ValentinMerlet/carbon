<?php

declare(strict_types=1);

namespace Twix;

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
        if (1810 < $year) {
            $bankHolidays[] = self::getDate(sprintf('%d-01-01', $year));
        }

        // Easter Monday / Lundi de pâques
        if (2037 > $year && 1970 < $year) {
            $bankHolidays[] = static::createFromTimestamp(easter_date($year))->addDay();
        }

        // First of may // Fête du travail
        if (1919 < $year) {
            $bankHolidays[] = self::getDate(sprintf('%d-05-01', $year));
        }

        return $bankHolidays;
    }

    private static function getDate($date): \DateTime
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

        return $date;
    }
}

<?php

declare(strict_types=1);

namespace Tests;

use Twix\Carbon;
use PHPUnit\Framework\TestCase;

final class CarbonTest extends TestCase
{
    public function testIsBankHolidayNewYearsDay()
    {
        $this->assertTrue(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-01-01')));
        $this->assertTrue(Carbon::isBankHoliday('2020-01-01'));
        $this->assertTrue(Carbon::isBankHoliday('1811-01-01'));
        $this->assertFalse(Carbon::isBankHoliday('1810-01-01'));
    }

    public function testIsBankHolidayEasterMonday()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-04-13'));
        $this->assertTrue(Carbon::isBankHoliday('1886-04-26'));
        $this->assertFalse(Carbon::isBankHoliday('1885-04-06'));
    }

    public function testIsBankHolidayFirstOfMay()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-05-01'));
        $this->assertTrue(Carbon::isBankHoliday('1920-05-01'));
        $this->assertFalse(Carbon::isBankHoliday('1919-05-01'));
    }

    public function testIsBankHolidayEighthOfMay()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-05-08'));
        $this->assertTrue(Carbon::isBankHoliday('1959-05-08'));
        $this->assertTrue(Carbon::isBankHoliday('1982-05-08'));
        $this->assertFalse(Carbon::isBankHoliday('1952-05-08'));
        $this->assertFalse(Carbon::isBankHoliday('1960-05-08'));
        $this->assertFalse(Carbon::isBankHoliday('1981-05-08'));
    }

    public function testIsBankHolidayAscensionThursday()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-05-21'));
        $this->assertTrue(Carbon::isBankHoliday('1802-05-27'));
        $this->assertFalse(Carbon::isBankHoliday('1801-05-14'));
    }

    public function testIsBankHolidayWhitMonday()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-06-01'));
        $this->assertTrue(Carbon::isBankHoliday('1886-06-14'));
        $this->assertFalse(Carbon::isBankHoliday('1886-05-25'));
    }

    public function testIsBankHolidayNationalDay()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-07-14'));
        $this->assertTrue(Carbon::isBankHoliday('1880-07-14'));
        $this->assertFalse(Carbon::isBankHoliday('1879-07-14'));
    }

    public function testIsBankHolidayAssumptionDay()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-08-15'));
        $this->assertTrue(Carbon::isBankHoliday('1802-08-15'));
        $this->assertFalse(Carbon::isBankHoliday('1801-08-15'));
    }

    public function testIsBankHolidayFeastOfAllSaints()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-11-01'));
    }

    public function testIsBankHolidayArmistice()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-11-11'));
        $this->assertTrue(Carbon::isBankHoliday('1918-11-11'));
        $this->assertFalse(Carbon::isBankHoliday('1917-11-11'));
    }

    public function testIsBankHolidayChristmasDay()
    {
        $this->assertTrue(Carbon::isBankHoliday('2020-12-25'));
        $this->assertTrue(Carbon::isBankHoliday('1802-12-25'));
        $this->assertFalse(Carbon::isBankHoliday('1801-12-25'));
    }

    public function testAreNotBankHolidays()
    {
        $this->assertFalse(Carbon::isBankHoliday('2019-12-31'));
        $this->assertFalse(Carbon::isBankHoliday('2020-01-14'));
        $this->assertFalse(Carbon::isBankHoliday('2020-04-12'));
        $this->assertFalse(Carbon::isBankHoliday('2020-04-14'));
        $this->assertFalse(Carbon::isBankHoliday('2020-04-30'));
        $this->assertFalse(Carbon::isBankHoliday('2020-05-02'));
        $this->assertFalse(Carbon::isBankHoliday('2020-05-09'));
        $this->assertFalse(Carbon::isBankHoliday('2020-05-20'));
        $this->assertFalse(Carbon::isBankHoliday('2020-05-22'));
        $this->assertFalse(Carbon::isBankHoliday('2020-05-31'));
        $this->assertFalse(Carbon::isBankHoliday('2020-06-02'));
        $this->assertFalse(Carbon::isBankHoliday('2020-07-13'));
        $this->assertFalse(Carbon::isBankHoliday('2020-07-15'));
        $this->assertFalse(Carbon::isBankHoliday('2020-08-14'));
        $this->assertFalse(Carbon::isBankHoliday('2020-08-16'));
        $this->assertFalse(Carbon::isBankHoliday('2020-10-31'));
        $this->assertFalse(Carbon::isBankHoliday('2020-11-02'));
        $this->assertFalse(Carbon::isBankHoliday('2020-11-10'));
        $this->assertFalse(Carbon::isBankHoliday('2020-11-12'));
        $this->assertFalse(Carbon::isBankHoliday('2020-12-24'));
        $this->assertFalse(Carbon::isBankHoliday('2020-12-26'));
    }

    public function testGetNewYearsDay()
    {
        $this->assertEquals('2021-01-01', Carbon::getNewYearsDay(2021));
    }

    public function testGetEasterMonday()
    {
        $this->assertEquals('2021-04-05', Carbon::getEasterMonday(2021));
        $this->assertEquals('2020-04-13', Carbon::getEasterMonday());
    }

    public function testGetFirstOfMay()
    {
        $this->assertEquals('2021-05-01', Carbon::getFirstOfMay(2021));
    }

    public function testGetEighthOfMay()
    {
        $this->assertEquals('2021-05-08', Carbon::getEighthOfMay(2021));
    }

    public function testGetAscensionThursday()
    {
        $this->assertEquals('2021-05-13', Carbon::getAscensionThursday(2021));
        $this->assertEquals('2020-05-21', Carbon::getAscensionThursday());
    }

    public function testGetWhitMonday()
    {
        $this->assertEquals('2021-05-24', Carbon::getWhitMonday(2021));
        $this->assertEquals('2020-06-01', Carbon::getWhitMonday());
    }

    public function testGetNationalDay()
    {
        $this->assertEquals('2021-07-14', Carbon::getNationalDay(2021));
    }

    public function testGetAssumptionDay()
    {
        $this->assertEquals('2021-08-15', Carbon::getAssumptionDay(2021));
    }

    public function testGetFeastOfAllSaintsDay()
    {
        $this->assertEquals('2021-11-01', Carbon::getFeastOfAllSaintsDay(2021));
    }

    public function testGetArmisticeDay()
    {
        $this->assertEquals('2021-11-11', Carbon::getArmisticeDay(2021));
    }

    public function testGetAllBankHolidaysForOneYear()
    {
        $this->assertEquals(
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
            ], array_map(function (Carbon $carbon): string {
            return $carbon->format('Y-m-d');
        }, Carbon::getAllBankHolidaysForOneYear(2021)));

        $this->assertEquals(
            [
                '2020-01-01',
                '2020-04-13',
                '2020-05-01',
                '2020-05-08',
                '2020-05-21',
                '2020-06-01',
                '2020-07-14',
                '2020-08-15',
                '2020-11-01',
                '2020-11-11',
                '2020-12-25'
            ], array_map(function (Carbon $carbon): string {
            return $carbon->format('Y-m-d');
        }, Carbon::getAllBankHolidaysForOneYear()));
    }
}

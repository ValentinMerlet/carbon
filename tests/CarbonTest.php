<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Twix\Carbon;

final class CarbonTest extends TestCase
{
    public function testIsBankHolidayNewYearsDay()
    {
        $this->assertTrue(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-01-01')));
        $this->assertTrue(Carbon::isBankHoliday('2020-01-01'));
        $this->assertTrue(Carbon::isBankHoliday('1811-01-01'));
        $this->assertTrue(!Carbon::isBankHoliday('1810-01-01'));
    }

    public function testIsBankHolidayEasterMonday()
    {
        $this->assertTrue(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-04-13')));
        $this->assertTrue(Carbon::isBankHoliday('2020-04-13'));
    }

    public function testIsBankHolidayFirstOfMay()
    {
        $this->assertTrue(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-05-01')));
        $this->assertTrue(Carbon::isBankHoliday('2020-05-01'));
    }

    public function testIsBankHolidayEighthOfMay()
    {
        $this->assertTrue(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-05-08')));
        $this->assertTrue(Carbon::isBankHoliday('2020-05-08'));
    }

    public function testIsBankHolidayAscensionThursday()
    {
        $this->assertTrue(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-05-21')));
        $this->assertTrue(Carbon::isBankHoliday('2020-05-21'));
    }

    public function testIsNotBankHoliday()
    {
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2019-12-31')));
        $this->assertFalse(Carbon::isBankHoliday('2019-12-31'));
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-01-14')));
        $this->assertFalse(Carbon::isBankHoliday('2020-01-14'));
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-04-12')));
        $this->assertFalse(Carbon::isBankHoliday('2020-04-12'));
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-04-14')));
        $this->assertFalse(Carbon::isBankHoliday('2020-04-14'));
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-04-30')));
        $this->assertFalse(Carbon::isBankHoliday('2020-04-30'));
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-05-02')));
        $this->assertFalse(Carbon::isBankHoliday('2020-05-02'));
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-05-07')));
        $this->assertFalse(Carbon::isBankHoliday('2070-05-02'));
        $this->assertFalse(Carbon::isBankHoliday(Carbon::createFromFormat('Y-m-d', '2020-05-09')));
        $this->assertFalse(Carbon::isBankHoliday('2020-05-09'));
    }
}

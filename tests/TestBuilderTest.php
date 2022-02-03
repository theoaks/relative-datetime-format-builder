<?php
declare(strict_types=1);

use Oaks\RelativeDatetimeFormatBuilder\MonthName;
use Oaks\RelativeDatetimeFormatBuilder\RelativeDateTimeFormatBuilder;
use PHPUnit\Framework\TestCase;

final class TestBuilderTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function firstDayOfJanuary()
    {
        $builder = RelativeDateTimeFormatBuilder::firstDayOf(
            MonthName::January
        );

        $this->assertEquals(
            "first day of January this year",
            $builder->__toString()
        );
    }

    /**
     * @test
     *
     * @return void
     */
    public function anotherTest()
    {
        $three_days_from_now = (new RelativeDateTimeFormatBuilder())
            ->addDays(3);

        $this->assertEquals(
            "+3 day",
            "$three_days_from_now"
        );

        $date_time = $three_days_from_now->toDateTime();
        $now = new DateTime("+3 days");
        $this->assertEquals(
            $now->format("Y-M-d"),
            $date_time->format("Y-M-d"),
        );

        $date_time_immutable = $three_days_from_now->toDateTimeImmutable();
        $now_immutable = DateTimeImmutable::createFromInterface($now);
        $this->assertEquals(
            $now_immutable->format("Y-M-d"),
            $date_time_immutable->format("Y-M-d"),
        );
    }

    /**
     * @test
     * @return void
     */
    public function firstDayOfMarch2025()
    {
        $format = (new RelativeDateTimeFormatBuilder())
            ->firstDay()
            ->ofMarch()
            ->year(2025)
            ->at(hour: 11);

//        echo  $format;
// first day of March 2025 11:00:00

        $this->assertEquals(
            "first day of March 2025 11:00:00",
            "$format"
        );
    }
}
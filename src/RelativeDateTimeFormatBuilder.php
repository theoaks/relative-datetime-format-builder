<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

use DateTime;
use DateTimeImmutable;
use Exception;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

class RelativeDateTimeFormatBuilder
{
    //<editor-fold desc="__Properties">
    private array $units = [];

    private ?int $hour = null;
    private ?int $minute = null;
    private ?int $second = null;
    //</editor-fold>

    //<editor-fold desc="__Day Units">
    public function thisSunday(): static
    {
        return $this->setDay(DayName::Sunday);
    }

    public function thisMonday(): static
    {
        return $this->setDay(DayName::Monday);
    }

    public function thisTuesday(): static
    {
        return $this->setDay(DayName::Tuesday);
    }

    public function thisWednesday(): static
    {
        return $this->setDay(DayName::Wednesday);
    }

    public function thisThursday(): static
    {
        return $this->setDay(DayName::Thursday);
    }

    public function thisFriday(): static
    {
        return $this->setDay(DayName::Friday);
    }

    public function thisSaturday(): static
    {
        return $this->setDay(DayName::Saturday);
    }

    public function today(): static
    {
        return $this->setDay();
    }

    public function lastDay(): static
    {
        return $this->setDay(ordinal: Ordinal::Last);
    }

    public function firstDay(): static
    {
        return $this->setDay(ordinal: Ordinal::First);
    }

    public function previousDay(): static
    {
        return $this->setDay(ordinal: Ordinal::Previous);
    }

    public function addDays(int $n): static
    {
        return $this->addUnit(
            new DayDateFormatUnit(
                diff: abs($n)
            )
        );
    }

    public function subtractDays(int $n): static
    {
        return $this->addUnit(
            new DayDateFormatUnit(
                diff: -1 * abs($n)
            )
        );
    }

    /**
     * @param DayName|null $day
     * @param Ordinal $ordinal
     * @return RelativeDateTimeFormatBuilder
     */
    public function setDay(?DayName $day = null, Ordinal $ordinal = Ordinal::This): RelativeDateTimeFormatBuilder
    {
        if (!is_null($day) && $this->hasDayUnit()) {
            throw new InvalidArgumentException(
                "A specific day has already been selected.
                 You cannot select more than one specific day."
            );
        }

        $this->units[] = new DayDateFormatUnit(dayName: $day, ordinal: $ordinal);
        return $this;
    }

    private function hasDayUnit(): bool
    {
        $units_count = count(
            array_filter(
                $this->units,
                fn(DateFormatUnit $unit) => $unit instanceof DayDateFormatUnit
                    && !is_null($unit->getDayName())
            )
        );

        return $units_count > 0;
    }

    //</editor-fold>

    //<editor-fold desc="__Month Units">
    public function ofThisMonth(): static
    {
        return $this->setOf(null);
    }

    public function ofJanuary(): static
    {
        return $this->setOf(MonthName::January);
    }

    public function ofFebruary(): static
    {
        return $this->setOf(MonthName::February);
    }

    public function ofMarch(): static
    {
        return $this->setOf(MonthName::March);
    }

    public function ofApril(): static
    {
        return $this->setOf(MonthName::April);
    }

    public function ofMay(): static
    {
        return $this->setOf(MonthName::May);
    }

    public function ofJune(): static
    {
        return $this->setOf(MonthName::June);
    }

    public function ofJuly(): static
    {
        return $this->setOf(MonthName::July);
    }

    public function ofAugust(): static
    {
        return $this->setOf(MonthName::August);
    }

    public function ofSeptember(): static
    {
        return $this->setOf(MonthName::September);
    }

    public function ofOctober(): static
    {
        return $this->setOf(MonthName::October);
    }

    public function ofNovember(): static
    {
        return $this->setOf(MonthName::November);
    }

    public function ofDecember(): static
    {
        return $this->setOf(MonthName::December);
    }

    public function addMonth(int $n): static
    {
        $this->addUnit(
            new MonthDateFormatUnit(diff: abs($n))
        );

        return $this;
    }

    public function subtractMonth(int $n): static
    {
        $this->addUnit(
            new MonthDateFormatUnit(diff: -abs($n))
        );

        return $this;
    }

    public function setOf(?MonthName $of, Ordinal $ordinal = Ordinal::This): static
    {
        if (!is_null($of) && $this->hasMonthUnit()) {
            throw new InvalidArgumentException(
                "There's already a specific month selected.
                You cannot add more than one specific month."
            );
        }

        $this->units[] = new MonthDateFormatUnit($of, $ordinal);

        return $this;
    }

    public function ofLastMonth(): static
    {
        return $this->setOf(null, Ordinal::Last);
    }

    public function ofPreviousMonth(): static
    {
        return $this->setOf(null, Ordinal::Previous);
    }

    public function of(?MonthName $monthName): static
    {
        return $this->setOf($monthName);
    }

    private function hasMonthUnit(): bool
    {
        $units_count = count(
            array_filter(
                $this->units,
                fn(DateFormatUnit $unit) => $unit instanceof MonthDateFormatUnit
                    && !is_null($unit->getMonthName())
            )
        );

        return $units_count > 0;
    }

    //</editor-fold>

    public function thisWeek(): static
    {
        $this->addUnit(new WeekFormatUnit());

        return $this;
    }

    public function nextWeek(): static
    {
        $this->addUnit(new WeekFormatUnit(ordinal: Ordinal::Next));

        return $this;
    }

    public function addWeeks(int $n): static
    {
        $this->addUnit(new WeekFormatUnit(ordinal: Ordinal::Next, diff: abs($n)));

        return $this;
    }

    public function subtractWeeks(int $n): static
    {
        $this->addUnit(new WeekFormatUnit(ordinal: Ordinal::Next, diff: -abs($n)));

        return $this;
    }

    public function addUnit(DateFormatUnit $unit): static
    {
        $this->units[] = $unit;

        return $this;
    }

    //<editor-fold desc="Time">
    public function at(int $hour = 0, int $minute = 0, int $second = 0): static
    {
        return $this->atHour($hour)
            ->atMinute($minute)
            ->atSecond($second);
    }

    private function getTime(): ?string
    {
        if (!is_null($this->hour) || !is_null($this->minute) || !is_null($this->second)) {
            return sprintf(
                "%s:%s:%s",
                str_pad($this->hour ?? 0, 2, '0', STR_PAD_LEFT),
                str_pad($this->minute ?? 0, 2, '0', STR_PAD_LEFT),
                str_pad($this->second ?? 0, 2, '0', STR_PAD_LEFT),
            );
        }

        return null;
    }

    /**
     * @param int $hour
     * @return RelativeDateTimeFormatBuilder
     */
    public function atHour(int $hour = 0): RelativeDateTimeFormatBuilder
    {
        Assert::true(
            oaks_in_between($hour, 0, 23, true),
            "Hour must be between 0 and 23"
        );

        $this->hour = $hour;
        return $this;
    }

    public function atNoon(): static
    {
        return $this->at(hour: 12);
    }

    public function atMidnight(): static
    {
        return $this->at();
    }

    /**
     * @param int $minute
     * @return RelativeDateTimeFormatBuilder
     */
    public function atMinute(int $minute = 0): RelativeDateTimeFormatBuilder
    {
        Assert::true(
            oaks_in_between($minute, 0, 59, true),
            "Minute must be between 0 and 59"
        );

        $this->minute = $minute;
        return $this;
    }

    /**
     * @param int $second
     * @return RelativeDateTimeFormatBuilder
     */
    public function atSecond(int $second = 0): RelativeDateTimeFormatBuilder
    {
        Assert::true(
            oaks_in_between($second, 0, 59, true),
            "Second must be between 0 and 59"
        );

        $this->second = $second;
        return $this;
    }

    //</editor-fold>

    public function year(?int $year): static
    {
        return $this->setYear($year);
    }

    public function setYear(
        ?int    $year,
        Ordinal $ordinal = Ordinal::This,
        ?int    $diff = null
    ): static
    {
        if (!is_null($year) && $this->hasYearUnit()) {
            throw new InvalidArgumentException(
                "A specific year has already been added.
                You cannot add more than one specific year"
            );
        }

        $this->units[] = new YearDateFormatUnit($year, $ordinal, $diff);

        return $this;
    }

    private function hasYearUnit(): bool
    {
        $units_count = count(
            array_filter(
                $this->units,
                fn(DateFormatUnit $unit) => $unit instanceof YearDateFormatUnit
                    && !is_null($unit->getYear())
            )
        );

        return $units_count > 0;
    }

    public static function lastDayOf(MonthName $monthName, ?int $year = null): static
    {
        return (new self())
            ->lastDay()
            ->of($monthName)
            ->year($year);
    }

    public static function lastDayOfAt(
        MonthName $monthName,
        int       $hour,
        int       $minute,
        int       $second,
        ?int      $year = null,
    ): static
    {
        return (new self())
            ->lastDay()
            ->of($monthName)
            ->at($hour, $minute, $second)
            ->year($year);
    }

    public static function lastDayOfThisMonth(): static
    {
        return (new self())
            ->lastDay()
            ->ofThisMonth();
    }

    public static function lastDayOfThisMonthAt(
        int $hour,
        int $minute,
        int $second
    ): static
    {
        return (new self())
            ->lastDay()
            ->ofThisMonth()
            ->at($hour, $minute, $second);
    }

    public static function firstDayOf(MonthName $monthName, ?int $year = null): static
    {
        return (new self())
            ->firstDay()
            ->of($monthName)
            ->year($year);
    }

    public static function firstDayOfThisMonth(): static
    {
        return (new self())
            ->firstDay()
            ->ofThisMonth();
    }

    public static function firstDayOfThisMonthAt(
        int  $hour,
        int  $minute,
        int  $second,
    ): static {
        return (new self())
            ->firstDay()
            ->ofThisMonth()
            ->at(hour: $hour, minute: $minute, second: $second);
    }

    public static function firstDayOfAt(
        MonthName $monthName,
        int       $hour,
        int       $minute,
        int       $second,
        ?int      $year = null,
    ): static
    {
        return (new self())
            ->firstDay()
            ->of($monthName)
            ->at($hour, $minute, $second)
            ->year($year);
    }


    /**
     * @throws Exception
     */
    public function toDateTime(): DateTime
    {
        return new DateTime($this->__toString());
    }

    /**
     * @throws Exception
     */
    public function toDateTimeImmutable(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->__toString());
    }

    public function __toString(): string
    {
        $time = $this->getTime();

        if (count($this->units) > 0) {
            $format = join(
                ' ',
                array_map(
                    fn(DateFormatUnit $unit) => $unit->__toString(),
                    $this->units
                )
            );


            if (!is_null($time)) {
                $format .= " $time";
            }

            return $format;
        }

        return !is_null($time)
            ? $time
            : "";
    }
}

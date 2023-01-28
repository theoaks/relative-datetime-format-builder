<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

class DayDateFormatUnit extends DateFormatUnit
{
    public function __construct(
        private readonly ?DayName $dayName = null,
        Ordinal                   $ordinal = Ordinal::This,
        ?int                      $diff = null,
    ) {
        parent::__construct(Unit::Day, $ordinal, $diff);
    }

    /**
     * @return DayName|null
     */
    public function getDayName(): ?DayName
    {
        return $this->dayName;
    }

    public function __toString(): string
    {
        if (!is_null($this->dayName)) {
            return "{$this->getOrdinal()->value} {$this->dayName->value}";
        }

        return parent::__toString();
    }
}

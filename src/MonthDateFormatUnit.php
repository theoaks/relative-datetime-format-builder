<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

use JetBrains\PhpStorm\Pure;

class MonthDateFormatUnit extends DateFormatUnit
{
    #[Pure]
    public function __construct(
        private ?MonthName $monthName = null,
        Ordinal            $ordinal = Ordinal::This,
        ?int               $diff = null
    ) {
        parent::__construct(Unit::Month, $ordinal, $diff);
    }

    /**
     * @return MonthName|null
     */
    public function getMonthName(): ?MonthName
    {
        return $this->monthName;
    }

    public function __toString(): string
    {
        $of = "of ";

        if (!is_null($this->monthName)) {
            return $of . $this->monthName->value;
        }

        $diff = $this->getDiff();
        if (!is_null($diff)) {
            return parent::__toString();
        } else {
            $format = $this->getOrdinal()->value;
        }

        return "$of $format {$this->getUnit()->value}";
    }
}

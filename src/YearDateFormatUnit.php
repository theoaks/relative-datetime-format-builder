<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

use JetBrains\PhpStorm\Pure;

class YearDateFormatUnit extends DateFormatUnit
{
    #[Pure]
    public function __construct(
        private ?int $year = null,
        Ordinal $ordinal = Ordinal::This,
        ?int $diff = null
    ) {
        parent::__construct(
            Unit::Year,
            $ordinal,
            $diff
        );
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     * @return YearDateFormatUnit
     */
    public function setYear(?int $year): YearDateFormatUnit
    {
        $this->year = $year;
        return $this;
    }

    public function __toString(): string
    {
        if (!is_null($this->year)) {
            return "$this->year";
        }

        return parent::__toString();
    }
}

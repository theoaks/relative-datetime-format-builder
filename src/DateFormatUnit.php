<?php

namespace Oaks\RelativeDatetimeFormatBuilder;

class DateFormatUnit
{
    public function __construct(
        private Unit     $unit,
        private Ordinal $ordinal = Ordinal::This,
        private ?int     $diff = null,
    ) {
    }

    /**
     * @return Unit
     */
    public function getUnit(): Unit
    {
        return $this->unit;
    }

    /**
     * @return Ordinal|null
     */
    public function getOrdinal(): ?Ordinal
    {
        return $this->ordinal;
    }

    /**
     * @return int|null
     */
    public function getDiff(): ?int
    {
        return $this->diff;
    }

    public function __toString(): string
    {
        if (!is_null($this->diff)) {
            $format = match (true) {
                $this->diff >= 0 => "+$this->diff",
                $this->diff < 0 => "-" . abs($this->diff)
            };
        } else {
            $format = $this->ordinal->value;
        }

        return "$format {$this->unit->value}";
    }
}

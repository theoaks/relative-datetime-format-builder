# Relative DateTime Format Builder
Object Oriented approach to building the different relative date/time formats that the strtotime(), DateTime and date_create() parser understands.
[Check The PHP Documentation for details](https://www.php.net/manual/de/datetime.formats.relative.php)

## How to install
Install using composer
```
composer require theoaks/relative-datetime-format-builder
```

## How to use
```php
use Oaks\RelativeDatetimeFormatBuilder\RelativeDateTimeFormatBuilder;

$first_day_of_january = RelativeDateTimeFormatBuilder::firstDayOf(
            MonthName::January
        );
echo $first_day_of_january;
$date = $first_day_of_january->toDateTime();

echo $date->format("y-M-d");

/// first day of January this year
/// YYYY-01-01
 
$three_days_from_now = (new RelativeDateTimeFormatBuilder())->addDays(3);
echo $three_days_from_now;

$date = $three_days_from_now->toDateTime();
$date_immutable = $three_days_from_now->toDateTimeImmutable();
/// +3 day

// First day of march 2025 at 11am
$format = (new RelativeDateTimeFormatBuilder())
->firstDay()
->ofMarch()
->year(2025)
->at(hour: 11);

echo  $format;
// first day of March 2025 11:00:00

```
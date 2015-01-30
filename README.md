# Date
[![Build Status](https://travis-ci.org/cerbero90/Date.svg?branch=1.0.2)](https://travis-ci.org/cerbero90/Date)
[![Release Version](https://img.shields.io/github/tag/cerbero90/Date.svg?style=flat&label=stable)](https://packagist.org/packages/cerbero/date)
[![License](https://img.shields.io/packagist/l/cerbero/Date.svg?style=flat)](https://packagist.org/packages/cerbero/date)

Framework agnostic and easy to use tool to work with dates.

## One-step installation
Run the following command from terminal in the root of your project:

    composer require cerbero/date

## Preparation
If you are a Laravel user, you may add the following alias in **app/config/app.php** to use this tool everywhere:

```php
'aliases' => array(
  'Date' => 'Cerbero\Date',
)
```
Otherwise add this `use` statement on top of the classes where you want to use it:

```php
use Cerbero\Date;
```
## Usage
### Create one or more DateTime instances
Both strings, array and DateTime objects are allowed as parameters. You can also pass unlimited arguments.

It returns one or many DateTime instances depending on the number of given parameters.

```php
// pass any English textual date to get an instance of DateTime
$DateTime = Date::create('10 May 2000');

// you can pass an array as argument to create an array of DateTime objects
$array = Date::create(array('now', 'next Thursday'));
    
// or even unlimited arguments, an array is returned as well
$array = Date::create('2 March 2010', 'now', 'last Tuesday');
```
### Check if a string is a valid date

```php
$true = Date::isValid('5 October 1980');

// 13 is recognized as month in English dates, so it's not valid
$false = Date::isValid('13/01/2005');
```
### Format one or more dates
Both strings, array and DateTime objects are allowed as first parameter.

It returns one or many formatted strings depending on the number of given parameters.

```php
// '1999-01-30'
$string = Date::format('30 January 1999', 'Y-m-d');

// '1st April, 2014'
$string = Date::format(new DateTime('2014-04-01'), 'jS F, Y');

// array('12/11/10', '01/04/14')
$array = Date::format(array('Nov-12-10', new DateTime('2014-04-01')), 'd/m/y');
```
### Calculate gap between two dates
Both strings and DateTime objects are allowed as parameters. It doesn't matter the order of the dates.

While the `gap()` method returns an array with the gap details, the other methods return an integer:

```php
// array('years' => 0, 'months' => 11, 'days' => 30, 'hours' => 14, 'minutes' => 48, 'seconds' => 57)
$array = Date::gap('2000-01-01 09:11:03', '1 January 2001');

// 3600
$int = Date::gapInSeconds('January 1st, 2000', '2000-01-01 01:00:00');

// 60
$int = Date::gapInMinutes(new DateTime('2000-01-01'), '2000-01-01 01:00:00');

// 0
$int = Date::gapInHours('2000-01-01 00:59:00', '2000-01-01 00:00:00');

// 14
$int = Date::gapInDays('last week', 'next week');

// 13
$int = Date::gapInMonths('August 2014', '2013 July');

// 9
$int = Date::gapInYears('5 Jan 2010', new DateTime('2000-02-05'));
```
### Calculate the timestamp of one or more dates
Both strings, array and DateTime objects are allowed as parameter.

It returns one or many integer timestamps depending on the number of given parameters.

```php
// 1214870400 (GMT)
$int = Date::timestamp('July 1st, 2008');

// 1276560000 (GMT)
$int = Date::timestamp(new DateTime('2010-06-15'));

// array(1214870400, 1276560000) (GMT)
$array = Date::timestamp(array('July 1st, 2008', new DateTime('2010-06-15')), 'd/m/y');
```
### Compare two dates
Both strings and DateTime objects are allowed as parameters. It can compare both despite their type.

```php
// check if the first date is Less Than the second one
$false = Date::lt('2007 June', new DateTime('2007-06-01'));

// check if the first date is Less Than or Equals the second one
$true = Date::lte(new DateTime('2007-06-01'), '2007 June');

// check if the first date EQuals the second one
$true = Date::eq('2007 June', new DateTime('2007-06-01'));

// check if the first date does Not EQual the second one
$false = Date::neq(new DateTime('2007-06-01'), '2007 June');

// check if the first date is Greater Than or Equals the second one
$true = Date::gte('2007 June', new DateTime('2007-06-01'));

// check if the first date is Greater Than the second one
$false = Date::gt(new DateTime('2007-06-01'), '2007 June');
```
### Find the earliest date
Both strings, array and DateTime objects are allowed as parameters. You can also pass unlimited arguments.

It returns the string or the DateTime instance with the earliest date.

```php
// '03/10/1998'
$string = Date::earliest(array('03/10/1998', new DateTime('2006-12-09'), 'yesterday'));

// the DateTime with the date '2009-03-06'
$DateTime = Date::earliest('next Wednesday', new DateTime('2009-03-06'), '19 Nov 2010');
```
### Find the latest date
Both strings, array and DateTime objects are allowed as parameters. You can also pass unlimited arguments.

It returns the string or the DateTime instance with the latest date.

```php
// 'tomorrow'
$string = Date::latest('tomorrow', '10 January 2015', new DateTime('2014-11-04'));

// the DateTime with the date '2016-01-01'
$DateTime = Date::latest(array('last Friday', new DateTime('2016-01-01'), '10/06/80'));
```
### Find all the dates before a date
Both string and DateTime object are allowed as first parameter.

It returns only strings and DateTime instances passed as second argument with dates before the first parameter.

```php
// array(DateTime('2000-09-16'), 'May 1st, 2009')
$array = Date::before('yesterday', array(new DateTime('2000-09-16'), 'tomorrow', 'May 1st, 2009'));

// array(DateTime('2009-03-06'), '19 Nov 2010')
$array = Date::before(new DateTime('2014-01-01'), array(new DateTime('2009-03-06'), '19 Nov 2010', 'July 1st, 2015'));
```
### Find all the dates after a date
Both string and DateTime object are allowed as first parameter.

It returns only strings and DateTime instances passed as second argument with dates after the first parameter.

```php
// array(DateTime('2007-10-28'), 'next Monday')
$array = Date::after('March 1879', array(new DateTime('2007-10-28'), 'next Monday', 'February 1879'));

// array(DateTime('2003-02-14'), 'now')
$array = Date::after(new DateTime('2002-02-20'), array(new DateTime('2003-02-14'), 'now', '12/31/2001'));
```
### Sort dates in ascending order
Both strings, array and DateTime objects are allowed as parameters. You can also pass unlimited arguments.

It returns an array with the strings and DateTime instances sorted in ascending order.

```php
// array('Apr-17-1790', 'June 2008', new DateTime('2015-02-01'))
$array = Date::sort('June 2008', new DateTime('2015-02-01'), 'Apr-17-1790');

// array(new DateTime('2014-11-22'), 'yesterday', 'next Wednesday')
$array = Date::sort(array('next Wednesday', new DateTime('2014-11-22'), 'yesterday'));
```
### Sort dates in descending order
Both strings, array and DateTime objects are allowed as parameters. You can also pass unlimited arguments.

It returns an array with the strings and DateTime instances sorted in descending order.

```php
// array(new DateTime('2015-02-01'), 'June 2008', 'Apr-17-1790')
$array = Date::reverse('June 2008', new DateTime('2015-02-01'), 'Apr-17-1790');

// array('next Wednesday', 'yesterday', new DateTime('2014-11-22'))
$array = Date::reverse(array('next Wednesday', new DateTime('2014-11-22'), 'yesterday'));
```
### Create a range of dates
Both strings and DateTime objects are allowed as first and second parameter. Optionally you can set a step.

It returns an array with all DateTime instances between the starting date and the ending date (included).

```php
// array of 22 DateTime instances, from 2008-06-10 to 2008-07-01 included
$array = Date::range('10-June 2008', new DateTime('July 1st, 2008'));

// array of 11 DateTime instances, only even dates from 2008-06-10 to 2008-06-30 included
$array = Date::range('10-June 2008', new DateTime('July 1st, 2008'), 2);
```
### Check if a date is present in an array
Both strings and DateTime objects are allowed as first parameter.

```php
$true = Date::inArray('03/06/09', array(new DateTime('2009-03-06'), '19 Nov 2010'));

$true = Date::inArray(new DateTime('2004-09-21'), array('last week', '21 Sep 2004'));

$false = Date::inArray('now', array('yesterday', 'tomorrow'));
```

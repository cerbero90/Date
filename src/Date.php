<?php namespace Cerbero;

use DateTime;
use DatePeriod;
use DateInterval;

/**
 * Framework agnostic tool to work with dates.
 *
 * @author	Andrea Marco Sartori
 */
class Date {

	/**
	 * Create one or many dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	DateTime|array
	 */
	public static function create()
	{
		$args = static::listArgs(func_get_args());

		$dates = array_map('static::createDate', $args);

		return static::oneOrMany($dates);
	}

	/**
	 * Dynamically retrieve an array of arguments.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$args
	 * @return	array
	 */
	protected static function listArgs($args)
	{
		return is_array($args[0]) ? $args[0] : $args;
	}

	/**
	 * Create a date from a valid string or a DateTime instance.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date
	 * @return	DateTime
	 */
	protected static function createDate($date)
	{
		if($date instanceof DateTime) return $date;

		if(static::isValid($date))
		{
			return new DateTime($date);
		}

		throw new \InvalidArgumentException("The provided date is not valid: {$date}");
	}

	/**
	 * Retrieve one or many dates depending on the size of the given array.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$dates
	 * @return	mixed
	 */
	protected static function oneOrMany(array $dates)
	{
		return count($dates) == 1 ? $dates[0] : $dates;
	}

	/**
	 * Check if a string date is valid.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$date
	 * @return	boolean
	 */
	public static function isValid($date)
	{
		return strtotime($date) !== false;
	}

	/**
	 * Format a given date or array of dates by using the given format.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime|array	$date
	 * @param	string	$format
	 * @return	string|array
	 */
	public static function format($date, $format)
	{
		$results = array();

		$dates = static::forceArray($date);

		foreach ($dates as $date)
		{
			$results[] = $date->format($format);
		}

		return static::oneOrMany($results);
	}

	/**
	 * Retrieve always an array even if it deals with only one date.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime|array	$date
	 * @return	array
	 */
	protected static function forceArray($date)
	{
		$date = static::create($date);

		return is_array($date) ? $date : array($date);
	}

	/**
	 * Calculate the difference between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	integer
	 */
	public static function gap($date1, $date2)
	{
		$keys = array('years', 'months', 'days', 'hours', 'minutes', 'seconds');

		$gap = static::calculateGap($date1, $date2, '%y %m %d %h %i %s');

		$values = array_map('intval', explode(' ', $gap));

		return array_combine($keys, $values);
	}

	/**
	 * Calculate the gap between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @param	string	$format
	 * @return	string
	 */
	protected static function calculateGap($date1, $date2, $format)
	{
		list($date1, $date2) = static::create($date1, $date2);

		return $date1->diff($date2)->format($format);
	}

	/**
	 * Calculate the difference in days between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	integer
	 */
	public static function gapInDays($date1, $date2)
	{
		return (int) static::calculateGap($date1, $date2, '%a');
	}

	/**
	 * Calculate the difference in months between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	integer
	 */
	public static function gapInMonths($date1, $date2)
	{
		$months = static::calculateGap($date1, $date2, '%m');

		return static::gapInYears($date1, $date2) * 12 + $months;
	}

	/**
	 * Calculate the difference in years between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	integer
	 */
	public static function gapInYears($date1, $date2)
	{
		return (int) static::calculateGap($date1, $date2, '%y');
	}

	/**
	 * Calculate the difference in seconds between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	integer
	 */
	public static function gapInSeconds($date1, $date2)
	{
		list($date1, $date2) = static::timestamp(array($date1, $date2));

		return abs($date1 - $date2);
	}

	/**
	 * Calculate the difference in minutes between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	integer
	 */
	public static function gapInMinutes($date1, $date2)
	{
		$seconds = static::gapInSeconds($date1, $date2);

		return intval($seconds / 60);
	}

	/**
	 * Calculate the difference in hours between two dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	integer
	 */
	public static function gapInHours($date1, $date2)
	{
		$seconds = static::gapInSeconds($date1, $date2);

		return intval($seconds / 3600);
	}

	/**
	 * Retrieve the UNIX timestamp of a date or array of dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime|array	$date
	 * @return	integer|array
	 */
	public static function timestamp($date)
	{
		if(is_array($date))
		{
			return array_map('static::timestamp', $date);
		}

		return static::create($date)->getTimestamp();
	}

	/**
	 * Check if a date is less than another one.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	boolean
	 */
	public static function lt($date1, $date2)
	{
		list($date1, $date2) = static::create($date1, $date2);

		return $date1 < $date2;
	}

	/**
	 * Check if the first date is less than or equal the second date.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	boolean
	 */
	public static function lte($date1, $date2)
	{
		list($date1, $date2) = static::create($date1, $date2);

		return $date1 <= $date2;
	}

	/**
	 * Check if two dates are equal.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	boolean
	 */
	public static function eq($date1, $date2)
	{
		list($date1, $date2) = static::create($date1, $date2);

		return $date1 == $date2;
	}

	/**
	 * Check if two dates are not equal.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	boolean
	 */
	public static function neq($date1, $date2)
	{
		return ! static::eq($date1, $date2);
	}

	/**
	 * Check if a date is greater than or equal another one.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	boolean
	 */
	public static function gte($date1, $date2)
	{
		list($date1, $date2) = static::create($date1, $date2);

		return $date1 >= $date2;
	}

	/**
	 * Check if a date is greater than another one.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date1
	 * @param	string|DateTime	$date2
	 * @return	boolean
	 */
	public static function gt($date1, $date2)
	{
		list($date1, $date2) = static::create($date1, $date2);

		return $date1 > $date2;
	}

	/**
	 * Retrieve the earliest date of the given dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string|DateTime
	 */
	public static function earliest()
	{
		$dates = static::listArgs(func_get_args());

		return array_reduce($dates, function($carry, $date)
		{
			return static::lt($carry, $date) ? $carry : $date;

		}, $dates[0]);
	}

	/**
	 * Retrieve the latest date of the given dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string|DateTime
	 */
	public static function latest()
	{
		$dates = static::listArgs(func_get_args());

		return array_reduce($dates, function($carry, $date)
		{
			return static::gt($carry, $date) ? $carry : $date;

		}, $dates[0]);
	}

	/**
	 * Retrieve an array of dates before a given date.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date
	 * @param	array	$dates
	 * @return	array
	 */
	public static function before($date, array $dates)
	{
		$filtered = array_filter($dates, function($item) use($date)
		{
			return static::lt($item, $date);
		});

		return array_merge($filtered);
	}

	/**
	 * Retrieve an array of dates after a given date.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date
	 * @param	array	$dates
	 * @return	array
	 */
	public static function after($date, array $dates)
	{
		$filtered = array_filter($dates, function($item) use($date)
		{
			return static::gt($item, $date);
		});

		return array_merge($filtered);
	}

	/**
	 * Sort the given dates in ascending order.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	public static function sort()
	{
		$dates = static::listArgs(func_get_args());

		usort($dates, 'static::gt');

		return $dates;
	}

	/**
	 * Sort the given dates in descending order.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	array
	 */
	public static function reverse()
	{
		$dates = static::listArgs(func_get_args());

		usort($dates, 'static::lt');

		return $dates;
	}

	/**
	 * Retrieve a range of dates, it's possible to set the step between dates.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$start
	 * @param	string|DateTime	$end
	 * @param	integer	$step
	 * @return	array
	 */
	public static function range($start, $end, $step = 1)
	{
		list($start, $end) = static::sort($start, $end);

		return iterator_to_array(static::createPeriod($start, $end, $step));
	}

	/**
	 * Create a period from $start to $end.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$start
	 * @param	string|DateTime	$end
	 * @param	integer	$step
	 * @return	DatePeriod
	 */
	protected static function createPeriod($start, $end, $step)
	{
		list($start, $end) = static::create($start, $end);

		$end->modify('+1 day'); // otherwise $end wouldn't be included

		$interval = new DateInterval("P{$step}D");

		return new DatePeriod($start, $interval, $end);
	}

	/**
	 * Check if a date is included in a given array.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string|DateTime	$date
	 * @param	array	$dates
	 * @return	boolean
	 */
	public static function inArray($date, array $dates)
	{
		$date = static::create($date);

		$dates = static::create($dates);

		return array_search($date, $dates) !== false;
	}

}
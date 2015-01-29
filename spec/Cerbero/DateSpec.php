<?php

namespace spec\Cerbero;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use DateTime;

class DateSpec extends ObjectBehavior
{
    function let()
    {
        date_default_timezone_set('Europe/Rome');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Cerbero\Date');
    }

    /**
     * @testdox	It creates a date from a string.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_creates_a_date_from_a_string()
    {
    	$date = static::create('2000-01-01');

    	$date->shouldBeAnInstanceOf('DateTime');

    	$date->format('d/m/Y')->shouldReturn('01/01/2000');
    }

    /**
     * @testdox	It creates multiple dates by passing many parameters.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_creates_multiple_dates_by_passing_many_parameters()
    {
    	$dates = static::create('2000-01-01', '2000-01-02');

    	$dates[0]->shouldBeAnInstanceOf('DateTime');
    	$dates[0]->format('d/m/Y')->shouldReturn('01/01/2000');

    	$dates[1]->shouldBeAnInstanceOf('DateTime');
    	$dates[1]->format('d/m/Y')->shouldReturn('02/01/2000');
    }

    /**
     * @testdox	It creates multiple dates by passing an array.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_creates_multiple_dates_by_passing_an_array()
    {
    	$dates = static::create(array('2000-01-01', '2000-01-02'));

    	$dates[0]->shouldBeAnInstanceOf('DateTime');
    	$dates[0]->format('d/m/Y')->shouldReturn('01/01/2000');

    	$dates[1]->shouldBeAnInstanceOf('DateTime');
    	$dates[1]->format('d/m/Y')->shouldReturn('02/01/2000');
    }

    /**
     * @testdox	It throws an exception when trying to create a date from an invalid string.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_throws_an_exception_when_trying_to_create_a_date_from_an_invalid_string()
    {
    	$this->shouldThrow('InvalidArgumentException')->duringCreate('2000.01.01');
    }

    /**
     * @testdox	It simply returns the given object when trying to create a date from a DateTime.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_simply_returns_the_given_object_when_trying_to_create_a_date_from_a_DateTime()
    {
    	$date = new DateTime('2000-01-01');

    	static::create($date)->shouldReturn($date);
    }

    /**
     * @testdox	It checks if a given string is a valid date.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_a_given_string_is_a_valid_date()
    {
    	static::isValid('01/13/2000')->shouldReturn(true);

    	static::isValid('13/01/2000')->shouldReturn(false);
    }

    /**
     * @testdox	It formats a string of date.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_formats_a_string_of_date()
    {
    	static::format('2000-10-01', 'd/m/Y')->shouldReturn('01/10/2000');
    }

    /**
     * @testdox	It formats an array of dates.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_formats_an_array_of_dates()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-03');
		$four  = new DateTime('2000-01-04');

        $expected = array('01/01/2000', '02/01/2000', '03/01/2000', '04/01/2000');

		static::format(array($one, $two, $three, $four), 'd/m/Y')->shouldReturn($expected);
    }

    /**
     * @testdox	It formats an array of dates of given strings and DateTime objects.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_formats_an_array_of_dates_of_given_strings_and_DateTime_objects()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-03';
		$four  = new DateTime('2000-01-04');

        $expected = array('01/01/2000', '02/01/2000', '03/01/2000', '04/01/2000');

    	static::format(array($one, $two, $three, $four), 'd/m/Y')->shouldReturn($expected);
    }

    /**
     * @testdox	It calculates the difference in days between two dates.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_calculates_the_difference_in_days_between_two_dates()
    {
    	static::gap('2000-01-01', '2000-01-10')->shouldReturn(9);

    	static::gap('2000-01-10', '2000-01-01')->shouldReturn(9);
    }

    /**
     * @testdox	It retrieves the UNIX timestamp of a string.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_UNIX_timestamp_of_a_string()
    {
    	static::timestamp('2000-01-01')->shouldReturn(946681200);
    }

    /**
     * @testdox	It retrieves the UNIX timestamp of a date.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_UNIX_timestamp_of_a_date()
    {
    	static::timestamp(new DateTime('2000-01-01'))->shouldReturn(946681200);
    }

    /**
     * @testdox	It retrieves the UNIX timestamp of an array of dates.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_UNIX_timestamp_of_an_array_of_dates()
    {
		$one   = new DateTime('2000-01-01');
		$two   = '2000-01-02';
		$three = new DateTime('2000-01-03');

    	static::timestamp(array($one, $two, $three))->shouldReturn(array(946681200, 946767600, 946854000));
    }

    /**
     * @testdox	It checks if two dates are equal.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_two_dates_are_equal()
    {
    	static::eq('2000-01-01', '2000-01-01')->shouldReturn(true);

    	static::eq('2000-01-02', '2000-01-01')->shouldReturn(false);

    	static::eq('2000-01-01', '2000-01-02')->shouldReturn(false);
    }

    /**
     * @testdox	It checks if two dates are not equal.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_two_dates_are_not_equal()
    {
    	static::neq('2000-01-01', '2000-01-01')->shouldReturn(false);

    	static::neq('2000-01-02', '2000-01-01')->shouldReturn(true);

    	static::neq('2000-01-01', '2000-01-02')->shouldReturn(true);
    }

    /**
     * @testdox	It checks if a date is less than another one.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_a_date_is_less_than_another_one()
    {
    	static::lt('2000-01-01', '2000-01-02')->shouldReturn(true);

    	static::lt('2000-01-02', '2000-01-02')->shouldReturn(false);

    	static::lt('2000-01-02', '2000-01-01')->shouldReturn(false);
    }

    /**
     * @testdox	It checks if a date is less then or equal to another date.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_a_date_is_less_then_or_equal_to_another_date()
    {
    	static::lte('2000-01-01', '2000-01-02')->shouldReturn(true);

    	static::lte('2000-01-01', '2000-01-01')->shouldReturn(true);

    	static::lte('2000-01-02', '2000-01-01')->shouldReturn(false);
    }

    /**
     * @testdox	It checks if a date is greater than another one.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_a_date_is_greater_than_another_one()
    {
    	static::gt('2000-01-02', '2000-01-01')->shouldReturn(true);

    	static::gt('2000-01-01', '2000-01-01')->shouldReturn(false);

    	static::gt('2000-01-01', '2000-01-02')->shouldReturn(false);
    }

    /**
     * @testdox	It checks if a date is greater than or equal to another one.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_a_date_is_greater_than_or_equal_to_another_one()
    {
    	static::gte('2000-01-02', '2000-01-01')->shouldReturn(true);

    	static::gte('2000-01-01', '2000-01-01')->shouldReturn(true);

    	static::gte('2000-01-01', '2000-01-02')->shouldReturn(false);
    }

    /**
     * @testdox	It retrieves the earliest date of given strings.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_earliest_date_of_given_strings()
    {
		$one   = '2000-01-01';
		$two   = '2000-01-02';
		$three = '2000-01-02';
		$four  = '2000-01-03';

    	static::earliest($two, $four, $three, $one)->shouldReturn($one);
    }

    /**
     * @testdox	It retrieves the earliest date of given DateTime objects.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_earliest_date_of_given_DateTime_objects()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-02');
		$four  = new DateTime('2000-01-03');

    	static::earliest($three, $one, $two, $four)->shouldReturn($one);
    }

    /**
     * @testdox	It retrieves the earliest date of given strings and objects.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_earliest_date_of_given_strings_and_objects()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::earliest($two, $three, $one, $four)->shouldReturn($one);
    }

    /**
     * @testdox	It retrieves the earliest date in a given array.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_earliest_date_in_a_given_array()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::earliest(array($three, $two, $four, $one))->shouldReturn($one);
    }

    /**
     * @testdox    It retrieves dates before a given date.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_retrieves_dates_before_a_given_date()
    {
        $one   = new DateTime('2000-01-01');
        $two   = '2000-01-02';
        $three = new DateTime('2000-01-03');
        $four  = new DateTime('2000-01-04');

        static::before('2000-01-03', array($one, $two, $three, $four))->shouldReturn(array($one, $two));
    }

    /**
     * @testdox    It retrieves dates after a given date.
     *
     * @author    Andrea Marco Sartori
     * @return    void
     */
    public function it_retrieves_dates_after_a_given_date()
    {
        $one   = new DateTime('2000-01-01');
        $two   = '2000-01-02';
        $three = new DateTime('2000-01-03');
        $four  = new DateTime('2000-01-04');

        static::after('2000-01-01', array($one, $two, $three, $four))->shouldReturn(array($two, $three, $four));
    }

    /**
     * @testdox	It retrieves the latest date of given strings.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_latest_date_of_given_strings()
    {
		$one   = '2000-01-01';
		$two   = '2000-01-02';
		$three = '2000-01-02';
		$four  = '2000-01-03';

    	static::latest($two, $four, $three, $one)->shouldReturn($four);
    }

    /**
     * @testdox	It retrieves the latest date of given DateTime objects.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_latest_date_of_given_DateTime_objects()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-02');
		$four  = new DateTime('2000-01-03');

    	static::latest($three, $one, $two, $four)->shouldReturn($four);
    }

    /**
     * @testdox	It retrieves the latest date of given strings and objects.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_latest_date_of_given_strings_and_objects()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::latest($two, $three, $one, $four)->shouldReturn($four);
    }

    /**
     * @testdox	It retrieves the latest date in a given array.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_retrieves_the_latest_date_in_a_given_array()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::latest(array($three, $two, $four, $one))->shouldReturn($four);
    }

    /**
     * @testdox	It sorts date strings in ascending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_date_strings_in_ascending_order()
    {
		$one   = '2000-01-01';
		$two   = '2000-01-02';
		$three = '2000-01-02';
		$four  = '2000-01-03';

    	static::sort($four, $three, $one, $two)->shouldReturn(array($one, $two, $three, $four));
    }

    /**
     * @testdox	It sorts DateTime objects in ascending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_DateTime_objects_in_ascending_order()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-02');
		$four  = new DateTime('2000-01-03');

    	static::sort($three, $one, $two, $four)->shouldReturn(array($one, $three, $two, $four));
    }

    /**
     * @testdox	It sorts strings and DateTime objects in ascending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_strings_and_DateTime_objects_in_ascending_order()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::sort($two, $three, $one, $four)->shouldReturn(array($one, $three, $two, $four));
    }

    /**
     * @testdox	It sorts an array of dates in ascending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_an_array_of_dates_in_ascending_order()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::sort(array($three, $two, $four, $one))->shouldReturn(array($one, $two, $three, $four));
    }

    /**
     * @testdox	It sorts date strings in decending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_date_strings_in_decending_order()
    {
		$one   = '2000-01-01';
		$two   = '2000-01-02';
		$three = '2000-01-02';
		$four  = '2000-01-03';

    	static::reverse($four, $three, $one, $two)->shouldReturn(array($four, $three, $two, $one));
    }

    /**
     * @testdox	It sorts DateTime objects in decending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_DateTime_objects_in_decending_order()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-02');
		$four  = new DateTime('2000-01-03');

    	static::reverse($three, $one, $two, $four)->shouldReturn(array($four, $two, $three, $one));
    }

    /**
     * @testdox	It sorts strings and DateTime objects in decending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_strings_and_DateTime_objects_in_decending_order()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::reverse($two, $three, $one, $four)->shouldReturn(array($four, $three, $two, $one));
    }

    /**
     * @testdox	It sorts an array of dates in decending order.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_sorts_an_array_of_dates_in_decending_order()
    {
    	$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = '2000-01-02';
		$four  = new DateTime('2000-01-03');

    	static::reverse(array($three, $two, $four, $one))->shouldReturn(array($four, $two, $three, $one));
    }

    /**
     * @testdox	It returns a range of dates.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_a_range_of_dates()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-03');
		$four  = new DateTime('2000-01-04');

    	static::range('2000-01-01', '2000-01-04')->shouldBeLike(array($one, $two, $three, $four));
    }

    /**
     * @testdox	It returns a range of dates with the given step.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_a_range_of_dates_with_the_given_step()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-03');
		$three = new DateTime('2000-01-05');
		$four  = new DateTime('2000-01-07');

    	static::range('2000-01-01', '2000-01-08', 2)->shouldBeLike(array($one, $two, $three, $four));
    }

    /**
     * @testdox	It returns a range of dates even if the start date is greater than the end date.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_returns_a_range_of_dates_even_if_the_start_date_is_greater_than_the_end_date()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-03');
		$four  = new DateTime('2000-01-04');

    	static::range('2000-01-04', '2000-01-01')->shouldBeLike(array($one, $two, $three, $four));
    }

    /**
     * @testdox	It checks if a given string date is included in a given array.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_a_given_string_date_is_included_in_a_given_array()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-03');
		$four  = new DateTime('2000-01-04');

    	static::inArray('2000-01-03', array($one, $two, $three, $four))->shouldReturn(true);

    	static::inArray('2000-01-05', array($one, $two, $three, $four))->shouldReturn(false);
    }

    /**
     * @testdox	It checks if a given DateTime object is included in a given array.
     *
     * @author	Andrea Marco Sartori
     * @return	void
     */
    public function it_checks_if_a_given_DateTime_object_is_included_in_a_given_array()
    {
		$one   = new DateTime('2000-01-01');
		$two   = new DateTime('2000-01-02');
		$three = new DateTime('2000-01-03');
		$four  = new DateTime('2000-01-04');

    	static::inArray(new DateTime('2000-01-02'), array($one, $two, $three, $four))->shouldReturn(true);

    	static::inArray(new DateTime('2000-01-05'), array($one, $two, $three, $four))->shouldReturn(false);
    }
}

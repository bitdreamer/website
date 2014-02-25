/* OurCalendarHelper.java.  Copyright 2003 by Meredith College,
										Raleigh, NC, USA.

	original author: April Austin for CSC407, Software Engineering

	OurCalendarHelper.java is created for use by the recruiting
	web site for computer studies at Meredith.  It inherits from
	the GregorianCalendar class and adds functionalities
	tailored specifically for the needs of other classes used
	by the Meredith computer studies recruiting web site.
	It allows for the construction of a calendar using month
	numbers the way most people are used to (1=Jan, 2=Feb, etc.)
	rather than the way GregorianCalendar requires.
	(0=Jan, 1=Feb, etc.)  This allows webmaster, faculty members,
	etc. to easily make use of the class without knowing and
	accommodating that quirk of GregorianCalendar.  The constructor
	also allows the components of the date to be passed in the
	order that is commonly used in the US: month, day, year.

	Additional services provided by OurCalendarHelper.java:

	-	Parse a String representation of a date if it is in
		a common DD/MM/YY or similar format;
		full details of parseable formats are in the comments for the
		OurCalendarHelper(String date, String delim) constructor.
	-	monthAbbrev(): Provide a String representation (abbreviation)
		of the month held by the calendar
	-	monthDayFormat(): Provide a String representation of the
		month and day, e.g. "Jan 6"
	-	numericFormat(): Provide a String representation of the
		calendar's date in the format MM/DD/YYYY, e.g. "1/6/2005"
	-	deepCopy(OurCalendarHelper original): Make and return a
		deep copy (separate object, not just another pointer to
		the same object) of the calendar received as its argument

	A "main" method is provided for testing purposes.
*/

import java.util.*;

public class OurCalendarHelper extends GregorianCalendar
{
	/* OurCalendarHelper.  Default constructor.  Constructs a
		default OurCalendarHelper using the current time
		in the default time zone with the default locale.
	*/
	public OurCalendarHelper()
	{	super();
	}

	/* OurCalendarHelper.  Constructor.  Constructs an
		OurCalendarHelper with the given date, set in the
		default time zone with the default locale.  The
		parameters are as follows:

		month: The common U.S. way of numbering.
				i.e. 1 = Jan, 2 = Feb, etc.  This differs from
				the GregorianCalendar numbering, in which
				0 = Jan, 1 = Feb, etc.
		dayOfMonth: the day of the month, i.e. 1, 2, 3, etc.
		year: four-digit year, i.e. 2003
	*/
	public OurCalendarHelper(int month, int dayOfMonth, int year)
	{
		super(year, month - 1, dayOfMonth);
	}

	/* OurCalendarHelper.  Constructor.  Constructs an
		OurCalendarHelper with the given date, set in the
		default time zone with the default locale.  The
		parameters are

		date: String representation of a date, in the format
				MM[delim]DD[delim]YY or MM[delim]DD[delim]YYYY
				where [delim] would be replaced by some delimiter.
				Numbers for month and day can be either one or
				two digits in length; year can be two or four digits.
				Examples: 01/1/05
						  1-1-2005
						  1,01,05
						  01 01 2005
						  01blah01blah2005
				The last example in the list is meant only to
				demonstrate use of a delimiter that is longer
				than one character, not to recommend "blah" as
				a delimiter.
		delim: The delimiter used in the date String
	*/
	public OurCalendarHelper(String date, String delim)
	{
		super();
		int year = parseYear(date, delim);
		int month = parseMonth(date, delim) - 1;
		int dayOfMonth = parseDay(date, delim);
		set(year, month, dayOfMonth);
	}

	/* parseYear.  Takes a string representation of a date and
		returns an int that represents the correct year for use by
		the GregorianCalendar class.  The parameters are

		date: String representation of a date, in the format
				MM[delim]DD[delim]YY or MM[delim]DD[delim]YYYY
				where [delim] would be replaced by some delimiter.
				Numbers for month and day can be either one or
				two digits in length; year can be two or four digits.
				Examples: 01/1/05
						  1-1-2005
						  1,01,05
						  01 01 2005
						  01blah01blah2005
				The last example in the list is meant only to
				demonstrate use of a delimiter that is longer
				than one character, not to recommend "blah" as
				a delimiter.
		delim: The delimiter used in the date String

		This method finds the last occurrence of the specified
		delimiter and pulls off the rest of the date string
		(everything after the delimiter).  The method then checks
		that the resulting substring can be converted into a
		2-digit or 4-digit integer.  If so, all is well; a 2-digit
		integer is converted to a 4-digit one (assuming the 21st
		century); a 4-digit integer is returned from the method.
		If the substring does not pass all the checks, then an
		appropriate error message is printed and -1 is returned.
		Note that handing a negative number to the superconstructor
		does NOT result in an exception.  That class simply makes
		its best guess as to how to interpret the number.  That is
		why this class prints an error message when the -1 value
		is being returned.
	*/
	private int parseYear(String date, String delim)
	{
		int year = -1;
		int index = date.lastIndexOf(delim);

		/* if the specified delimiter is found in the date String,
			then proceed.  Otherwise, an error message is printed
			and -1 is returned.
		*/
		if(index != -1)
		{
			boolean yearOK = false;
			int numDigits = 0;

			String yearStr = date.substring(index + delim.length());
			numDigits = yearStr.length();
			// year must pass two validity tests: (1)must be either
			// 2 or 4 digits and (2)must be convertible into an int.
			// otherwise, an error message prints and 0 is returned.
			if(numDigits == 2 || numDigits == 4)
			{
				yearOK = true;
				try
				{	year = Integer.parseInt(yearStr);
				}
				catch(Exception e)
				{	yearOK = false;
				}
			}
			if(yearOK == false)
			{
				System.out.println("WARNING: An invalid year was "
					+ "encountered by the OurCalendarHelper class."
					+ "  The date in the resulting "
					+ "OurCalendarHelper object may not be the "
					+ "date that the user intended.");
			}
			else // yearOK == true, so proceed with processing
			{
				if(numDigits == 2)
				{	year = year + 2000; // convert to 4-digit year
				}
			}
		}
		else // the specified delimiter was not found in the date String
		{
			System.out.println("WARNING: OurCalendarHelper class "
				+ "has processed a String representation of "
				+ "a date which does not contain the specified "
				+ "delimiter.  The date in the resulting "
				+ "OurCalendarHelper object may not be the "
				+ "date that the user intended.");
		}
		return year; // value of year is -1 if there were problems
					// in the date String; each possible problem
					// has an error message associated with it
					// within this method
	}

	/* parseMonth.  Takes a string representation of a date and
		returns an int that represents the month using the common
		US numbers (1=Jan, 2=Feb, etc.)
		The parameters are

		date: String representation of a date, in the format
				MM[delim]DD[delim]YY or MM[delim]DD[delim]YYYY
				where [delim] would be replaced by some delimiter.
				Numbers for month and day can be either one or
				two digits in length; year can be two or four digits.
				Examples: 01/1/05
						  1-1-2005
						  1,01,05
						  01 01 2005
						  01blah01blah2005
				The last example in the list is meant only to
				demonstrate use of a delimiter that is longer
				than one character, not to recommend "blah" as
				a delimiter.
		delim: The delimiter used in the date String

		This method finds the first occurrence of the specified
		delimiter and pulls off the beginning of the date string
		(everything before the delimiter).  The method then checks
		that the resulting substring can be converted into a
		1- or 2-digit integer.  If so, all is well.
		If the substring does not pass all the checks, then an
		appropriate error message is printed and -1 is returned.
		Note that handing a negative number to the superconstructor
		does NOT result in an exception.  That class simply makes
		its best guess as to how to interpret the number.  That is
		why this class prints an error message when the -1 value
		is being returned.
	*/
	private int parseMonth(String date, String delim)
	{
		int month = -1;
		int index = date.indexOf(delim);

		/* if the specified delimiter is found in the date String,
			then proceed.  Otherwise, an error message is printed
			and -1 is returned.
		*/
		if(index != -1)
		{
			boolean monthOK = false;
			int numDigits = 0;

			String monthStr = date.substring(0, index);
			numDigits = monthStr.length();
			// month must pass two validity tests: (1)must be either
			// 1 or 2 digits and (2)must be convertible into an int.
			// otherwise, an error message prints and -1 is returned.
			if(numDigits == 1 || numDigits == 2)
			{
				monthOK = true;
				try
				{	month = Integer.parseInt(monthStr);
				}
				catch(Exception e)
				{	monthOK = false;
				}
			}
			if(monthOK == false)
			{
				System.out.println("WARNING: An invalid month was "
					+ "encountered by the OurCalendarHelper class."
					+ "  The date in the resulting "
					+ "OurCalendarHelper object may not be the "
					+ "date that the user intended.");
			}
		}
		else // the specified delimiter was not found in the date String
		{
			System.out.println("WARNING: OurCalendarHelper class "
				+ "has processed a String representation of "
				+ "a date which does not contain the specified "
				+ "delimiter.  The date in the resulting "
				+ "OurCalendarHelper object may not be the "
				+ "date that the user intended.");
		}
		return month; // value of month is -1 if there were problems
					// in the date String; each possible problem
					// has an error message associated with it
					// within this method
	}

	/* parseDay.  Takes a string representation of a date and
		returns an int that represents the correct day of the month
		for use by the GregorianCalendar class.  The parameters are

		date: String representation of a date, in the format
				MM[delim]DD[delim]YY or MM[delim]DD[delim]YYYY
				where [delim] would be replaced by some delimiter.
				Numbers for month and day can be either one or
				two digits in length; year can be two or four digits.
				Examples: 01/1/05
						  1-1-2005
						  1,01,05
						  01 01 2005
						  01blah01blah2005
				The last example in the list is meant only to
				demonstrate use of a delimiter that is longer
				than one character, not to recommend "blah" as
				a delimiter.
		delim: The delimiter used in the date String

		This method looks for the first and last occurrences of
		the specified delimiter and pulls off the portion
		of the date string that lies between the first and last
		occurrences of the delimiter.  The method then checks
		that the resulting substring can be converted into a
		1- or 2-digit integer.  If so, all is well.
		If the substring does not pass all the checks, then an
		appropriate error message is printed and -1 is returned.
		Note that handing a negative number to the superconstructor
		does NOT result in an exception.  That class simply makes
		its best guess as to how to interpret the number.  That is
		why this class prints an error message when the -1 value
		is being returned.
	*/
	private int parseDay(String date, String delim)
	{
		int day = -1;
		int firstIndex = date.indexOf(delim);
		int lastIndex = date.lastIndexOf(delim);

		/* if the specified delimiter is found twice in the date
			String, take the substring that occurs between them.
			Otherwise, an error message is printed and -1
			is returned.
		*/
		if(firstIndex != -1 && lastIndex != -1)
		{
			boolean dayOK = false;
			int numDigits = 0;

			firstIndex = firstIndex + delim.length();
			String dayStr = date.substring(firstIndex, lastIndex);
			numDigits = dayStr.length();
			// day must pass two validity tests: (1)must be either
			// 1 or 2 digits and (2)must be convertible into an int.
			// otherwise, an error message prints and -1 is returned.
			if(numDigits == 1 || numDigits == 2)
			{
				dayOK = true;
				try
				{	day = Integer.parseInt(dayStr);
				}
				catch(Exception e)
				{	dayOK = false;
				}
			}
			if(dayOK == false)
			{
				System.out.println("WARNING: An invalid day-of-month "
					+ "was encountered by the OurCalendarHelper class."
					+ "  The date in the resulting "
					+ "OurCalendarHelper object may not be the "
					+ "date that the user intended.");
			}
		}
		else // the specified delimiter was not found twice in the
		{											// date String
			System.out.println("WARNING: OurCalendarHelper class "
				+ "has processed a String representation of "
				+ "a date which does not contain two occurrences "
				+ "of the specified "
				+ "delimiter.  The date in the resulting "
				+ "OurCalendarHelper object may not be the "
				+ "date that the user intended.");
		}
		return day; // value of day is -1 if there were problems
					// in the date String; each possible problem
					// has an error message associated with it
					// within this method
	}

	/* monthAbbrev.  Returns a String that is a 3-letter
		abbreviation of the name for the month held by the
		OurCalendarHelper object.
	*/
	public String monthAbbrev()
	{
		String abbrev;
		int num = get(Calendar.MONTH);
		switch(num)
		{
			case Calendar.JANUARY:
				abbrev = "Jan";
				break;
			case Calendar.FEBRUARY:
				abbrev = "Feb";
				break;
			case Calendar.MARCH:
				abbrev = "Mar";
				break;
			case Calendar.APRIL:
				abbrev = "Apr";
				break;
			case Calendar.MAY:
				abbrev = "May";
				break;
			case Calendar.JUNE:
				abbrev = "Jun";
				break;
			case Calendar.JULY:
				abbrev = "Jul";
				break;
			case Calendar.AUGUST:
				abbrev = "Aug";
				break;
			case Calendar.SEPTEMBER:
				abbrev = "Sep";
				break;
			case Calendar.OCTOBER:
				abbrev = "Oct";
				break;
			case Calendar.NOVEMBER:
				abbrev = "Nov";
				break;
			case Calendar.DECEMBER:
				abbrev = "Dec";
				break;
			default:
				abbrev = "Error in monthAbbrev method";
		}
		return abbrev;
	}

	/* monthDayFormat.  This method returns a String representing
		the month (alphabetic) and day (numeric) held by the
		OurCalendarHelper object.  Example: "Jan 6"
	*/
	public String monthDayFormat()
	{
		return monthAbbrev() + " " + get(Calendar.DAY_OF_MONTH);
	}

	/* numericFormat.  This method returns a String representing
		the date held by the OurCalendarHelper object, in
		MM/DD/YYYY format.  Example: "5/8/2003"
	*/
	public String numericFormat()
	{
		int month = get(Calendar.MONTH) + 1;
		int day = get(Calendar.DAY_OF_MONTH);
		int year = get(Calendar.YEAR);
		return month + "/" + day + "/" + year;
	}

	/* deepCopy.  Creates and returns an OurCalendarHelper
		object identical to, but separate from, the original.
		Changes to the copy do not affect the
		original because the returned object is a completely
		separate object, not just a new pointer to the same object.
	*/
	public OurCalendarHelper deepCopy()
	{
		int year = get(Calendar.YEAR);
		int month = get(Calendar.MONTH) + 1;
		int day = get(Calendar.DAY_OF_MONTH);

		return new OurCalendarHelper(month, day, year);
	}

	/* main.  For testing purposes only.  Constructs one of each
		type (i.e. uses each constructor once); makes a copy
		of one; makes changes to the copy; and prints each
		OurCalendarHelper in each of the available String formats.
	*/
	public static void main(String args[])
	{
		OurCalendarHelper defaultCal = new OurCalendarHelper();
		OurCalendarHelper intsCal = new OurCalendarHelper(5, 2, 2005);
		OurCalendarHelper stringsCal = new OurCalendarHelper("09/08/05",
																"/");
		OurCalendarHelper copy = stringsCal.deepCopy();
		copy.add(Calendar.MONTH, 2);
		copy.add(Calendar.DAY_OF_MONTH, -1);
		copy.add(Calendar.YEAR, -1);

		System.out.println("default:\n" + defaultCal.monthDayFormat()
						+ "\n" + defaultCal.numericFormat() + "\n\n");
		System.out.println("\"integers\" constructor:\n"
						+ intsCal.monthDayFormat()
						+ "\n" + intsCal.numericFormat() + "\n\n");
		System.out.println("\"Strings\" constructor:\n"
						+ stringsCal.monthDayFormat()
						+ "\n" + stringsCal.numericFormat() + "\n\n");
		System.out.println("\"modified copy of \"Strings\":\n"
						+ copy.monthDayFormat()
						+ "\n" + copy.numericFormat() + "\n\n");
	}
} // end of OurCalendarHelper class
/* MissingElementException.java.  Copyright 2003 by Meredith College,
													Raleigh, NC, USA.
	original author: April Austin

	MissingElementException.java is created for use by the recruiting
	web site for computer studies at Meredith.  It provides an
	exception message for indicating that an expected or required
	element was missing from an XML file or is in the wrong position
	in the sequence of the XML file.  The calling method has
	only to provide the name of the missing element; the rest of the
	message is provided by this class.
*/

public class MissingElementException extends RuntimeException
{
	public MissingElementException(String nameOfElement)
	{
		super(nameOfElement + " element was missing or out of "
				+ "sequence in the file being read.");
	}
}
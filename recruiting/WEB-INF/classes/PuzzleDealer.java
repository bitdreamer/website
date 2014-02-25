/* PuzzleDealer.java.  Copyright 2003 by Meredith College,
										Raleigh, NC, USA.

	original author: April Austin

	PuzzleDealer.java is created for use by the recruiting web site for
	computer studies at Meredith.  It is responsible for locating the
	Puzzle object specified by the calling method and setting/getting
	the various attributes of the specified puzzle.  It also keeps
	track of which puzzle is currently being featured.

	PuzzleDealer just deals puzzles, it doesn't make them.  It must
	receive a ready-made LinkedList of Puzzle objects at the time
	the PuzzleDealer is instantiated.

	Methods of this class that return a Puzzle object actually return
	a deep copy of the requested Puzzle; thus none of the original
	Puzzles in the list can be manipulated directly by an outside
	method.  All changes to
	any of the original Puzzles should be made by way of the methods
	in PuzzleDealer.

	Variables:
	private int featureIndex - position of the currently featured puzzle
						within the puzzles list
	private LinkedList puzzles - all the Puzzle objects that this
						dealer will deal
	private Puzzle currentFeature - the Puzzle currently being featured

	public static final int LABEL = 1  provides a more intuitive way to
						refer to the int that specifies to search for
						the Puzzle with a given value for its label
						(see the method
						getPuzzleIndex(int itemToSearch, String valueToFind)
						for an example)
	public static final int ID = 2  same idea as LABEL, except it specifies
						to search for the value of the Puzzle's id.
*/

import java.util.*;

public class PuzzleDealer implements PuzzleInterface
{
	private int featureIndex;
	private String drawingID;
	private LinkedList puzzles;
	private Puzzle currentFeature;
	private OurCalendarHelper drawingDate;

	public static final int LABEL = 1;
	public static final int ID = 2;

	/* PuzzleDealer.  Constructor.  Receives a LinkedList of Puzzle
		objects, from which it will "deal."  Designates the first
		Puzzle in the list as the initial "featured puzzle."
	*/
	public PuzzleDealer(LinkedList puzzleList, OurCalendarHelper drawing, String drawingID_)
	{
		puzzles = puzzleList;
		drawingDate = drawing;
		drawingID = drawingID_;
		currentFeature = (Puzzle) puzzleList.getFirst();
		featureIndex = 0;
	}

	/* incrementFeaturePuzzle.  Moves the "feature puzzle" designation
		forward to the next Puzzle in the list, unless the feature is
		already at the last Puzzle in the list.  If the current feature
		is already the last Puzzle, then the feature remains the
		same.
	*/
	public void incrementFeaturePuzzle()
	{
		// use (size - 1) because indexes start at 0... so if the size
		// is 5, then the last index is 4, etc.
		if(featureIndex < (puzzles.size()-1) )
		{	featureIndex++;
			currentFeature = (Puzzle) puzzles.get(featureIndex);
		}
	}

	/* getDateToArchive.  Returns an OurCalendarHelper object representing
		the date on which the currently featured puzzle is due to be
		archived.
	*/
	public OurCalendarHelper getDateToArchive()
	{
		OurCalendarHelper cal = null;
		if(currentFeature != null)
		{	cal = currentFeature.getDateToArchive().deepCopy();
		}
		return cal;
	}

	public OurCalendarHelper getDrawingDate()
	{
		return drawingDate.deepCopy();
	}

	public String getDrawingDateString()
	{
		return getDrawingDate().numericFormat();
	}

	/* getFeaturePuzzleIndex.  Returns the index indicating where in
		the Puzzles list the current feature Puzzle occurs.
	*/
	public int getFeaturePuzzleIndex()
	{
		return featureIndex;
	}

	/* getPuzzleIndex.  Takes two parameters:
		itemToSearch: int.  A value of PuzzleDealer.LABEL indicates
			that the method should search for a Puzzle with a label
			matching the one provided; a value of PuzzleDealer.ID
			indicates that the method should search for a Puzzle with
			an ID matching the one provided.
		valueToFind: String.  This String must be identical to the
			value of the attribute specified by itemToSearch.

		If a match is found, this method returns its index in the
		puzzles list.  If no match is found, -1 is returned.
	*/
	public int getPuzzleIndex(int itemToSearch, String valueToFind)
	{
		int index = -1;
		Iterator iter = puzzles.iterator();
		// loop as long as there are more puzzles to search through
		// and a match has not been found yet (when a match is found
		// then "index" gets a value >= 0)
		while(iter.hasNext() && index == -1)
		{
			Puzzle p = (Puzzle) iter.next();
			if(p != null)
			{
				if(itemToSearch == LABEL && p.getLabel() == valueToFind)
				{	index = puzzles.indexOf(p);
				}
				else if(itemToSearch == ID && p.getID() == valueToFind)
				{	index = puzzles.indexOf(p);
				}
			} // end of outer "if"
		} // end of "while"
		return index;
	} // end of getPuzzleIndex method


	/* getFeaturePuzzle.  Returns a deep copy of the currently
		featured puzzle.
	*/
	public Puzzle getFeaturePuzzle()
	{
		if(currentFeature != null)
		{	return currentFeature.deepCopy();
		}
		else
		{	return null;
		}
	}

	/* getPuzzle.  Used for getting a puzzle other than the currently
		featured puzzle.  Receives an int indicating the index where
		the desired Puzzle occurs in the puzzles list.  This method
		returns a deep copy of that Puzzle, or null if no puzzle is
		there.  Throws IndexOutOfBoundsException if the index is
		outside the range of the puzzles list.
	*/
	public Puzzle getPuzzle(int index) throws IndexOutOfBoundsException
	{
		Puzzle p = (Puzzle) puzzles.get(index);
		if(p != null)
		{	return p.deepCopy();
		}
		else
		{	return null;
		}
	}

	/* getPuzzle.  Used for getting a puzzle other than the currently
		featured puzzle.  Takes two parameters:
			itemToSearch: int.  A value of PuzzleDealer.LABEL indicates
				that the method should search for a Puzzle with a label
				matching the one provided; a value of PuzzleDealer.ID
				indicates that the method should search for a Puzzle with
				an ID matching the one provided.
			valueToFind: String.  This String must be identical to the
				value of the attribute specified by itemToSearch.
		Returns a deep copy of the requested Puzzle, or null if no
		matching Puzzle is found.
	*/
	public Puzzle getPuzzle(int itemToSearch, String valueToFind)
	{
		Puzzle p = null;
		int index = getPuzzleIndex(itemToSearch, valueToFind);
		if(index != -1)
		{	p = getPuzzle(index); // getPuzzle method handles copying
		}						// the original Puzzle
		return p;
	}

	/* getStatement.  Returns the statement of the current feature puzzle,
		or an error message if the current feature pointer is null (this
		should never happen, but it is in there just in case).
	*/
	public String getStatement()
	{
		if(currentFeature != null)
		{	return new String(currentFeature.getStatement());
		}
		else
		{	return "The statement of the puzzle is not found; "
					+ "please notify web site administrator.";
		}
	}

	public String getStatement(int index) throws IndexOutOfBoundsException
	{
		Puzzle p = getPuzzle(index);
		if(p != null)
		{	return p.getStatement();
		}
		else
		{	return null;
		}
	}


	/* getImage.  Returns the path of the image file, if any,
		for the current feature puzzle,
		or an error message if the current feature pointer is null (this
		should never happen, but it is in there just in case).

		Note that some puzzles do not have an image file associated
		with them; in this case, the Puzzle's getImage() method will
		return null, causing this method to return null as well.  So a
		return value of null from this method does not indicate a problem,
		just that there is no image file associated with this puzzle.
	*/
	public String getImage()
	{
		String imageStr = null;
		if(currentFeature != null)
		{	imageStr = currentFeature.getImage();
			// return a copy; don't give them the original String
			if(imageStr != null)
			{	imageStr = new String(imageStr);
			}
		}
		else
		{	imageStr = "The image for the puzzle is not found.";
		}
		return imageStr;
	}

	public String getImage(int index) throws IndexOutOfBoundsException
	{
		Puzzle p = getPuzzle(index);
		if(p != null)
		{	return p.getImage();
		}
		else
		{	return null;
		}
	}

	/* getSampleAnswer.  Returns the sample answer of the current
		feature puzzle,
		or an error message if the current feature pointer is null (this
		should never happen, but it is in there just in case).
	*/
	public String getSampleAnswer()
	{
		if(currentFeature != null)
		{	return new String(currentFeature.getSampleAnswer());
		}
		else
		{	return "A sample answer for the puzzle is not found; "
					+ "please notify web site administrator.";
		}
	}

	public String getSampleAnswer(int index) throws IndexOutOfBoundsException
	{
		Puzzle p = getPuzzle(index);
		if(p != null)
		{	return p.getSampleAnswer();
		}
		else
		{	return null;
		}
	}

	/* getCorrectAnswers.  Returns the array of correct answers for
		the current feature puzzle,
		or an error message if the current feature pointer is null (this
		should never happen, but it is in there just in case).
	*/
	public String[] getCorrectAnswers()
	{
		String[] array;
		if(currentFeature != null)
		{	array = (currentFeature.getCorrectAnswers());
		}
		else
		{	array = new String[1];
			array[0] = "Correct answers for the puzzle are not found; "
					+ "please notify web site administrator.";
		}
		return array;
	}

	public String[] getCorrectAnswers(int index) throws IndexOutOfBoundsException
	{
		Puzzle p = getPuzzle(index);
		if(p != null)
		{	return p.getCorrectAnswers();
		}
		else
		{	return null;
		}
	}

	/* getID.  Returns the ID of the current feature puzzle,
		or an error message if the current feature pointer is null (this
		should never happen, but it is in there just in case).
	*/
	public String getID()
	{
		if(currentFeature != null)
		{	return new String(currentFeature.getID());
		}
		else
		{	return "The ID of the puzzle is not found; "
					+ "please notify web site administrator.";
		}
	}

	public String getID(int index) throws IndexOutOfBoundsException
	{
		Puzzle p = getPuzzle(index);
		if(p != null)
		{	return p.getID();
		}
		else
		{	return null;
		}
	}

	/* getLabel.  Returns the label of the current feature puzzle,
		or an error message if the current feature pointer is null (this
		should never happen, but it is in there just in case).
	*/
	public String getLabel()
	{
		if(currentFeature != null)
		{	return new String(currentFeature.getLabel());
		}
		else
		{	return "The label of the puzzle is not found; "
					+ "please notify web site administrator.";
		}
	}

	public String getLabel(int index) throws IndexOutOfBoundsException
	{
		Puzzle p = getPuzzle(index);
		if(p != null)
		{	return p.getLabel();
		}
		else
		{	return null;
		}
	}

	public String getDrawingID()
	{
		return drawingID;
	}

	/* howManyPuzzles.  Returns an int indicating the number of Puzzle
		objects in the puzzles list.
	*/
	public int howManyPuzzles()
	{
		return puzzles.size();
	}

	/* isCorrectAnswer.  Receives a String which is the attempted
		answer.  Returns a boolean indicating whether the attempt
		matches at least one of the Strings in the puzzle's
		correctAnswers array.  Also returns false if the current
		feature pointer is null (this
		should never happen, but it is in there just in case).
	*/
	public boolean isCorrectAnswer(String attempt)
	{
		if(currentFeature != null)
		{	return currentFeature.isCorrectAnswer(attempt);
		}
		else
		{	return false;
		}
	}

	public boolean isCorrectAnswer(int index, String attempt) throws IndexOutOfBoundsException
	{
		Puzzle p = getPuzzle(index);
		if(p != null)
		{	return p.isCorrectAnswer(attempt);
		}
		else
		{	return false;
		}
	}

} // end of PuzzleDealer class
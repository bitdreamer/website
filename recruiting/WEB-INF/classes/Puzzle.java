/* Puzzle.java.  Copyright 2003 by Meredith College, Raleigh, NC, USA.

	original author: April Austin

	Puzzle.java is created for use by the recruiting web site for
	computer studies at Meredith. This class represents a puzzle
	that consists of

	statement (String) 	- the question or problem being posed
	image (String)		- OPTIONAL; the location of an image file to
							accompany the statement of the puzzle
	sampleAnswer (String) - demonstrates the appropriate format for
							answers submitted by users
	correctAnswer (String[]) - one or more correct answers.  Each
							allowable answer must be included in this
							array (for example, each alternate wording,
							punctuation, capitalization, etc.)  This
							requirement allows for maximum latitude in
							the types of puzzles possible and their
							various possible answer formats (for
							example, some puzzles may have case-sensitive
							answers while others don't, or certain words
							within the correct answer may be case-
							sensitive while others aren't, etc.)
	id (String)			- unique ID assigned to the puzzle
	label (String)		- label used on web site indicating the dates
							for which this puzzle is the feature
							(not necessarily unique)
	dateToPost (OurCalendarHelper) - date on which the puzzle gets posted
							(becomes the featured puzzle)
	dateToArchive (OurCalendarHelper) - date on which the puzzle gets
							archived, meaning that it is no longer the
							featured puzzle but is still available on
							the site
	drawingDate (OurCalendarHelper) - date of the prize drawing associated
							with this puzzle.

	Although at first glance they may seem redundant, the ID and
	label are separate because they contain different information
	to serve different purposes:
	- The ID identifies the puzzle for a web site administrator;
		it identifies the puzzle in terms of which XML file
		the puzzle came from (indicated by the associated drawing
		date) and where that puzzle falls within that file
		(1, 2, 3, etc.).
	- The label identifies the puzzle for the end user (prospective
		students); it is used after archiving to identify the
		puzzle in terms of the dates for which the puzzle was
		featured (such as "Jan. 20 to Jan. 27").

	This class is set up as a JavaBean, so all variables must be
	initialized when they are declared.  Therefore,
	correctAnswers is initialized to a size of one and given
	an empty String to hold; dateToArchive, drawingDate, and
	image are set to null; other String variables are initialized
	to the empty string.
*/


import java.io.*;
import java.util.*;

public class Puzzle implements Serializable, PuzzleInterface
{
	private String statement = "";
	private String image = null;
	private String sampleAnswer = "";
	private String correctAnswers[] = {""};
	private String id = "";
	private String label = "";
	private OurCalendarHelper dateToPost = null;
	private OurCalendarHelper dateToArchive = null;
	private OurCalendarHelper drawingDate = null;

	// Puzzle.  Constructor.
	// Every JavaBean must have an empty constructor.
	public Puzzle()
	{}

	/* Puzzle.  Constructor.  This one takes values for all
		the variables.  If there is no image to accompany the
		statement of the puzzle, then the calling method should
		pass a value of null for the second parameter (image_).
	*/
	public Puzzle(String statement_, String image_,
					String sampleAnswer_, String[] correctAnswers_,
					String id_, String label_, OurCalendarHelper dateToPost_,
					OurCalendarHelper dateToArchive_, OurCalendarHelper drawingDate_)
	{
		statement = statement_;
		image = image_;
		sampleAnswer = sampleAnswer_;
		correctAnswers = correctAnswers_;
		id = id_;
		label = label_;
		dateToPost = dateToPost_;
		dateToArchive = dateToArchive_;
		drawingDate = drawingDate_;
	}

	/* isCorrectAnswer.  Compares attempt with the allowable
		answers held in the correctAnswers array; returns true if
		there is a match, false otherwise.
	*/
	public boolean isCorrectAnswer(String attempt)
	{
		boolean match = false;
		for (int i=0; i < correctAnswers.length; i++)
		{
			if (attempt.equals(correctAnswers[i]))
			{	match = true;
			}
		}
		return match;
	}

	/* deepCopy.  Returns a deep copy of the Puzzle on which it is
		called.  That is, the new Puzzle has the same values as
		the old one for its variables, but it is a completely
		separate object from the old one.
	*/
	public Puzzle deepCopy()
	{
		return new Puzzle(getStatement(), getImage(), getSampleAnswer(),
						getCorrectAnswers(), getID(), getLabel(),
						getDateToPost(), getDateToArchive(),
						getDrawingDate());
	}

	// GETTERS
	public String getStatement(){return statement;}
	public String getImage(){return image;}
	public String getSampleAnswer(){return sampleAnswer;}
	public String[] getCorrectAnswers(){return correctAnswers;}
	public String getID(){return id;}
	public String getLabel(){return label;}
	public OurCalendarHelper getDateToPost(){return dateToPost;}
	public OurCalendarHelper getDateToArchive(){return dateToArchive;}
	public OurCalendarHelper getDrawingDate(){return drawingDate;}

	// SETTERS
	public void setStatement(String newStatement)
	{	statement = newStatement;
	}

	public void setImage(String newImage)
	{	image = newImage;
	}

	public void setSampleAnswer(String newSample)
	{	sampleAnswer = newSample;
	}

	public void setCorrectAnswers(String[] newCorrect)
	{	correctAnswers = newCorrect;
	}

	public void setID(String newID)
	{	id = newID;
	}

	public void setLabel(String newLabel)
	{	label = newLabel;
	}

	public void setDateToPost(OurCalendarHelper newPostDate)
	{	dateToPost = newPostDate;
	}

	public void setDateToArchive(OurCalendarHelper newArchiveDate)
	{	dateToArchive = newArchiveDate;
	}

	public void setDrawingDate(OurCalendarHelper newDrawingDate)
	{	drawingDate = newDrawingDate;
	}

   public void report()
   {
	  System.out.println("\npuzzle("+id+"):");
	  System.out.println("statement:");
	  System.out.println(statement);

	  System.out.println("image (location): "+image);

	  System.out.println("sample answer: "+sampleAnswer);

	  for ( int i = 0; i < correctAnswers.length; i++ )
	  { System.out.println("correct answer: "+correctAnswers[i] ); }
   }
}

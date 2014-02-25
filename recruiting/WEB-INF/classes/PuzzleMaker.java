/* PuzzleMaker.java.  Copyright 2003 by Meredith College,
										Raleigh, NC, USA.

	original author: April Austin

	PuzzleMaker.java is created for use by the recruiting web site for
	computer studies at Meredith. It reads puzzle information from
	an XML file and uses that information to create objects of
	the Puzzle class.  It creates a LinkedList of these Puzzle
	objects and passes the list along to the PuzzleDealer class that
	is created when the getPuzzleDealer() method of this class is called.

	If any of the required elements is missing for a particular
	record in the XML file, a MissingElementException is thrown
	and that record is not used to create a Puzzle object;
	creation of Puzzles continues with the next valid record.
	The correct format for the XML file can be found in
	documentation provided to the Math and Computer Science
	department of Meredith College at the time of initial
	deployment of the recruiting web site.

	For each Puzzle object, this class creates an ID and label and
	calculates the dates to post and archive that puzzle.

	Variables:
	String drawingID 	- the month/year of the drawing, e.g. MAR2003
	int nth				- which puzzle is under construction at
							any given time; i.e, "we're currently working
							on the Nth puzzle" (1, 2, 3, etc.)
	LinkedList puzzles 	- all the puzzles constructed by this
							PuzzleMaker object so far
	OurCalendarHelper drawingDate - the date for the drawing associated
							with the set of puzzles being made
	OurCalendarHelper startDate	- date on which the first puzzle should
							be posted
	OurCalendarHelper weekBeforeDrawing - 7 days prior to drawing date;
							used for dealing with the possibility of
							a partial week in the timeframe between
							the start date and the drawing date;
							eliminates several redundant calculations
	final String FILENAME - the full path/filename of the XML file
							containing puzzle information, e.g.
							"C:\SoftwareEngineering\puzzles.xml"

	Although at first glance they may sound redundant, the ID and
	label for each puzzle are separate because they contain different
	information to serve different purposes:
	- The ID identifies the puzzle for a web site administrator;
		it identifies the puzzle in terms of which XML file
		the puzzle came from (indicated by the associated drawing
		date) and where that puzzle falls within that file
		(1, 2, 3, etc.).
	- The label identifies the puzzle for the end user (prospective
		students); it is used after archiving to identify the
		puzzle in terms of the dates for which the puzzle was
		featured (such as "Jan 20 to Jan 27").
*/

//package org.apache.jsp;


import java.io.*;
import java.util.*;

public class PuzzleMaker implements Serializable
					//throws IOException, MissingElementException
{
	private String drawingID;
	private int nth;
	private LinkedList puzzles;
	private OurCalendarHelper drawingDate;
	private OurCalendarHelper startDate;
	private OurCalendarHelper weekBeforeDrawing;
	private PuzzleDealer dealer;
	private PuzzleUpdater updater;
	private final String FILENAME = ""; // CHANGE THIS WHEN HAVE A
									// REAL FILE NAME & LOCATION

	/* PuzzleMaker.  Constructor.  Reads the XML file containing
		puzzle information; creates a LinkedList of Puzzle objects
		based on that information.
	*/
	public PuzzleMaker() throws IOException, MissingElementException
	{
		nth = 1;
		puzzles = new LinkedList();

		// READ IN YEAR, MONTH, DATE (HEADER-TYPE INFO) FROM FILE
		// ADD ERROR-CHECKING CODE IN CASE AN INVALID MONTH OR DAY
		// SOMEWHERE; MAKE SURE THE DRAWING DATE IS NOT ALREADY PAST

		initCalendars(23, 8, 2003, 2, 3, 2003);// CHANGE THIS TO
					// BE VARIABLE VALUES READ IN FROM XML

		boolean doAnother = true;
		//while(more puzzles to read && doAnother == true)

		// SECOND BATCH OF READING-IN HAPPENS HERE; ASSIGN VALUES
		// INTO STATEMENT, IMAGE, SAMPLEANSWER, CORRECTANSWERS

		//	Puzzle newPuzzle = makePuzzle(statement, image,
		//							sampleAnswer, correctAnswers);
		//	if(newPuzzle.getDateToPost().after(weekBeforeDrawing))
		//	{
		//		doAnother = false;
		//	}
		//	else
		//	{
		//		puzzles.add(newPuzzle);
		//		nth++;
		//	}

		Puzzle finalPuzzle = (Puzzle) puzzles.getLast();
		OurCalendarHelper dayBeforeDrawing = drawingDate.deepCopy();
		dayBeforeDrawing.add(Calendar.DATE, -1);
		finalPuzzle.setDateToArchive(dayBeforeDrawing);
 		String newLabel = makeLabel(finalPuzzle.getDateToPost(),
									dayBeforeDrawing);
		finalPuzzle.setLabel(newLabel);

		dealer = new PuzzleDealer(puzzles, drawingDate.deepCopy(), drawingID);
		updater = new PuzzleUpdater(drawingDate.deepCopy(), dealer);
	}

	/* PuzzleMaker(boolean testing).  Constructor.
		THIS CONSTRUCTOR IS FOR TESTING PURPOSES ONLY!  It calls a
		method to set up
		three contrived puzzles rather than reading the puzzle
		information from a file.  It adds the puzzles to the list
		so that other methods using the puzzles list can be tested
		without the presence of a real XML file.

		The reason for having all the code in another method is so
		that this constructor can go visually in the "constructor"
		region of the class but not take up a lot of space up front.
		The lengthy code is delegated to the testConstruction
		method located at the end of the class.

		The parameter is not used and exists solely to differentiate
		this constructor
		from the real one, where the real one takes no parameters.
	*/
	public PuzzleMaker(boolean testing)
	{
		testConstruction();
	}

	/* initCalendars.  Given numeric values for day, month, and
		year for the start and end (drawing) dates for this set
		of puzzles, this method sets up the three OurCalendarHelper
		objects for use by other methods of this class.

		ADD IN COMMENTS ABOUT WHAT HAPPENS IF THE NUMBERS RECEIVED
		ARE NOT VALID
	*/
	private void initCalendars(	int startMonth, int startDay,
						int startYear, int drawingMonth,
						int drawingDay, int drawingYear)
	{	boolean allOK = true; // REMOVE THIS AT PRODUCTION

		try
		{	startDate = new OurCalendarHelper(startMonth,
										startDay, startYear);
		}
		catch (Exception e)
		{	System.out.println("Invalid input received for starting "
						+ "date.");
			allOK = false; // REMOVE THIS LINE AT PRODUCTION
		}
		try
		{	drawingDate = new OurCalendarHelper(drawingMonth,
									drawingDay, drawingYear);
			// calculate the week before the drawing based
			// on the date of the drawing
			weekBeforeDrawing = drawingDate.deepCopy();
			weekBeforeDrawing.add(Calendar.DATE, -7);
		}
		catch(Exception e)
		{	System.out.println("Invalid input received for drawing "
						+ "date.");
			allOK = false; // REMOVE THIS LINE AT PRODUCTION
		}

		if(drawingDate != null)
		{
			String month = drawingDate.monthAbbrev();
			drawingID = month.toUpperCase()
							+ drawingDate.get(Calendar.YEAR);
		}

		// FOR TESTING PURPOSES ONLY: REMOVE AT PRODUCTION:
		if(allOK)
		{	System.out.println("Week before drawing: "
					+ weekBeforeDrawing.numericFormat()
					+ "\n\nDrawing: " + drawingDate.numericFormat());
		}
	}

	/*makePuzzle.  Creates a Puzzle object having the values received
		as parameters.  The answers from the received correctAnswers
		LinkedList are placed into an array for the Puzzle object.
		Methods are called to generate an ID, label, and
		dateToArchive.  The drawingDate variable of the Puzzle
		object is set to this PuzzleMaker's drawingDate.  Returns
		the newly created Puzzle object.
	*/
	public Puzzle makePuzzle(String statement, String image,
								String sampleAnswer,
								LinkedList correctAnswers)
	{
		// move correct answers from LinkedList into array
		String correct[] = new String[correctAnswers.size()];
		Iterator iter = correctAnswers.iterator();
		int i = 0;
		while(iter.hasNext())
		{	correct[i] = (String) iter.next();
			i++;
		}

		// generate ID, label, and date to archive
		String id = makeID();
		OurCalendarHelper dateToPost = calculateDateToPost();
		OurCalendarHelper dateToArchive = calculateArchiveDate();
		String label = makeLabel(dateToPost, dateToArchive);

		// if no image provided, then the String variable for the
		// image file location should be null, not the empty
		// String.  This checks to make sure.
		if(image != null)
		{
			if(image.equals(""))
			{	image = null;
			}
		}

		Puzzle puzzle = new Puzzle(statement, image, sampleAnswer,
							correct, id, label, dateToPost,
							dateToArchive, drawingDate);
		return puzzle;
	}

	/* makeID.  Generates a puzzle ID consisting of the month and
		year of the drawing date concatenated with the puzzle's
		position in the puzzles list: e.g, MAR2004#3
	*/
	private String makeID()
	{	return (drawingID + "#" + nth); // THIS IS REAL; NO CHANGE NEEDED; JUST DELETE THIS COMMENT
	}

	/* makeLabel.  Generates the label that can be displayed
		as a clickable link on the web site after the puzzle
		is "archived" (still available but no longer the
		featured puzzle).  Returns the label as a String.
	*/
	private String makeLabel(OurCalendarHelper begin,
								OurCalendarHelper archive)
	{
		// Get the desired representation of the month & day to post
		// and month & day to archive; stick 'em together with "to"
		// i.e. "Jan 3 to Jan 10"
		return (begin.monthDayFormat() + " to " + archive.monthDayFormat());
	}

	/* calculateDateToPost.  The first puzzle posts on startDate;
		the second puzzle posts one week later, etc.  This method
		calculates the date for the current puzzle to be posted as
		the feature puzzle, based on its position in the lineup
		(that is, "nth") and the start date.
	*/
	private OurCalendarHelper calculateDateToPost()
	{
		// calculation begins with the start date for the whole
		// set of puzzles
		OurCalendarHelper cal = startDate.deepCopy();

		// number of days from the start date until this puzzle posts
		int days = 7 * (nth - 1);
		// adjust accordingly
		cal.add(Calendar.DATE, days);
		return cal;
	}

	/* calculateArchiveDate.  Each puzzle is featured for 7 days.
		The archive date for the
		last puzzle in the set is an exception to this rule, but
		any necessary adjustment for the last puzzle's archive
		date is done in the adjustFinalArchive method, called
		by the constructor after all puzzles have been made.
	*/
	private OurCalendarHelper calculateArchiveDate()
	{
		OurCalendarHelper cal = calculateDateToPost();
		cal.add(Calendar.DATE, +6); // Today + 6 more = 7 days total
		return cal;
	}

	/* getPuzzleDealer.  Creates a PuzzleDealer object having the
		"puzzles" list of puzzles.
	*/
	public PuzzleDealer getPuzzleDealer()
	{
		return dealer;
	}

	/* getPuzzleUpdater.  Creates a PuzzleUpdater object having the
		drawing date from the current xml file.
	*/
	public PuzzleUpdater getPuzzleUpdater()
	{
		return updater;
	}

	/* testConstruction.  All the content (code) for the PuzzleMaker
		"test" constructor is here so that it doesn't take up a lot
		of visual space at the top of the class.  This method sets
		up a few puzzles not dependent on an xml file; this allows
		for testing of other (non-xml-dependent) code when an
		xml file is not readily available.
	*/
	private void testConstruction()
	{
		puzzles = new LinkedList();
		initCalendars(5, 8, 2003, 12, 3, 2003);

		nth = 1;
		String statement = "Statement #1.  Your answer must be an "
							+ "integer followed by one space and the "
							+ "appropriate metric abbreviation.";
		String image = "whatever/image1.gif";
		String sampleAnswer = "725 MHz";
		LinkedList correctAnswers = new LinkedList();
		correctAnswers.add("200 KHz");

		puzzles.add(makePuzzle(statement, image, sampleAnswer, correctAnswers));

		nth++;
		statement = "Statement #2.";
		image = "";
		sampleAnswer = "blah2";
		correctAnswers = new LinkedList();
		correctAnswers.add("attempts must answer a \"correct\" String exactly");
		correctAnswers.add("Case, white space, everything must match.");
		correctAnswers.add("4t3t");

		puzzles.add(makePuzzle(statement, image, sampleAnswer, correctAnswers));

		nth++;
		statement = "Statement #3";
		image = null;
		sampleAnswer = "blah3";
		correctAnswers = new LinkedList();
		// check what happens if no answers in the list

		puzzles.add(makePuzzle(statement, image, sampleAnswer, correctAnswers));

		Puzzle finalPuzzle = (Puzzle) puzzles.getLast();
		OurCalendarHelper dayBeforeDrawing = drawingDate.deepCopy();
		dayBeforeDrawing.add(Calendar.DATE, -1);
		finalPuzzle.setDateToArchive(dayBeforeDrawing);
 		String newLabel = makeLabel(finalPuzzle.getDateToPost(),
									dayBeforeDrawing);
		finalPuzzle.setLabel(newLabel);

		dealer = new PuzzleDealer(puzzles, drawingDate.deepCopy(), drawingID);
		updater = new PuzzleUpdater(drawingDate.deepCopy(), dealer);
	}

}

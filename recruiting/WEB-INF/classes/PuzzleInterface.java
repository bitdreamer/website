/* PuzzleInterface.java.  Copyright 2003 by Meredith College,
											Raleigh, NC, USA.
	original author: April Austin

	PuzzleInterface is an interface for use by Java classes
	that are part of recruiting web site for computer studies
	at Meredith.
*/

public interface PuzzleInterface
{
	String getStatement();
	String getImage();
	String getSampleAnswer();
	String[] getCorrectAnswers();
	String getID();
	String getLabel();
	OurCalendarHelper getDateToArchive();
	boolean isCorrectAnswer(String attempt);
}
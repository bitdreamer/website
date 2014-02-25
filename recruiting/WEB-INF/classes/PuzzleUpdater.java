// FINISH COMMENTS


/* PuzzleUpdater.java.  Copyright 2003 by Meredith College
										Raleigh, NC, USA.
	original author: April Austin

	PuzzleUpdater.java is created for use by the recruiting web site
	for computer studies at Meredith. This class should not be
	instantiated except by the getPuzzleUpdater method of the
	PuzzleMaker class.

	A PuzzleUpdater object is responsible for checking the date
	periodically and performing necessary actions such as archiving
	each Puzzle object when its dateToArchive is reached; posting
	a new featured Puzzle; and generating e-mail reminders for
	appropriate individuals or groups when the drawing date is
	near.
*/

import java.util.*;
import java.awt.event.*;

public class PuzzleUpdater implements ActionListener
{
	// boolean variables ensure you only send each type of reminder once
	private boolean monthReminderSent;
	private boolean weekReminderSent;
	private boolean dayReminderSent;

	private PuzzleDealer dealer;
	private OurCalendarHelper drawingDate;
	private OurCalendarHelper monthReminder; // 30 days before drawing
	private OurCalendarHelper weekReminder; // 7 days before drawing
	private OurCalendarHelper dayReminder; // 1 day before drawing
	private javax.swing.Timer timer;

	public static void main(String args[])
	{
//		PuzzleUpdater p = new PuzzleUpdater(new OurCalendarHelper(8, 2, 2003));
		System.out.println("in main.");
//p.actionPerformed(new ActionEvent(p, ActionEvent.ACTION_PERFORMED, "new PuzzleUpdater"));
	}

	public PuzzleUpdater(OurCalendarHelper date, PuzzleDealer puzDealer)
	{
		System.out.println("in constructor.");
		drawingDate = date;
		dealer = puzDealer;
		monthReminderSent = false;
		weekReminderSent = false;
		dayReminderSent = false;

		// set up reminder dates based on the drawing date
		monthReminder = drawingDate.deepCopy();
		monthReminder.add(Calendar.DATE, -30);
		weekReminder = drawingDate.deepCopy();
		weekReminder.add(Calendar.DATE, -7);
		dayReminder = drawingDate.deepCopy();
		dayReminder.add(Calendar.DATE, -1);

		timer = new javax.swing.Timer(7200000, this); // 7,200,000 milliseconds = 2 hours
		timer.setInitialDelay(0);
		timer.start();
	}

	public void actionPerformed(ActionEvent event)
	{
		System.out.println("in actionPerformed.");

		OurCalendarHelper today = new OurCalendarHelper();
		checkPuzzle(today);
		checkDrawing(today);

		System.out.println("Drawing date: " + drawingDate.numericFormat()
						+ "\nCurrent date: " + today.numericFormat());
	}

//INCLUDE COMMENT ABOUT WHY THE "WHILE" IS THERE (IN CASE OF RELOADING)
	private void checkPuzzle(OurCalendarHelper today)
	{
		OurCalendarHelper archive = dealer.getDateToArchive();
		if(archive != null)
		{
			final int MAX = 100; // prevent an infinite loop
			int i = 0;
			while(today.after(archive) && i < MAX)
			{
				dealer.incrementFeaturePuzzle();
				i++;
			}
		}
	}

	private void checkDrawing(OurCalendarHelper today)
	{
		if(drawingDate.before(today)) // drawing date has already passed
		{	sendOverdueReminder();
		}
		else // drawing date is still in the future
		{
			if(! monthReminder.after(today)) // 30 days or less remaining
			{								//before drawing date
				if(monthReminderSent == false) // 30-day reminder e-mail
				{								// not sent yet
					monthReminderSent = sendReminder("30 day");
				}
			}
			if(! weekReminder.after(today)) // 7 days or less remaining
			{								//before drawing date
				if(weekReminderSent == false) // 7-day reminder e-mail
				{								// not sent yet
					weekReminderSent = sendReminder("7 day");
				}
			}
			if(! dayReminder.after(today)) // 1 day or less remaining
			{								//before drawing date
				if(dayReminderSent == false) // 1-day reminder e-mail
				{								// not sent yet
					dayReminderSent = sendReminder("1 day");
				}
			}
		} // end of "else"
	} // end of checkDrawing method

	private boolean sendReminder(String timeRemaining)
	{
		boolean successful = false;
/*		try
		{
			LetterDesign msg = new LetterDesign();
			//CHANGE THIS TO WEBMASTER ADDRESS AT PRODUCTION
			msg.setTo("sunflower19@att.net");
			msg.setTo("heresme513@hotmail.com");
			msg.setTo("kosterb@meredith.edu");
			msg.setSubject("Puzzle web site: " + timeRemaining
							+ " reminder");
			msg.setBody("The prize drawing for the current set of "
						+ "puzzles is scheduled for "
						+ drawingDate.numericFormat() + ".  "
						+ "At that time, the puzzles.xml file "
						+ "must be replaced with a new puzzle file.");
			msg.sendMsg();
			successful = true;
		}
		catch(Exception e)
		{
			// REMOVE STACK TRACE AT PRODUCTION?
			e.printStackTrace();
		}
*/
		return successful;
	}

	private void sendOverdueReminder()
	{
/*		try
		{
			LetterDesign msg = new LetterDesign();
			//CHANGE THIS TO WEBMASTER ADDRESS AT PRODUCTION
			msg.setTo("sunflower19@att.net");
			msg.setTo("heresme513@hotmail.com");
			msg.setTo("kosterb@meredith.edu");
			msg.setSubject("PUZZLE WEB SITE OVERDUE FOR UPDATE");
			msg.setBody("The prize drawing for the current set of "
						+ "puzzles has passed.  Please update "
						+ "the puzzle file as soon as possible."
			msg.sendMsg();
			successful = true;
		}
		catch(Exception e)
		{
			// REMOVE STACK TRACE AT PRODUCTION?
			e.printStackTrace();
		}
	*/
	}

} // end of PuzzleUpdater class
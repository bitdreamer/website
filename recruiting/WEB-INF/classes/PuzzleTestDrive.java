/* PuzzleTestDrive.java		author: April Austin

	This is just a miniature driver to test methods of the various
	puzzle-related Java classes for the Meredith CS/CIS recruiting
	web site project.  Everything is static because that made the
	class simpler to write, and since it is just a little test driver
	for my own use,
	I don't want to spend a lot of time making it elegant.

	There are mainly 2 pieces here, checking:
	1) stepping through the whole list by manually controlling the
		index within the PuzzleDealer's puzzles list
	2) stepping through the list by incrementing PuzzleDealer's pointer
		for current feature (similar to what PuzzleUpdater will do
		in the actual application)
	These pieces can be commented out in turn depending on what information
	you want to test
*/

public class PuzzleTestDrive
{
	private static int count;
	private static String[] answers;

	public static void main(String[] args)
	{
		count = 0;

		PuzzleMaker maker = new PuzzleMaker(true);
		PuzzleDealer dealer = maker.getPuzzleDealer();
		PuzzleUpdater updater = maker.getPuzzleUpdater();

		showCurrent(maker, dealer, updater);

		// one way to step through the test puzzles; I've hard-coded
		// here the number of test puzzles that I gave to PuzzleMaker
		int i = 0;
		int j = 0;
		while(j < 3)
		{
			Puzzle p = dealer.getPuzzle(j);
			System.out.println("\n");
			System.out.println(p.getStatement());
			System.out.println(p.getImage());
			System.out.println(p.getSampleAnswer());
			answers = p.getCorrectAnswers();
			i = 0;
			while( i < answers.length )
			{	System.out.println(answers[i]);
				i++;
			}
			System.out.println(p.getID());
			System.out.println(p.getLabel());
			System.out.println(p.getDateToArchive().numericFormat());

			System.out.println("\n\nPress ENTER to continue.\n");
			try
			{
				System.in.read();
			}
			catch(Exception e)
			{
				System.out.println("Input exception occurred:");
				e.printStackTrace(System.out); // where'd exception come from?
			}
			j++;
			count++;
		}
		System.out.println("i = " + i);
		System.out.println("j = " + j);

		// another way to step through the test puzzles; chose the
		// # of iterations to be a little more than the # of test
		// puzzles that I gave the PuzzleMaker, to check that the
		// behavior is correct when the last puzzle is reached & "passed"
		for(int k = 0; k < 5; k++)
		{
			dealer.incrementFeaturePuzzle();
			showCurrent(maker, dealer, updater);
		}

		System.out.println("total puzzles printed = " + count);
	}

	// showCurrent.  Prints the values of the variables held by
	// the currently featured puzzle.
	public static void showCurrent(PuzzleMaker maker, PuzzleDealer dealer, PuzzleUpdater updater)
	{
		System.out.println("Current feature:");
		System.out.println(dealer.getStatement());
		System.out.println(dealer.getImage());
		System.out.println(dealer.getSampleAnswer());
		answers = dealer.getCorrectAnswers();
		int i = 0;
		while( i < answers.length )
		{	System.out.println(answers[i]);
			i++;
		}
		System.out.println(dealer.getID());
		System.out.println(dealer.getLabel());
		System.out.println(dealer.getDateToArchive().numericFormat());
		count++;

		System.out.println("\n\nPress ENTER to continue.\n");
		try
		{
			System.in.read();
		}
		catch(Exception e)
		{
			System.out.println("Input exception occurred:");
			e.printStackTrace(System.out); // where'd exception come from?
		}
	}
}
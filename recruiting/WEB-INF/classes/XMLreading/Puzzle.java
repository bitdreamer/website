// Puzzle.java
// Barrett Koster from design doc for Web Recruiting project, 2003 March

public class Puzzle
{
   public String statement; // The verbal statement of the problem to be solved, including any 
                     // special instructions specific to this puzzle.
   public String image; // The full path/filename for an image to be included as part of the 
                 // statement of the puzzle.  An image is optional for puzzles.  image is 
                 // initialized to null in the Puzzle constructor and remains null if no 
                 // image element is found in the puzzle file.
   public String sampleAnswer; // A sample answer (not the correct answer) demostrating the correct 
                        // format that every submitted answer should follow.
   public String[] correctAnswers; // Each String in the array is an acceptable answer.
   public int correctCount=0; // number of correct answers stored
   public String id; // The unique identifier assigned to this puzzle.
   public String label; // The label that is displayed as a clickable link when the puzzle gets 
                 // "archived" (that is, still available but no longer the featured puzzle).
   public String dateToArchive; // The date on which this puzzle ceases to be the featured puzzle.
   public String drawingDate; // The drawing that this puzzle is for.

   // The last two were designed as "Date"s, but I don't know what that is, so I made them Strings.
   protected int caMax=100; // maximum number of correct answers

   public Puzzle()
   {
      correctAnswers = new String[caMax];
      statement = null;
      image = null;
      sampleAnswer = null;
   }

   public void addCorrect( String a )
   {
      if (correctCount < caMax )
      { correctAnswers[correctCount++] = a; }
      else { System.out.println("error, puzzle has too many correct answers"); }
   }

   public void report(int which)
   {
      System.out.println("\npuzzle("+which+"):");
      System.out.println("statement:");
      System.out.println(statement);

      System.out.println("image (location): "+image);
      
      System.out.println("sample answer: "+sampleAnswer);

      for ( int i = 0; i<correctCount; i++ )
      { System.out.println("correct answer: "+correctAnswers[i] ); }
   }
}
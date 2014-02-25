// XMLHack
// by Barrett Koster, 2003 Mar
// class for reading the XML file in the Web Recruiting project of April and Susan


/*
   An XMLHack object can be created for the file containing puzzles and will read
   and parse this file, making available the contents as Puzzle objects (and
   the drawing date, which is a string).  This is not
   a general XML parser, but one which looks for just the specific things we
   need for this project.  The XML file is as follows, with obvious correspondence
   to the fields needs to make puzzle objects.

<drawingdate>04/20/04</drawingdate>
<puzzle>
<statement>
The statement of the 1st puzzle goes here, along with any special
instructions to the student about this particular puzzle.
</statement>
<image>C:/April/SoftwareEngineering/thingamajig.gif</image>
<sample>An example demonstrating the correct format for responses.</sample>
<correct>Correct answer</correct>
<correct>Another correct answer</correct>
<correct>
The number of these entries depends on how many correct answers are
provided.
</correct>
</puzzle>
<puzzle>

*/
import javax.swing.*;
import java.awt.Graphics;
import java.awt.*;
import java.awt.event.*;
import java.util.*; // need for Random
import java.io.*;

import Puzzle;

public class XMLHack
{
   protected Puzzle[] puzzles; // The point of an XMLHack is to populat this array,
                               // to get the puzzles out of the file and put them as
                               // objects in this array so other parts of the program
                               // can get at them.
   protected int puzzleCount=0;  // number of puzzles the array
   protected int puzzleCountMax = 100;
   protected Puzzle puz; // points to current puzzle
   protected String drawingdate; // the only other thing from the file
   protected InputStreamReader isr; // this lets us read the file
   protected String preString; // findTag (which looks for tags) puts the stuff BEFORE
                               // the tag in here.

   // main.  For testing this class.
   public static void main( String[] agrs )
   {
      System.out.println("\n\ntest1: should read and report two puzzles");
      XMLHack xh = new XMLHack("puzzlefile.txt");
      xh.report();

      System.out.println("\n\ntest 2, should trip on 'splat' tag");
      xh = new XMLHack("test2.txt");

      System.out.println("\n\ntest 3, should trip on missing end of tag");
      xh = new XMLHack("test3.txt");

   }

   public XMLHack( String puzzleFileName )
   {
      puzzles = new Puzzle[puzzleCountMax];

      System.out.println("XMLHack: trying to read file: "+puzzleFileName);

      try
      {
         // test the exception handler
         // int x = 0;
         // x = 1 / x;

         // open file
         isr = new InputStreamReader( new FileInputStream(puzzleFileName) );

         // read the drawingdate section
         readDrawingDate();

         // loop on readPuzzle until it says there are no more
         while ( readPuzzle() ) {}

         // close file
         isr.close();
      }
      catch (Exception e) { System.out.println("error: "+e); }
   }

   public void report()
   {
     System.out.println("drawingdate: "+drawingdate);

      int i=0;
      for ( i=0; i< puzzleCount; i++ )
      {
          puzzles[i].report(i);
      }
   }

   // readDrawingDate.  Looks for <drawingdate> xxxxxxxx  </drawingdate> .
   // It expects this to be the next thing in the file.
   public boolean readDrawingDate()
   {  boolean itsok = true; // reports success of this method, assume true until error

      String tag =  findTag();
      if ( tag!=null && tag.equals("drawingdate") )
      {
         tag = findTag();
         if ( tag.equals("/drawingdate") )
         {
            drawingdate = preString;
         }
         else
         {  System.out.println("error, /drawingdate tag expected, not "+tag);
            itsok=false;
         }
      }
      else
      {   System.out.println("error, drawingdate tag expected, not "+tag);
          itsok=false;
      }

      return itsok;
   }

   // readPuzzle finds the next Puzzle between puzzle tags in the file and reads
   // the info for it into memory.
   public boolean readPuzzle()
   {
      boolean itsok = true;
      String tag, tag2;

      tag = findTag(); // this one should be puzzle
      if ( tag!=null && tag.equals("puzzle") )
      {
         if (puzzleCount<puzzleCountMax)
	      {
	         puz = puzzles[puzzleCount++] = new Puzzle();
	         while ( findPiece() ) {}
	      }
         else {System.out.println("error, too many puzzles"); }
      }
      else if ( tag!=null )
      { System.out.println("error: puzzle tag expected, not:"+tag+":"); itsok=false; }
      else // just hit an end of some kind, ok end it
      { System.out.println("um, end of file maybe");  itsok=false; }

      return itsok;
   }

   // finds a pair of puzzle piece tags and puts the stuff between in the appropriate place.
   // returns false when it was not able to find another puzzle piece (hopefully because
   // of hitting the end-puzzle tag)
   public boolean findPiece()
   {
      boolean itsok = true;
      String tag, tag2;

      tag = findTag(); // get first puzzle piece's begin-tag
      if ( tag!=null )
      {
         if      ( tag.equals("statement") )
         {
            tag2 = findTag();
            if ( tag2!=null && tag2.equals("/statement") )
            {
               puz.statement = preString;
            }
            else { System.out.println("error: missing /statement tag"); itsok=false;
               System.out.println("preString:"+preString);
               System.out.println("tag2:"+tag2);
            }
         }
         else if ( tag.equals("image") )
         {
            tag2 = findTag();
            if ( tag2!=null && tag2.equals("/image") )
            {
               puz.image = preString;
            }
            else { System.out.println("error: missing /image tag"); itsok=false; }
         }
         else if ( tag.equals("sample") )
         {
            tag2 = findTag();
            if ( tag2!=null && tag2.equals("/sample") )
            {
               puz.sampleAnswer = preString;
            }
            else { System.out.println("error: missing /sample tag"); itsok=false; }
         }
         else if ( tag.equals("correct") )
         {
            tag2 = findTag();
            if ( tag2!=null && tag2.equals("/correct") )
            {
               puz.addCorrect( preString );
            }
            else { System.out.println("error: missing /correct tag"); itsok=false; }
         }
         else if ( tag.equals("/puzzle") )
         {
            itsok = false; // piece not found (but this is ok, just end of puzzle)
         }
         else
         { System.out.println("error, unknown tag:"+tag+":"); itsok=false;}
      }
      else
      { System.out.println("error, no end tag for puzzle (or something)"); itsok=false; }

      return itsok;
   }

   // findTag finds the next Tag, returns the contents, with leading slash if there is one.
   // As a side effect, it puts into preString what it finds BEFORE the tag.
   // Returns null if it can't find a tag.
   public String findTag()
   {
      preString = "";
      String tag = null;
      int x = -1; // place to read characters as ints, -1 is EOFs

      // read characters until you hit the beginning of the tag
      do
      {
         try { x = isr.read(); }
         catch (IOException ioex) { System.out.println("error: "+ioex); }
         if ( (x!=-1) && (x!=(int)'<') ) { preString += (char) x; }
      } while ( (x!=-1) && (x!=(int)'<') );

      if (x!=-1) // not EOF, must have hit '<', read tag contents
      {
         tag = "";
         do
         {
            try { x = isr.read(); }
            catch (IOException ioex) { System.out.println("error: "+ioex); }
            if ( (x!=-1) && (x!=(int)'>') ) { tag += (char) x; }
         } while ( (x!=-1) && (x!=(int)'>') );

         if (x==-1) { tag = null; }
      }
      return tag;
   }

}
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
   protected Puzzle[] puzzles;
   protected String drawingdate;

   // main.  For testing this class.
   public static void main( String[] agrs )
   {
      XMLHack xh = new XMLHack("puzzlefile.txt");

      xh.report();
   }

   public XMLHack( String puzzleFileName )
   {
      System.out.println("XMLHack: trying to read file: "+puzzleFileName);

      try
      {  // int x = 0;
         // x = 1 / x;
         // open file
         

         // read the drawingdate section
         // loop on readPuzzle until it says there are no more
         // close file
      }
      catch (Exception e) { System.out.println("error: "+e); }
   }

   public void report()
   {
      System.out.println("XMLHack.report: don't know how yet");
   }
}
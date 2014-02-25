import java.io.*;
import java.util.*;
import java.lang.*;

public class DrawingEntry extends OurWriter
{
	private final String PATH;
	private String userID;
	private Puzzle puzzle;

	public DrawingEntry( String user, Puzzle puzz )
	{
		userID = user;
		puzzle = puzz;
		PATH = "drawingEntries_" + puzzle.getID() + ".xml"; 
	}

	public void addEntry()
	{
		LinkedList entryAddition = new LinkedList();
	
		entryAddition.add( userID );
		entryAddition.add( puzzle.getID() );
		entryAddition.add( "" );

		record( PATH, entryAddition );
	}

	public boolean isUniqueEntry()
	{
		createFile( PATH );
		
		Iterator i = previousFile.iterator();

		while( i.hasNext() )
		{
			String line = (String) i.next();
		
			if( line.equals( userID ) )
				return false;
		}
	
		return true;
	}
}
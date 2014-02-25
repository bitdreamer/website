import java.io.*;
import java.util.*;
import java.lang.*;

public class OurWriter
{
	private LinkedList previousFile;
	private String file;

	public OurWriter()
	{
		previousFile = new LinkedList();
	}

	public void createFile( String filename )
	{
		BufferedReader read = null;		// needed to read file information
		
		// opens file. if file doesn't exist creates one.
		try
		{
			read = new BufferedReader( new FileReader( filename ) );
		}
		catch( Exception e ) {	try{
										FileWriter file = new FileWriter( filename ); }
										catch( IOException f ) {} }
		
		// processes a line in the file. returns an error message if something is wrong with the line.
		// ends when there are no more lines in the file.
		if( read != null )
		{
			try
			{
				String aLine;		// current line being read
				
				while( (aLine = read.readLine() ) != null )
				{
					previousFile.add( aLine );
				}
			}
			catch( Exception e ) { System.out.println( "file read error" ); }
		}
	}


	public void record( String filename, LinkedList stuffToAdd )
	{
		createFile( filename );
		record( filename, stuffToAdd, previousFile );

		previousFile.clear();
	}

	//LinkedLists are suppose to be composed of Strings
	public void record( String filename, LinkedList newStuffToWrite, LinkedList oldStuffToWrite )
	{
		BufferedWriter out = null;		// needed to read file information
		
		try
		{
			out = new BufferedWriter( new FileWriter( filename ) );
		}
		catch( Exception e ) {System.out.println( "file open error" ); }
		
		if( out != null )
		{
			try
			{
				String aLine;		// current line to be written
			
				Iterator i = oldStuffToWrite.iterator();
				while( i.hasNext() )
				{
					aLine = (String) i.next();
					out.write( aLine );
					out.newLine();
				}

				Iterator j = newStuffToWrite.iterator();
				while( j.hasNext() )
				{
					aLine = (String) j.next();
					out.write( aLine );
					out.newLine();
				}

				out.close();
			}
			catch( IOException e ) { System.out.println( "file write error" ); }
		}
	}
}
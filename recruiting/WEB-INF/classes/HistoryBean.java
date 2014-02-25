import java.io.*;
import java.util.*;
import java.lang.*;

public class HistoryBean extends OurWriter
{
	private final String HISTORY_FILE;

	public HistoryBean()
	{
		HISTORY_FILE = "history.xml";
	}

	public void addToHistory( String userID, String submission, Puzzle puzzle )
	{
		LinkedList fileAdditions = new LinkedList();

		fileAdditions.add( userID );
		fileAdditions.add( submission );
		fileAdditions.add( puzzle.getId() );
		fileAdditions.add( "" );

		record( HISTORY_FILE, fileAdditions );
	}
}
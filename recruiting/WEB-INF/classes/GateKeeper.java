import java.util.*;
import java.lang.*;
import java.io.*;

public class GateKeeper implements Serializable
{
	private LinkedList allUsers;	//a list of all the valid users
											//with information in the XML document
	private final String FILENAME = "users.txt";//full path of the file where user records are stored
	private String tempUser;

	public GateKeeper()
	{
		allUsers = new LinkedList();
		tempUser="";
		setUpList();
	}

	public boolean contactInfo( String contact, String email, String phone )
	{
		if( contact.equals( "V1" ) )
			return true;
		else if( contact.equals( "V2" ) && !emptyString( phone ) )
			return true;
		else if( !emptyString( email ) )
			return true;
		else
			return false;
	}

	public boolean emptyString( String s )
	{
		String compare = "";
		for( int i = 0; i < s.length(); i++ )
		{	compare = compare + " ";	}

		if( s.equals( compare ) )
			return true;
		else
			return false;
	}

	public void setUpList()
	{
		BufferedReader br = null;		// needed to read file information

		// opens file. if file doesn't exist returns an error message.
		try
		{
			br = new BufferedReader( new FileReader( FILENAME ) );
		}
		catch( Exception e1 )
		{ //System.out.println( "file open error" );
			try
			{
				File usersFile = new File(FILENAME);
			}
			catch( Exception e2 )
			{
				System.out.println("Could not make new file in the "
								+ "setUpList() method of the GateKeeper "
								+ "class.");
			}
		}

		// processes a line in the file. returns an error message if something is wrong with the line.
		// ends when there are no more lines in the file.
		if( br != null )
		{
			try
			{
				String aLine;		// current line being read

				while( ( aLine = br.readLine() ) != null )
				{
					StringTokenizer st = new StringTokenizer( aLine );
					User u = new User( st );
					allUsers.add(u);
				}
			}
			catch( Exception e ) { System.out.println( "file read error" ); }
		}
	}

	public boolean grantAccessPW(String id, String password)
	{
		User u = findUser( id );

		if( u != null )
		{
			if( password.equals( u.getPassword() ) )
				return true;
		}

		return false;
	}

	public boolean grantAccessQ( String answer )
	{
		User u = findUser( tempUser );
		tempUser = "";

		if( u != null )
		{
			if( answer.equalsIgnoreCase( u.getAnswer() ) )
				return true;
		}

		return false;
	}

	public boolean userExist( String id )
	{
		User u = findUser( id );

		if( u != null )
			return true;

		return false;
	}

	public void addUser( String id, String password, String question, String answer )
	{
		User u = new User( id, password, question, answer );
		allUsers.add(u);

		String addInfo = id + " " + password + " " + question + " " + answer;

		LinkedList newUser = new LinkedList();
		newUser.add( addInfo );

		OurWriter write = new OurWriter();
		write.record( FILENAME, newUser );
	}

	public String getQuestion( String id )
	{
		String str;
		str = "User does not exist";

		User u = findUser( id );

		if( u != null )
		{	tempUser = id;
			str = u.getQuestion();	}

		return str;
	}

	private User findUser( String id )
	{
		Iterator i = allUsers.iterator();

		while( i.hasNext() )
		{
			User u = (User) i.next();

			if( id.equalsIgnoreCase( u.getID() ) )
				return u;
		}
		return null;
	}
}
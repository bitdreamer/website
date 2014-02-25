import javax.mail.*;
import javax.mail.internet.*;
import java.util.*;
import java.lang.*;

public class LetterDesign
{
	// representing mail transport, folders & message being read
	private Transport transport;
	
	// data representing the user's session
	private Properties properties;
	private Session session;

	// data representing a new message about to be sent
	private MimeMessage message;
	private String to;
	private final String FROM;
	private String cc;
	private String subject;
	private String body;

	// information about the user & mail servers
	private String outMailServer;

	public LetterDesign()
	{
		// set mail server information
		// need to fix this when mail server is set up on The Butler
		outMailServer = "whiterabbit.meredith.edu";

		// make a session
		properties = System.getProperties();						//check
		properties.put( "mail.smtp.host", outMailServer );		//check
		session = Session.getInstance( properties, null );		//check

		message = new MimeMessage( session );

		// initiallize message objects
		to = "";
		FROM = "PuzzlePage@TheButler.bitlab";
		cc = "";
		subject = "";
		body = "";
	}

	public void sendMsg() throws
				AddressException, SendFailedException, MessagingException
	{
		createMessage();
		connect();

		transport.sendMessage( message, message.getAllRecipients() );
		transport.close();
	}

	public void createMessage()
	{
			// message properties
			try{
			message.setFrom( new InternetAddress(FROM) );
			message.addRecipient( Message.RecipientType.TO, new InternetAddress(to) );
			message.addRecipient( Message.RecipientType.CC, new InternetAddress(cc) );
			message.setSubject( subject );
			message.setText( body );
			}
			catch( Exception e ){ System.out.println("Trouble Making From Address");	}
	}

	public void connect()
	{
		try {
		transport = session.getTransport("smtp");
		transport.connect(outMailServer, "",""); }
		catch( Exception e ){ System.out.println( "Transport Trouble" );	}
	}

	public void appendToBody( String str )
	{
		body = body + str;
	}

	public void setTo( String recipient )
	{		to = recipient;	}

	public void setSubject( String sub )
	{		subject = sub;		}

	public void setBody( String message )
	{		body = message;	}

	public void setCC( String c )
	{		cc = c;				}
	
	public boolean emptyString( String test )
	{
		String compare = "";
		
		for( int i = 0; i < test.length(); i++ )
		{
			compare = compare + " ";
		}
		
		if( compare.equals(test) )
			return true;

		return false;
	}
}

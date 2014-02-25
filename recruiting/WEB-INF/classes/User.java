import java.util.*;

public class User
{
	private String id;
	private String	password;
	private String question;
	private String answer;

	public User( StringTokenizer info )
	{
		id = info.nextToken();
		password = info.nextToken();
		question = info.nextToken();
		answer = info.nextToken();
	}

	public User( String identity, String pass, String ques, String ans )
	{
		id = identity;
		password = pass;
		question = ques;
		answer = ans;
	}

	public void setID( String s ) { id = s; }
	public void setPassword( String s ) { password = s; }
	public void setQuestion( String s ) { question = s; }
	public void setAnswer( String s ) { answer = s; }

	public String getID() { return id; }
	public String getPassword() { return password; }
	public String getQuestion() { return question; }
	public String getAnswer() { return answer; }
}
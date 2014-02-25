import java.lang.*;
import java.util.*;

public class Writer
{
	public static void main(String[] args )
	{
		LinkedList l = new LinkedList();

		l.add("Sell Papes");
		l.add("Carry Da Bannah");

		LinkedList newL = new LinkedList();

		newL.add("Gimpy is cool");
		newL.add("Soak A Scab");

		OurWriter ow = new OurWriter();
		//ow.record( "test.xml", newL, l );

	//	l.add("Kicks");

		ow.record( "test.xml", l );
		ow.record( "test.xml", newL );
	}
}
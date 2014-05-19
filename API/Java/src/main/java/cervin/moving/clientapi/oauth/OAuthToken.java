package cervin.moving.clientapi.oauth;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

public class OAuthToken {
	private String value;
	private long duration;
	private Calendar expiration;
	private Calendar creation;
	
	public OAuthToken(String value, Long duration) {
		super();
		this.value = value;
		this.duration = duration;
		expiration = Calendar.getInstance();
		creation = (Calendar) expiration.clone();
		expiration.add(Calendar.SECOND,duration.intValue());
	}
	public Long getDuration() {
		return duration;
	}
	public String getValue() {
		return value;
	}
	public Calendar getExpiration()
	{
		return expiration;
	}
	
	
	private SimpleDateFormat format = new SimpleDateFormat("dd MMM yyyy HH:mm:ss");
	@Override
	public String toString(){
		
		return 	"Token : " + value + 
				" - Creation "+ format.format(creation.getTime()) +
				" - Duration "+ duration +"s" +
				" - Expiration "+ format.format(expiration.getTime());
	}
}

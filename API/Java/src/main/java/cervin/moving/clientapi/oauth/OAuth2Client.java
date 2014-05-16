package cervin.moving.clientapi.oauth;

import java.util.Properties;

import javax.naming.ConfigurationException;

import com.ibm.oauth.OAuth2Details;
import com.ibm.oauth.OAuthConstants;
import com.ibm.oauth.OAuthUtils;

public class OAuth2Client {

	private Properties config;
	
	public OAuth2Client(Properties config) throws ConfigurationException{
		if(config == null){
			throw new ConfigurationException("Null config file");
		}
		
		createClient(config);
	}
	public OAuth2Client(String username, String password, 
			String authenticationServerUrl ) throws ConfigurationException{

		Properties config = new Properties();
		config.setProperty(OAuthConstants.USERNAME, username);
		config.setProperty(OAuthConstants.PASSWORD, password);
		config.setProperty(OAuthConstants.AUTHENTICATION_SERVER_URL, authenticationServerUrl);
		createClient(config);
	}
	
	
	
	private void createClient(Properties config) throws ConfigurationException{

		
		String username = config.getProperty(OAuthConstants.USERNAME);
		String password = config.getProperty(OAuthConstants.PASSWORD);
		String authenticationServerUrl = config
				.getProperty(OAuthConstants.AUTHENTICATION_SERVER_URL);
		
		//On force le type a client_credentials
		config.setProperty(OAuthConstants.GRANT_TYPE, "client_credentials");
	
		
		if (!OAuthUtils.isValid(username)){
			throw new ConfigurationException("Please provide valid values for username");
		}
		if (!OAuthUtils.isValid(password)){
			throw new ConfigurationException("Please provide valid values for password");
		}
		if (!OAuthUtils.isValid(authenticationServerUrl)){
			throw new ConfigurationException("Please provide valid values for authenticationServerUrl");
		}
		this.config = config;
	}
	
	
	public String getAccessToken(){
		// Resource server url is not valid. Only retrieve the access token
		System.out.println("Retrieving Access Token");
		OAuth2Details oauthDetails = OAuthUtils.createOAuthDetails(config);
		String accessToken = OAuthUtils.getAccessToken(oauthDetails);
		if(OAuthUtils.isValid(accessToken)){
			System.out
				.println("Successfully retrieved Access token for Password Grant: "
						+ accessToken);
			return accessToken;
		}
		throw new RuntimeException("Le token n'est pas valide !!");
	}
}

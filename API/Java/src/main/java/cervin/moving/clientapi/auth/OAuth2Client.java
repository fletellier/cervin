package cervin.moving.clientapi.auth;

import java.util.Properties;

import javax.naming.ConfigurationException;

import com.ibm.auth.OAuth2Details;
import com.ibm.auth.OAuthConstants;
import com.ibm.auth.OAuthUtils;

public class OAuth2Client {

	
	public OAuth2Client(Properties config) throws ConfigurationException{
		if(config == null){
			throw new ConfigurationException("Null config file");
		}
		
		createClient(config);
	}
	public OAuth2Client(String username, String password, 
			String authenticationServerUrl, String resourceServerUrl ) throws ConfigurationException{

		Properties config = new Properties();
		config.setProperty(OAuthConstants.RESOURCE_SERVER_URL, resourceServerUrl);
		config.setProperty(OAuthConstants.USERNAME, username);
		config.setProperty(OAuthConstants.PASSWORD, password);
		config.setProperty(OAuthConstants.AUTHENTICATION_SERVER_URL, authenticationServerUrl);
		createClient(config);
	}
	
	
	
	private void createClient(Properties config) throws ConfigurationException{

		
		String resourceServerUrl = config.getProperty(OAuthConstants.RESOURCE_SERVER_URL);
		String username = config.getProperty(OAuthConstants.USERNAME);
		String password = config.getProperty(OAuthConstants.PASSWORD);
		String authenticationServerUrl = config
				.getProperty(OAuthConstants.AUTHENTICATION_SERVER_URL);
		
		//On force le type a password
		config.setProperty(OAuthConstants.GRANT_TYPE, "password");
	
		
		if (!OAuthUtils.isValid(username)){
			throw new ConfigurationException("Please provide valid values for username");
		}
		if (!OAuthUtils.isValid(password)){
			throw new ConfigurationException("Please provide valid values for password");
		}
		if (!OAuthUtils.isValid(authenticationServerUrl)){
			throw new ConfigurationException("Please provide valid values for authenticationServerUrl");
		}
		
		if (!OAuthUtils.isValid(resourceServerUrl)) {
			// Resource server url is not valid. Only retrieve the access token
			System.out.println("Retrieving Access Token");
			OAuth2Details oauthDetails = OAuthUtils.createOAuthDetails(config);
			String accessToken = OAuthUtils.getAccessToken(oauthDetails);
			if(OAuthUtils.isValid(accessToken)){
			System.out
					.println("Successfully retrieved Access token for Password Grant: "
							+ accessToken);
			}
		} else {
			// Response from the resource server must be in Json or Urlencoded or xml
			System.out.println("Resource endpoint url: " + resourceServerUrl);
			System.out.println("Attempting to retrieve protected resource");
			OAuthUtils.getProtectedResource(config);
		}
	}
}

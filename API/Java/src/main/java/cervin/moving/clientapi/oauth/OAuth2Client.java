package cervin.moving.clientapi.oauth;

import java.util.Calendar;
import java.util.Properties;

import javax.naming.ConfigurationException;

import org.apache.commons.validator.routines.UrlValidator;

import cervin.moving.clientapi.exception.AuthException;
import cervin.moving.clientapi.exception.OAuthErrorType;

public class OAuth2Client {

	private Properties config;
	private OAuthToken token; 
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
			throw new ConfigurationException("Please provide valid values for authenticationServerUrl (empty URL)");
		}
		String[] schemes = {"http","https"};
	    UrlValidator urlValidator = new UrlValidator(schemes);
	    if ( ! urlValidator.isValid(authenticationServerUrl)) {
	    	throw new ConfigurationException("Please provide valid values for authenticationServerUrl (bad URL)");
	    }
		this.config = config;
	}
	
	
	public String getAccessToken() throws AuthException{
		
		
		if(token != null){
			//un token a déjà été généré, on va vérifier l'expiration
			Calendar now = Calendar.getInstance();
			now.add(Calendar.SECOND, OAuthConstants.refresh_token_before);
			if(token.getExpiration().after(now)){
				//Le token a expiré, il doit être regénéré
				System.out.println("Token has expirated...");
				token = null;
			}
			else {
				return token.getValue();
			}
		}
		// Resource server url is not valid. Only retrieve the access token
		System.out.println("Retrieving Access Token");
		OAuth2Details oauthDetails = OAuthUtils.createOAuthDetails(config);
		OAuthToken accessToken =  OAuthUtils.getAccessToken(oauthDetails);
		if(OAuthUtils.isValid(accessToken.getValue())){
			System.out
				.println("Successfully retrieved Access token for Password Grant: "
						+ accessToken);
			return token.getValue();
		}
		throw new AuthException(OAuthErrorType.INVALID_TOKEN);
	}
}

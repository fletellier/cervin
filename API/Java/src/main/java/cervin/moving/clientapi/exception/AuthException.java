package cervin.moving.clientapi.exception;


public class AuthException extends Exception {

	/**
	 * 
	 */
	private static final long serialVersionUID = 4141424716397911559L;
	
	public AuthException(OAuthErrorType errorType) {
		super();
		this.setErrorType(errorType);
	}

	public AuthException(OAuthErrorType errorType, String arg0, Throwable arg1) {
		super(arg0, arg1);
		this.setErrorType(errorType);
	}

	public AuthException(OAuthErrorType errorType, String arg0) {
		super(arg0);
		this.setErrorType(errorType);
	}

	public AuthException(OAuthErrorType errorType, Throwable arg0) {
		super(arg0);
		this.setErrorType(errorType);
	}

	private OAuthErrorType errorType;

	public OAuthErrorType getErrorType() {
		return errorType;
	}

	public void setErrorType(OAuthErrorType errorType) {
		this.errorType = errorType;
	}
	
	public String getErrorTypeMsg(){
		switch(errorType){
			case HTTP_ERROR: return "Erreur dans la transmition HTTP ";
			case INVALID_TOKEN: return "Le serveur a retourné un token invalide (ou un token vide)";
			case LOGIN_ERROR: return "Erreur de login / password";
			case AUTH_SERVICE_NOT_FOUND: return "Service d'authentification non trouvé : Problème d'URL ?";
			default : return "Erreur inconnue : " + this.getCause() == null ? "cause inconnue" : this.getCause().getMessage();
		}
	}
}

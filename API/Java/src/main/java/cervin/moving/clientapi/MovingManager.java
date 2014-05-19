package cervin.moving.clientapi;

import java.rmi.RemoteException;

import javax.naming.ConfigurationException;

import org.apache.axis2.AxisFault;

import cervin.moving.clientapi.exception.AuthException;
import cervin.moving.clientapi.interfaces.IToto;
import cervin.moving.clientapi.oauth.OAuth2Client;
import cervin.moving.clientapi.ws.MonServiceStub;
import cervin.moving.clientapi.ws.MonServiceStub.GetToto;

public class MovingManager {

	
	//Methode de test
	 @Deprecated
	 public MovingManager() throws ConfigurationException, AxisFault{
		this("testclient","testpass","http://google.fr", "http://localhost:8080/DemoAuthServer/services/MonService.MonServiceHttpEndpoint/" );
		 
	 }
	
	 private OAuth2Client oauthclient;
	 private MonServiceStub service;
	 
	 public MovingManager(String username, String password, 
				String authenticationServerUrl, String resourceServerUrl ) throws ConfigurationException, AxisFault{
		 oauthclient = new OAuth2Client(username, password, authenticationServerUrl);
		 service = new MonServiceStub(resourceServerUrl);
	 }
	
	 
	 public IToto getToto() throws AuthException, RemoteException{
		
		try {
			GetToto param = new GetToto();
			param.setToken(oauthclient.getAccessToken().toString());
			return service.getToto(param).get_return();
		} catch (RemoteException e) {
			// TODO Auto-generated catch block
			AxisFault realError = null;
			if(e instanceof AxisFault){
				realError = (AxisFault) e;
			}
			else if ( e.getCause() != null){
				Throwable cause = e.getCause();
				if(cause instanceof AxisFault){
					realError = (AxisFault) cause;
				}
			}
			if(realError != null){
				System.out.println("On a bien une erreur Axis !");
				throw realError;
			}
			else
			{
				System.out.println("C'est quoi ??");
				e.printStackTrace();
				throw e;
			}
			
		} 
	 }
}

package cervin.moving.clientapi;

import java.rmi.RemoteException;

import javax.naming.ConfigurationException;



import org.apache.axis2.AxisFault;

import cervin.moving.clientapi.exception.AuthException;

public class Launch {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		MovingManager manager;
		try {

			System.out.println("Etape 0 init ");
			manager = new MovingManager();
			System.out.println("Etape 1 creation mgr ok ");
			System.out.println(manager.getToto().getName());
			System.out.println("Etape 2 requete ok ");
		} catch (RemoteException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (ConfigurationException e) {
			System.out.println(e.getMessage());
		} catch (AuthException e) {
			System.out.println(e.getErrorTypeMsg());
			System.out.println(e.getMessage());
		}
	}

}

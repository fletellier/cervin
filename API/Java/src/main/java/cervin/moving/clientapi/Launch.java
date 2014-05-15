package cervin.moving.clientapi;

import java.rmi.RemoteException;

import javax.naming.ConfigurationException;

import org.apache.axis2.AxisFault;

public class Launch {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		MovingManager manager;
		try {
			manager = new MovingManager();
			System.out.println(manager.getToto().getName());
		} catch (RemoteException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (ConfigurationException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

}

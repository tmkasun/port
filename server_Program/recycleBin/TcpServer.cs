///<copyright> 
///</copyright>

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net;
using System.Net.Sockets;
using System.Threading;
using System.IO;
using MySql.Data.MySqlClient;

namespace VTS_GPS_Listener
{
    public class TcpServer
    {
        private IPAddress ip;
        private int port;
        private Boolean isActive;
        private TcpListener server;
       
        public void SetSocket(IPAddress ip, int port)  //Setter for listening socket
        {            
            this.ip = ip;  //Set listener IP
            this.port = port;  //Set listening port
            StartListener();  //Call listener starter
        }

        private void StartListener()  //Listner starter 
        {
            try
            {
                server = new TcpListener(ip, port);  //Create new listener with given socket
                server.Start();  //Start listener
                isActive = true;  //Put the system active state 
                AcceptModules();  //Start accepting modules
            }
            catch (Exception ex)  //Error handler
            {
                Console.WriteLine("Error occured while starting the listener.\nVTS is not active.\n\n"+ex.Message);  //Show error meesage
                isActive = false;  //Put the system inactive state
            }
        }

        private void AcceptModules()  //Accepting modules and create different threads to each of them
        {
            while (isActive)  //Do following while system is in active state
            {
                try
                {
                    TcpClient newModule = server.AcceptTcpClient();  //Wait for modules to send data
                    Thread moduleThread = new Thread(new ParameterizedThreadStart(HandleModule));  //If new module found then create a thread for handling it
                    moduleThread.Start(newModule);  //Start created thread
                }
                catch (Exception ex)  //Error handler
                {
                    Console.WriteLine("Error occured while accepting a new moudule.\n\n"+ex.Message);  //Show error meesage
                    isActive = false;  //Put the system inactive state
                }
            }            
        }

        private void HandleModule(object clientObject)  //Thread handler
        {
            TcpClient module = (TcpClient)clientObject;  //Retreive data passed to the thread as TcpClient data type
            StreamReader readingStream = new StreamReader(module.GetStream(), Encoding.ASCII);  //Reader stream for read data from module in ASCII encoding
            string readString = null;  //Variable to store string getting from the modules
            Boolean moduleConnected = true;  //Now a module is connected to the system
            while (moduleConnected)  //Do follwing while module is connected
            {
                readString = readingStream.ReadLine();  //Read data sent by module (Line by line at \n)
                if (readString != null)  //Check read data is not null
                {
                    StringProcessor(readString);  //Send read_string for string processing
                }
                else
                {
                    moduleConnected = false;  //If listener recieves null for readString it assumes module is disconnected
                }
            }
            module.Close();  //Close the TCP connection after module is disconnected
        }

        private void StringProcessor(String dataRecieved)  //Delimitating the read_string
        {
            char delimiter = ','; //Define delimiter characterfor splitting the recieved string
            try
            {
                string[] delimitedData = dataRecieved.Split(delimiter);  //Store delimited data in an array
               
                /* Latitude Hemisphere is always 'N' &
                 * Longitude Hemisphere is always 'E'
                 * within Sri Lanka 
                 */
                
                //From here depends on the module type & currently progrmmed for TK-102 module    

                string conString = "Server=192.168.246.105;Uid=root;Database=syscall;Pwd=kasun123;";  //Connection string for database access
              
                Int64 imei = Convert.ToInt64(delimitedData[16].Substring(5));  //Get IMEI from array                  
                    
                if ((delimitedData[5] != null) && (delimitedData[7] != null) && (delimitedData[9] != null))
                {
                    //Converting latitude into DD.MMMMM format
                    int latitudeDegrees = Convert.ToInt16(delimitedData[5].Substring(0, 2));
                    double latitudeMinutesInDegrees = Convert.ToDouble(delimitedData[5].Substring(2)) / 60;
                    double latitudeDecimalInDegrees = latitudeDegrees + latitudeMinutesInDegrees;

                    //Converting longitude into DDD.MMMMM format
                    int longitudeDegrees = Convert.ToInt16(delimitedData[7].Substring(0, 3));
                    double longitudeMinutesInDegrees = Convert.ToDouble(delimitedData[7].Substring(3)) / 60;
                    double longitudeDecimalInDegrees = longitudeDegrees + longitudeMinutesInDegrees;

                    double speedInKmh = Convert.ToDouble(delimitedData[9]) * 1.852;  //Get speed as knots and coverts to km/h (1 knot = 1.85200 km/h)
                    string cellId = delimitedData[26];  //Get cell ID of the module
                    int numberOfSatelittes = Convert.ToInt16(delimitedData[17]);  //No: of satellites to check accuracy of coordinates
                    
                    string day = delimitedData[11].Substring(0,2);
                    string month = delimitedData[11].Substring(2, 2);
                    string year = "20"+delimitedData[11].Substring(4, 2);
                    string hours = delimitedData[3].Substring(0, 2);
                    string minutes = delimitedData[3].Substring(2, 2);
                    string seconds = delimitedData[3].Substring(4, 2);
                    string timeDate = year+"-"+month+"-"+day+" "+hours+":"+minutes+":"+seconds;

                    MySqlConnection conn = new MySqlConnection(conString);
                    conn.Open();
                      
                    MySqlCommand comm = new MySqlCommand("INSERT INTO coordinates VALUES('"+timeDate+"','"+numberOfSatelittes+"','"+latitudeDecimalInDegrees+"','"+longitudeDecimalInDegrees+"','"+speedInKmh+"','"+imei+"','"+cellId+"')", conn);
                    comm.ExecuteNonQuery();


                }         
            }
            catch (Exception ex) 
            {
                Console.WriteLine(ex.Message);
            }    
        }
    }
}

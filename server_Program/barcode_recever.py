#! /usr/bin/python
#This script if for read barcodes send by networked barcode device
"""
Barcode reader for motrola
http://code.activestate.com/recipes/408859-socketrecv-three-ways-to-turn-it-into-recvall/

"""

import threading
import socket
import time
try:
	# try to install MySQLdb module
  import MySQLdb #Documentation http://mysql-python.sourceforge.net/MySQLdb.html

except ImportError:
  # apt get code apt-get install python-mysqldb
  print "Import failed MySql Database module "


def createSocket(portNumber=9091, serverIP=""):
  server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
  serverIP = ""
  port = portNumber
  server.bind((serverIP, port))
  server.listen(5)
  server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
  print "Socket created on IP {} port {} ".format(serverIP, port)
  return server

#global variables 
serverAddress = ""
portNumber = 9090

class testConnection(threading.Thread):
  def __init__(self):
    pass
  
  def run(self):
    pass
  

def main():
  startupAnimation()
  print "Welcome To Barcode reader programm"
  port_number = int(raw_input("Enter listning port number:"))    
  while True:
      try:
          serverSocket = createSocket(port_number)
          if serverSocket:
              break
      
      except socket.error:
          print "Delaying connection for 5 seconds due to previously failed connection attempt..."
          time.sleep(5)
          continue

  while True:
      print "Waiting for new device to connect"
      newConnection(serverSocket.accept()).start()




class newConnection(threading.Thread):
  def __init__(self, detailsPair):
    channel , address = detailsPair
    self.channel = channel
    self.connectionImei = None
    self.address = address
    self.connectToDB()
    #self.approvedImei = False # this has been moved to gpsObject class
    threading.Thread.__init__(self)
  
  def disconnect(self,reson="No reson specified"):
    if self.channel:
     	self.channel.shutdown(2)
    self.channel.close()
    return False

  def connectToDB(self, databaseIP="127.0.0.1", dbUser="root", dbPassword="kasun123"):
    # Open database connection
    self.connection = MySQLdb.connect(databaseIP, dbUser, dbPassword)
    self.connection.select_db("syscall")
    self.cursor = self.connection.cursor()
  
  def disconnect(self,reson="No reson specified"):
    
    self.connection.commit()
    if self.cursor:
     	self.cursor.close()
    if self.channel:
     	self.channel.shutdown(2)
    self.channel.close()
    return False 


  
  def reciveGpsData(self):
     
	try:
          print "receving data"
          recivedDataFromGpsDevice = self.channel.recv(4096)	# 4096 is the buffer size
		#print recivedDataFromGpsDevice # for debuging only
			
	except:
          print "Error connection to vehicle (disconnect without FIN packet) error no re-try"
#          setOnlineFlag = """update vehicle_status set disconnected_on = now(),current_status = 0 where imei = "{}" """.format(self.connectionImei)
#          self.cursor.execute(setOnlineFlag)
#          self.connection.commit()
#          self.disconnect("Recived GPS String is invalid")
	return recivedDataFromGpsDevice
# this method is called when thread is created
  def run(self):
    
    while True:
        print "*** New device connected from {} ***".format(self.address)
        print "Waiting for incoming messages from device....."
        recived_data = self.reciveGpsData()        
        print recived_data
        insertBarcodeData = """update job_details set time_of_departure = now() where barcode_number = '{}' """.format(recived_data)
        print insertBarcodeData
        
        try:
            # Execute the SQL command
            self.cursor.execute(insertBarcodeData)
            self.connection.commit() #commit changes to DB imediatly
            
        except :
            # Roll back in case there is any error
            print insertBarcodeData
            print "Mysql Execution Error"
            self.connection.rollback()

def startupAnimation():
	print ''
	print ' ____ _____ ____ ____ '
	time.sleep(0.1)
	print ' / \ | | / \ / \ / \ | | '
	time.sleep(0.1)
	print '| | | | | | | \ | | | '
	time.sleep(0.1)
	print '| \____/| | \____/ \___/\ |_ |_ v0.5'
	time.sleep(0.1)
	print '|______ | |_______ '
	time.sleep(0.1)
	print ' \ | \ '
	time.sleep(0.1)
	print ' | | | '
	time.sleep(0.1)
	print ' ______/ _____/ \_____/ '
	time.sleep(0.1)
	print 'Contact us for any bug reports at syscall@knnect.com '
	time.sleep(0.1)
	print '\n'


if __name__ == "__main__":
  main()




  
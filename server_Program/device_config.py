#! /usr/bin/python
#This script if for configuring GPS/GPRS tracking device via TCP protocol
"""
Configure MVT380 device by sending configuration commands over TCP

"""

import threading
import socket
import time



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
  print "Welcome To Device configuration programm"
  device_imei = str(raw_input("Enter Device IMEI number to be configured(blank if u don't know):"))
  selection_number = 1 
  if device_imei:
      print "{}. Wait for connection from {}(IMEI) device".format(selection_number)
      selection_number +=1
  print "{}. Wait for device to connect to this( {} ) server ".format(selection_number,socket.gethostname())

  selection = int(input("Select the Method: "))
  
  if selection_number > 1 and selection == 1:
      print "Not implimented yet"
    
  elif selection is 2 or selection is 1 :
    #nprint "Not impliment yet"

    port_number = int(raw_input("Enter port number to use in creating socket:"))    
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
    #self.approvedImei = False # this has been moved to gpsObject class
    threading.Thread.__init__(self)
  
  def disconnect(self,reson="No reson specified"):
    if self.channel:
     	self.channel.shutdown(2)
    self.channel.close()
    return False
   
  def reciveGpsData(self):

	try:
		recivedDataFromGpsDevice = self.channel.recv(4096)	# 4096 is the buffer size
		#print recivedDataFromGpsDevice # for debuging only
			
	except:
          print "Error connection to vehicle (disconnect without FIN packet) error = {} no re-try".format(e)
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
        print "Device with {} IMEI number connect to server".format(recived_data.split(",")[1])
        print "Do you want to continue with this device(y/n)?"
        answer = raw_input()   
        print answer.lower()
        if answer.lower() == 'y':
            print "Yes selected"
            startConfig(self.channel,self.address)
               
        elif answer.lower() == 'n':
            print "No selected"
            self.disconnect()
            return
        print "Wrong selection"    
        self.disconnect()
        return


def startConfig(socket,address):
    print "Connection details IP:Port {}".format(address)
    socket.settimeout(20)    
    while True:
        print "Enter command to send to device(blank to exit)"
        command = raw_input()
        
        if command == '':
            return False
        sent_bytes = socket.send(command)
        print "number of characters in command {} number of bytes sent = {}".format(len(command),sent_bytes)
        print "Waiting for reply......(20 seconds)"
        try:        
            reply = socket.recv(4096)
        except :
            print "No data recived :("
        

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




  
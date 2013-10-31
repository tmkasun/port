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
        self.connectionImei = recived_data.split(",")[1]
        print "Device with {} IMEI number connect to server".format(recived_data.split(",")[1])
        print "Do you want to continue with this device(y/n)?"
        answer = raw_input()   
        print answer.lower()
        if answer.lower() == 'y':
            print "Yes selected"
            startConfig(self.channel,self.address,self.connectionImei)
               
        elif answer.lower() == 'n':
            print "No selected"
            self.disconnect()
            return
        print "Wrong selection"    
        self.disconnect()
        return


def startConfig(socket,address,imei):
    print "{} Connection details IP:Port {}".format(imei,address)
    socket.settimeout(0)    
    while True:
        command = raw_input("Enter command to send to device{A10 to F11 commands available}(blank to exit)")
        
        if command == '':
            return False
        command = command.upper()
        data = ""
        while True:
            item = raw_input("Enter data to {} command(blank to exit)").format(command)
            if item == '':
                break
            data += ","+item
        send_command = generateCommand(command,data,imei)
        sent_bytes = socket.send(send_command)
        print "number of characters in command {} number of bytes sent = {}".format(len(send_command),sent_bytes)
        print "Waiting for reply......"
        while True:
            try:        
                reply = socket.recv(4096).split(",")
            except :
                print "No data recived :("
                continue
            
            if reply[2] == command:
                print "Got a reply = {}".format(reply)
            
            print "Command execute succesfully :) \n"
                


""" 
From what I understand, you basically have to do the following:
1. Find the ASCII code of all the characters from the first @ all the way to the * before the checksum
2. Add all the ASCII codes together and convert to hex
3. Take the two rightmost digits of the hex number, and that will be your checksum

Here is a walk through of the sample you provided:
"""
def generateCommand(command,data,imei):
    #A10 to F11 commands available sample $$<packageflag><L>,<IMEI>,<command>,<data><*checksum>\r\n
    import random 
    #generate package flag
    random_int = random.randint(65,122)
    hex_value = hex(random_int)
    package_flag = hex_value[2:].decode('hex')
    #2 bytes. Header of the package from server to tracker. 
    header = '@@'    
    ending_character = "\r\n" #2 bytes. Ending character in ASCII (0x0d,0x0a)
    
    #Length from its following separator ‘,’ to the ending character ‘\r\n’. It is decimal digit.
    length = str(len(imei+command+data+ending_character)+3) # 3 is checksum len = 2 + star(*)
    
    #generate check sum
    int_sum = 0
    checksum_string = header+ package_flag + length + command + data + "*"
    for character in checksum_string:
        int_sum += ord(character)
    hex_value_of_checksum = hex(int_sum)
    #end generate checksum
    value_need_to_append_to_command = '*'+hex_value_of_checksum[-2:]
    command_string = header+package_flag+length+','+imei+','+command+data+value_need_to_append_to_command+ending_character
    print command_string
    return command_string

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




  
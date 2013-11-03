#! /usr/bin/python
from dis import dis
import sys

#===============================================================================
# PortAuthority project  (syscall 001)
#
# portp/server/port-listner/main
#
# A uthor: syscall
# Creation date: 01th january 2013 #@bug: not sure
#
#  Moratuwa University 2013
#
# # # Modification history
# Version     Modifier     Date         Change         Reason
# 1 .0 k.     kasun        5-25-2013    Add header     Submit tedt oC M
#
#===============================================================================

#===============================================================================
"""
Copyright (c) 2013 All Right Reserved, http://www.itfac.mrt.ac.lk
This source is subject to the GNU General Public Licen
</copyright>
<author>UOM.itfac</author>
<email>syscall@knnect.com</email>
<date>2013-04-25</date>
<summary>Contains a linux, (server) service for listen port 9090
This programm is designed to run on Amazone EC2 instances, running in other platforms may result in unexpected outputs,
This is an Open source project and you may take  this program as u wish with some rights reserved by www.itfac.mrt.ac.lk
Be open :)</summary>
 """
#===============================================================================

"""
-------------------------------
For documentation purpose
-------------------------------
-------------what is socket.accept()-------------

Accept a connection. The socket must be bound to an address and listening for connections. The return value is a pair (conn, address) where conn is a new socket object usable to send and receive data on the connection, and address is the address bound to the socket on the other end of the connection.

A pair (host, port) is used for the AF_INET address family, where host is a string representing either a hostname in Internet domain notation like 'daring.cwi.nl' or an IPv4 address like '100.50.200.5', and port is an integer.

So the second value is the port number used by the client side for the connection. When a TCP/IP connection is established, the client picks an outgoing port number to communicate with the server; the server return packets are to be addressed to that port number.

-------------Luhn algorithm-------------
From Wikipedia, the free encyclopedia

The Luhn algorithm or Luhn formula, also known as the "modulus 10" or "mod 10" algorithm, is a simple checksum formula used to validate a variety of identification numbers,
such as credit card numbers, IMEI numbers, National Provider Identifier numbers in US and Canadian Social Insurance Numbers.
It was created by IBM scientist Hans Peter Luhn and described in U.S. Patent No. 2,950,048, filed on January 6, 1954, and granted on August 23, 1960.

The algorithm is in the public domain and is in wide use today. It is specified in ISO/IEC 7812-1.[1] It is not intended to be a cryptographically secure hash function;
it was designed to protect against accidental errors,
not malicious attacks. Most credit cards and many government identification numbers use the algorithm as a simple method of distinguishing valid numbers from collections of random digits.



-------------------Benefits of Asynchronous Sockets and Linux epoll----------------------

When a program uses blocking sockets it often uses one thread (or even a dedicated process) to carry out the communication on each of those sockets.
The main program thread will contain the listening server socket which accepts incoming connections from clients. 
It will accept these connections one at a time, passing the newly created socket off to a separate thread which will then interact with the client. 
Because each of these threads only communicates with one client, any blockage does not prohibit other threads from carrying out their respective tasks.
"""

#===============================================================================
# coding style CC python ie: variableName, ClassName ,functionName, _specialVariableName_
#===============================================================================

import threading
# import Queue
from gpsString import *
from newConnection import *
import socket #documentation http://docs.python.org/2/howto/sockets.html , http://docs.python.org/2/library/socket.html
from fileinput import filename
try:
	# try to install MySQLdb module
  import MySQLdb #Documentation http://mysql-python.sourceforge.net/MySQLdb.html

except ImportError:
  # apt get code apt-get install python-mysqldb
  print "Import failed MySql Database module "

import time
from datetime import datetime
import os  # for configure linux server
import logging  # reffrence doc http://docs.python.org/2/howto/logging.html
logging.basicConfig(filename="server_tcp.log", format='The event %(levelname)s was occored in %(asctime)s : PID : %(process)d when executing : %(funcName)s @ line number : %(lineno)d', level=logging.DEBUG)

# global variables for use

def main():
	startupAnimation()
	configInfoDict = configServer()
  
  # log programm activities
	logging.info("main process started")
	
  # Set up the Socket:
	while True:
		try:
			serverSocket = createSocket(int(configInfoDict.get("serverPort")), configInfoDict.get("serverIP"))
			if serverSocket:
				break
			
		except socket.error:
			print "Delaying connection for 5 seconds due to previously failed connection attempt..."
			time.sleep(5)
			continue

	while True:
		print "Current Connections= {}".format(threading.activeCount()-1)
		newConnection(serverSocket.accept(), configInfoDict.get("databaseIP"), configInfoDict.get("dbUser"), configInfoDict.get("dbPassword")).start()


#new Connection object for every connection creat between GPS/GPRS device and local server
class newConnection(threading.Thread):
  def __init__(self, detailsPair, databaseIP, dbUser, dbPassword):
    channel , address = detailsPair
    self.channel = channel
    self.connectionImei = None
    self.address = address
    #self.approvedImei = False # this has been moved to gpsObject class
    self.splitedGpsData = ''
    self.connectToDB(databaseIP, dbUser, dbPassword)
    threading.Thread.__init__(self)
  
  def connectToDB(self, databaseIP, dbUser, dbPassword):
    # Open database connection
    self.connection = MySQLdb.connect(databaseIP, dbUser, dbPassword)
    self.connection.select_db("syscall")
    self.cursor = self.connection.cursor()
  
  def disconnect(self,reson="No reson specified"):
    logging.warn("Connection has been disconnected due to >" + reson)
    self.connection.commit()
    if self.cursor:
     	self.cursor.close()
    if self.channel:
     	self.channel.shutdown(2)
    self.channel.close()
    return False
   
  def reciveGpsData(self):
    try_count = 0
    while True:
        try:
              try_count +=1
              print "{}try to read data from device".format(try_count)
              recivedDataFromGpsDevice = self.channel.recv(4096)	# 4096 is the buffer size
              return recivedDataFromGpsDevice
              #print recivedDataFromGpsDevice # for debuging only
    			
        except socket.error as e:
              logging.error(e)
              print "Error connection to vehicle (disconnect without FIN packet) error = {}".format(e)
              if try_count < 2:
                  continue
              return ''
              
# this method is called when thread is created
  def run(self):
    # allow viewing server connection log via web page
    print "Device connected from {} via its port {}".format(self.address[0], self.address[1])
    
    gpsObject = gpsString(self.reciveGpsData())
    
    # Change mode to blocking after connecting device 
    self.channel.setblocking(0) # set channel(or socket) to non-blocking mode
    self.channel.settimeout(14) # wait 15 second blocked if not receve data rise exception

    print "---------Initial check complete---------\n gpsObject is {}".format(gpsObject.isValidGpsString) #for debuging use only
    
    #check this algo short curcuite matter?
    if not (gpsObject.isValidGpsString and gpsObject.validateVehicleFromDB(self.cursor)):#pass the connection cursor to validator
        	print "Recived GPS String is invalid" # for debuging purpose
        	self.disconnect("Recived GPS String is invalid")
        	return False
    
    print "-----Continue to recive data IMEI number is valid and approved -----"
    
    # finally if everything went correctly , set online status 1 to that truck
    connectionImei = gpsObject.imei  # this `connectionImei` i s created to use on when device disconnected from device
    self.connectionImei = connectionImei
    #current_status = 1 means online 0 means offline
    setOnlineFlag = """insert into vehicle_status values("{}",now(),null,1) ON DUPLICATE KEY update connected_on = now() , current_status = 1""".format(gpsObject.imei)
    print setOnlineFlag
    print "Vehicle Flag set to online"
    print self.cursor.execute(setOnlineFlag)
    self.connection.commit() #commit changes to DB imediatly 
    while True:
      #recivedDataFromGpsDevice = self.channel.recv(2048)  # 2048 is the buffer size
      gpsObject = gpsString(self.reciveGpsData())
      
      if not gpsObject.isValidGpsString:
          #ping = self.channel.send("1") # FIXME have to ping to server and confirm its disconnected befor we drop connection
          
          print "Device has been disconnected from remote end no retrying "
          setOnlineFlag = """update vehicle_status set disconnected_on = now(),current_status = 0 where imei = "{}" """.format(connectionImei)
          self.cursor.execute(setOnlineFlag)
          self.connection.commit()
          self.disconnect("Device has been disconnected from remote end DB Flag set To Disconnected")
          print ("Device has been disconnected from remote end DB Flag set To Disconnected")
          return False
      	
      	
      elif not gpsObject.isConnectedToSatellites:
      	print "Device is not connected to GPS Satellites"
      	continue #waiting to connect device to GPS Satellites

      print "Receiving GPS coordinates....(Thread Name: {})".format(self.getName())

      try:
        #print sat_time
        sql = """ insert into coordinates(sat_time,sat_status,latitude,longitude,speed,bearing,imei,location_area_code,cell_id) values("{}",'{}',{},{},{},{},"{}","{}","{}")""".format(gpsObject.sat_time,gpsObject.sat_status,gpsObject.latitude,gpsObject.longitude,gpsObject.speed,gpsObject.bearing,gpsObject.imei,gpsObject.location_area_code,gpsObject.cell_id)

      except ValueError:
        sql = ""
        print "SQL ValueError"
        continue

      try:
        # Execute the SQL command
        self.cursor.execute(sql)

      except :
        # Roll back in case there is any error
        print sql
        print "Mysql Execution Error"
        self.connection.rollback()


#this class is for future advancements
class vehicle():
	pass


def createSocket(portNumber=9090, serverIP=""):
  server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
  serverIP = ""
  port = portNumber
  server.bind((serverIP, port))
  server.listen(5)
  server.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
  print "Socket created on IP {} port {} ".format(serverIP, port)
  return server



# Server configuration

def configServer():
  """
  Import configuration file and set parameters
  """
  try:
    config = open(r"./server.conf", "r+")
  except IOError, e:
    print e
    return 0
  configLines = []
  try:
    while True:
      configLines.append(config.next())
  except StopIteration:
    pass
  finally:
    config.close()
  configInfo = {}
  for line in configLines:
    if line[0] == "#" or line[0] == "\n":
      continue
    configLineArgumentList = line[:-1].split("=")
    key = configLineArgumentList[0]
    value = configLineArgumentList[1]
    configInfo.update({key:value})
  logging.info("Configuration done sucssesfully")
  return configInfo

#===============================================================================
# Standard boilerplate to call the main() function to begin the program.
#===============================================================================

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

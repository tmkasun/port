#! /usr/bin/python
#This script if for testing the TCP Listning server 
"""
Spawning a new thread for every connection is a really bad design choice. 
What happens if you get hit by a lot of connections ..........

http://stackoverflow.com/questions/487229/client-server-programming-in-python

Twisted is an event-driven networking engine written in Python and licensed under the open sourc
http://twistedmatrix.com

"""

import threading
import socket
import time

#global variables 
serverAddress = ""
portNumber = 9090

class testConnection(threading.Thread):
  def __init__(self):
    pass
  
  def run(self):
    pass
  

def main():
  print "Welcome To Server testing service "
  serverAddress = str(raw_input("Enter Server address:"))
  portNumber = int(raw_input("Enter port number:"))
  print "Test case 1 : test connection to the server"
  print "Test case 2 : Stress test"
  print "Test case 3 : Max connection test"
  print "Test case 4 : Incomming connections test"
  print "Test case 5 : Full test"
  selection = int(input("Select the test senario: "))
  
  if selection is 1:
    connectionTest(serverAddress,portNumber)
    
  elif selection is 2:
    print "Not impliment yet"
  
  elif selection is 3:
      maxNumberOfConnections = int(raw_input("Enter the number of connections need to generate"))
      connectionTest(serverAddress,portNumber)
      sleepTime = input("Enter time interval during creation of each connection(in seconds):")
      for connections in range(maxNumberOfConnections):
        time.sleep(sleepTime)
        print "Number of connections created = {}".format(connections+1)
        testSocket = socket.socket()
        try:
          testSocket.connect((serverAddress,portNumber))
          print "Connection to {} on port {} sucsesfull".format(serverAddress,portNumber)
        except socket.error as error:
          print "Unable to connect to {} on port {} due to {} reson".format(serverAddress,portNumber,error)

  
  elif selection is 4:
      #$$B137,992140013581290,AAA,35,7.059956,79.961233,131103162649,A,9,28,0,231,0.8,71,240985,118299,413|1|F6E0|2C08,0000,0000|0000||02DE|00FB,*D6
      print "Not impliment yet"
      testSocket = socket.socket()
      try:
          testSocket.connect((serverAddress,portNumber))
          print "Connection to {} on port {} sucsesfull".format(serverAddress,portNumber)
          
      except socket.error as error:
          print "Error in connection to server"
      
      while True:
          inputString = raw_input("Enter string to send to server(blank to exit)")
          if len(inputString) == 0:
              break
          print "Sending message {}".format(inputString)
          try:
              
              sentBytes = testSocket.send(inputString)

          except socket.error as error:
              print "Error! reconnecting = {}".format(error)
              testSocket = socket.socket()
              testSocket.connect((serverAddress,portNumber))
              continue


          print "{} bytes sent sucsesfully".format(sentBytes)
          
          
          
          
  elif selection is 5:
      print "Not impliment yet"


def connectionTest(serverAddress,portNumber):
    testSocket = socket.socket()
    try:
      testSocket.connect((serverAddress,portNumber))
      print "Connection to {} on port {} sucsesfull".format(serverAddress,portNumber)
      return (serverAddress,portNumber)
    except socket.error as error:
      print "Unable to connect to {} on port {} due to {} reson".format(serverAddress,portNumber,error)
    finally:
      testSocket.close()
  

if __name__ == "__main__":
  main()
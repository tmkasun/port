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
  print "Test case 4 : Data flow frequency test"
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
      print "Not impliment yet"
      
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
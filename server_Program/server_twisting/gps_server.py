# Copyright (c) University of Moratuwa, Faculty of Information Technology.
# See LICENSE for details.

"""
TCP port listener for used with SLPA vehicle tracking system.
Coding_standards guidelines L{https://twistedmatrix.com/documents/current/core/development/policy/coding-standard.html} 
"""


from twisted.enterprise import adbapi
from twisted.internet import reactor
from twisted.internet.defer import Deferred
from twisted.internet.protocol import Protocol, ServerFactory
from twisted.protocols.basic import LineReceiver
from syscall.devices import devices



class GpsValidation():
    """
    Validation of IMIE, connection , Users are perform by me
    all the types of validations related to GPS data is performed by me
    """
    
    pass



class GpsDataProcessor():
    """
    Process data send by GPRS/GPS device 
    supported device types are described in L{syscall.devices}
    device identification will be done based in the line send by the device ,
    according to the line encoding methods unique to each device.
    """
    
    def __init__(self,lineReceived):
        self.receivedCsvLine = lineReceived
        self.deviceType = None
        
    
    def splitString(self, delimiter = ','):
        """
        Use comma as default delimiter for CSV string
        """
        print "### data = {}".format(self.receivedCsvLine)
        self.splitedString = self.receivedCsvLine.split(delimiter)
        return self.splitedString   
    
    def identifyDevice(self):
        self.deviceType = None
        return self.deviceType



class DbManager():
    """
    Manage connections and data in/out flow with server 
    """

    pass



class GpsData():
    """
    Keep all the data about single gps object
    ie: coordinates(latitude longitude) , time stamp, heading and etc
    """
    
    def save(self):
        print "### Saving GpsData object in database (ORM)"



class GpsStringReceiver(LineReceiver):
    
    
    def lineReceived(self, line):
        peer = self.transport.getPeer()
        print "### This is the received line = {} from '{}'".format(line, peer)
        gpsDataprocess = GpsDataProcessor(line)
        gpsDataprocess.splitString()
        gpsDataprocess.identifyDevice()
        position = GpsData()
        position.save() 
        

    def connectionMade(self):
        self.factory.number_of_connections +=1
        print "### Connection made, current connected clients = {}".format(self.factory.number_of_connections)

        
    def connectionLost(self, reason):
        self.factory.number_of_connections -=1
        print "### Connection lost from the client, current connected clients = {}".format(self.factory.number_of_connections)
         


class GpsStringReceiverFactory(ServerFactory):
    
    number_of_connections = 0
    protocol = GpsStringReceiver
    
    def startFactory(self):
        d = devices()
        print "### Starting GpsStringReceiverFactory \nsupported devices {}".format(d.supportedDevices)


def main():
    
    print "### Runing main()"
    factory = GpsStringReceiverFactory()
    reactor.listenTCP(9090, factory, 100)
    reactor.run()
    print "### Listning on port 9090....."
    
if __name__ == '__main__':
    main()
    
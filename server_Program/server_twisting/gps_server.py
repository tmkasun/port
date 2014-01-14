# Copyright (c) University of Moratuwa, Faculty of Information Technology.
# See LICENSE for details.

"""
TCP port listener for used with SLPA vehicle tracking system.
Coding_standards guidelines L{https://twistedmatrix.com/documents/current/core/development/policy/coding-standard.html} 
"""


from twisted.internet.protocol import Protocol, ServerFactory
from twisted.protocols.basic import LineReceiver
from twisted.internet import reactor

from twisted.enterprise import adbapi



class GPSdata(LineReceiver):
    
    
    def lineReceived(self, line):
        peer = self.transport.getPeer()
        print "### This is the received line = {} from '{}'".format(line, peer)
        host = self.transport.getHost()
        self.sendLine("Feedback from {}".format(host))

    def connectionMade(self):
        self.factory.number_of_connections +=1
        print "Connection made, current connected clients = {}".format(self.factory.number_of_connections)
        
    def connectionLost(self, reason):
        self.factory.number_of_connections -=1
        print "Connection lost from the client, current connected clients = {}".format(self.factory.number_of_connections)
         

class GPSdataFactory(ServerFactory):
    
    number_of_connections = 0
    protocol = GPSdata
        


def main():
    
    print "### Runing main()"
    factory = GPSdataFactory()
    reactor.listenTCP(9090, factory, 100)
    reactor.run()
    print "### Listning on port 9090....."
    
if __name__ == '__main__':
    main()
    
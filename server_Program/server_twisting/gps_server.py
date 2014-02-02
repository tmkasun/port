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
from syscall.mvt380 import *



class GpsDataProcessor():
    """
    Process data send by GPRS/GPS device 
    supported device types are described in L{syscall.devices}
    device identification will be done based in the line send by the device ,
    according to the line encoding methods unique to each device.
    """
    
    def __init__(self, lineReceived, delimiter = ','):
        self.receivedCsvLine = lineReceived
        self.processed = False
        
        
    def splitString(self, delimiter = ','):
        """
        Use comma(,) as default delimiter for CSV string
        """
        #print "### data = {}".format(self.receivedCsvLine)
        self.splitedString = self.receivedCsvLine.split(delimiter)
        return self.splitedString   
    
    
    def identifyDevice(self):
        """
        Identify the type of device which has send the given string pattern
        """
        if self.validateIMEI(self.splitedString[0]):
            self.deviceType = "tk102"
        return self.deviceType
    
    
    def validateIMEI(self,imei):
        """
        Validation of IMIE, connection , Users are perform by me
        all the types of validations related to GPS data is performed by me
        """
        def digits_of(n):
            return [int(d) for d in str(n)]
        digits = digits_of(card_number)
        odd_digits = digits[-1::-2]
        even_digits = digits[-2::-2]
        checksum = 0
        checksum += sum(odd_digits)
        for d in even_digits:
            checksum += sum(digits_of(d * 2))
        return checksum % 10 == 0
    
    
    def process(self):
        self.splitedString = self.splitString(delimiter)
        self.deviceType = self.identifyDevice()
        self.processed = True
    
    previousCoordinate = (0.0,0.0)
    def isMoving(self,currentCoordinate):
        
        minimumChange = deviceAccuracy
        minimumCountForRejection = 0
        if distanceBetweenCoordinates(previousCoordinate, currentCoordinate) > minimumChange and minimumCountForRejection > 2:
            previousCoordinate = currentCoordinate
            minimumCountForRejection +=1
            return True
        else:
            previousCoordinate = currentCoordinate
            minimumCountForRejection = 0
            return Fal
                


class Validator(object):
    """
    Validater Object for validate all the type of data
    """
    
    def validateVehicleFromDB(self,gpsData): 
        #print "### Starting approval of vehicle from DB"
        databaseCursor.execute("select imei from approved_imei where imei = '{}'".format(self.imei))
        approvedImeiList = databaseCursor.fetchall()
        #print approvedImeiList
        #print self.imei
        
        if len(approvedImeiList) > 0:
            self.isApprovedImei = True
            #print "IMEI Number is already approved"
            return self.isApprovedImei
        
        #print "Not an approved IMEI number ({}),this IMEI number will send to approval ".format(self.imei)
        sql = """ insert IGNORE into not_approved_imei values("{}",{},"{}") """.format(self.imei, 0, datetime.now())
        databaseCursor.execute(sql) 
        return self.isApprovedImei



class DBAdapter(object):
    """
    Manage connections and data in/out flow with server 
    """
    def __init__(self,dbConfiguration):
        """
        ['dbApiName'],
        ['host'],
        ['username'],
        ['password'],
        ['database']
        @param dbConfiguration: The DB connection configuration details
        @type dbConfiguration:  C{dict}
        dbAipName like MySQLdb 
        """
        self._dbpool = adbapi.ConnectionPool(*dbConfiguration)

    

    def savePosition(self,positionData):
        """
        Store information in database 
        @param positionData: contains positioning data speed, altitute, loggitute , latitude and IMEI
        @type positionData: C{MVT380Protocol}
        
        sql = 
        insert into coordinates
        (sat_time,sat_status,latitude,longitude,speed,bearing,imei,location_area_code,cell_id) 
        values("{}",'{}',{},{},{},{},"{}","{}","{}")
        .format(gpsObject.sat_time, gpsObject.sat_status, gpsObject.latitude, 
        gpsObject.longitude, gpsObject.speed, gpsObject.bearing, gpsObject.imei
        , gpsObject.location_area_code, gpsObject.cell_id)

        """
        #print "####savePosition **************************************\n"
        
        print positionData['altitude'].inMeters
        print positionData['longitude'].inDecimalDegrees
        print positionData['latitude'].inDecimalDegrees
        print positionData['time']
        print positionData['IMEI']
        print positionData['speed'].inMetersPerSecond
        print positionData['heading'].inDecimalDegrees
         
        #print "####loop **************************************\n"
        
        query = """insert into coordinates (sat_time,latitude,longitude,speed,bearing,imei) values("{}",{},{},{},{},{})""".\
        format(positionData['time'],positionData['latitude'].inDecimalDegrees,positionData['longitude'].inDecimalDegrees,\
        positionData['speed'].inMetersPerSecond,positionData['heading'].inDecimalDegrees,positionData['IMEI'])
        print query
        return self._dbpool.runQuery(query)#.addCallbacks(self.DbSucesses, self.DbError)#.addBoth(self.testPrint)
                
    def DbError(self,error):
        print "###DbError = ",error
        
    def DbSucesses(self,sucessResult,currentDeviceIMEI):
        print "###DbSucesses",sucessResult
        for element in sucessResult:
            if currentDeviceIMEI == element[0]:
                return True
         
        raise ValueError("Unauthorized IMEI")
        
    
    def validateDevice(self,positionData):
        print "#### validateDevice",positionData
        query = """select imei from approved_imei"""
        print query
        return self._dbpool.runQuery(query).addCallbacks(self.DbSucesses, self.DbError,callbackArgs=(str(positionData['IMEI']),))
        
        
        
    def sendToApproval(self,imei):
        query = """insert into not_approved_imei values("{}",0,now()) ON DUPLICATE KEY UPDATE last_connection_attempt = now()"""\
        .format(imei)
        return self._dbpool.runQuery(query).addBoth(self.shutdown)
        
    
    def shutdown(self,*args):
        """
            Shutdown function
            It's a required task to shutdown the database connection pool:
                garbage collector doesn't shutdown associated thread
        """
        self._dbpool.close()
    
    
    
class GpsStringReceiver(NMEAProtocol):
    
    
    def __init__(self):

        configurationDetails = ['MySQLdb',
                                '127.0.0.1',
                                'root',
                                
                                'kasun123',
                                'syscall'
                                ]
        #self._AUTHORIZED_CONNECTION = False
        print "initializing GpsStringReceiver"
        _dbBridge = DBAdapter(configurationDetails)
        NMEAProtocol.__init__(self,_dbBridge)
        

    def connectionMade(self):
        self.factory.number_of_connections +=1
        #print "### Connection made, current connected clients = {}".format(self.factory.number_of_connections)

        
    def connectionLost(self, reason):
        self.factory.number_of_connections -=1
        #print "### Connection lost from the client, current connected clients = {}".format(self.factory.number_of_connections)
         


class GpsStringReceiverFactory(ServerFactory):
    
    number_of_connections = 0
    protocol = GpsStringReceiver
    
        
    def startFactory(self):
        d = devices()
        print "### Starting GpsStringReceiverFactory \nsupported devices {}".format(d.supportedDevices)



def main():
    
    #print "### Running main()"
    factory = GpsStringReceiverFactory()
    reactor.listenTCP(9090, factory, 100)
    reactor.run()
    #print "### Listening on port 9090....."
  
  
  
if __name__ == '__main__':
    main()
    

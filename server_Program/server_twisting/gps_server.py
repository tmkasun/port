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
        ##print "### data = {}".format(self.receivedCsvLine)
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
        all the types of validations related to GPS data
        """
        def digits_of(n):
            return [int(d) for d in str(n)]
        digits = digits_of(imei)
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
        ##print "### Starting approval of vehicle from DB"
        databaseCursor.execute("select imei from approved_imei where imei = '{}'".format(self.imei))
        approvedImeiList = databaseCursor.fetchall()
        ##print approvedImeiList
        ##print self.imei
        
        if len(approvedImeiList) > 0:
            self.isApprovedImei = True
            ##print "IMEI Number is already approved"
            return self.isApprovedImei
        
        ##print "Not an approved IMEI number ({}),this IMEI number will send to approval ".format(self.imei)
        sql = """ insert IGNORE into not_approved_imei values("{}",{},"{}") """.format(self.imei, 0, datetime.now())
        databaseCursor.execute(sql) 
        return self.isApprovedImei



class DbBridge(object):
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
        self._vehicle_id = None
    

    def updatePosition(self,positionData):
        """
        Store information in database 
        @param positionData: contains positioning data speed, altitute, loggitute , latitude and IMEI
        @type positionData: C{MVT380Protocol}
        
        sql = 
        insert into live_status
        (sat_time,sat_status,latitude,longitude,speed,bearing,vehicle_id,location_area_code) 
        values("{}",'{}',{},{},{},{},"{}","{}")
        .format(gpsObject.sat_time, gpsObject.sat_status, gpsObject.latitude, 
        gpsObject.longitude, gpsObject.speed, gpsObject.bearing, gpsObject.imei
        , gpsObject.location_area_code, gpsObject.cell_id)

        """
        #print "####updatePosition ***"
        
        ##print positionData['altitude'].inMeters
        ##print positionData['longitude'].inDecimalDegrees
        ##print positionData['latitude'].inDecimalDegrees
        ##print positionData['time']
        ##print positionData['IMEI']
        ##print positionData['speed'].inMetersPerSecond
        ##print positionData['heading'].inDecimalDegrees
         
        ##print "####loop **************************************\n"
        
        """
        @change: C{query} speed and heading is not need to be stored in database since those data are only
        necessary  for live displaying vehicles on map
        consider to update those values in new relation with imei as reference 
        """
        
        query = """\
        update live_status set \
        sat_time = "{}",\
        latitude = {},\
        longitude = {},\
        speed = {},\
        bearing = {}\
        where vehicle_id = {} \
        """.\
        format(positionData['time'],positionData['latitude'].inDecimalDegrees,positionData['longitude'].inDecimalDegrees,\
        positionData['speed'].inMetersPerSecond,positionData['heading'].inDecimalDegrees,self._vehicle_id)
        print """###Position data updated... on\n\t\
        satalite time = {} \n\t\
        latitude = {} \n\t\
        longitude = {} \n\t\
        speed = {} \n\t\
        bearing = {} \n\t\
        where vehicle id = {} \n\t\
        """.format(positionData['time'],positionData['latitude'].inDecimalDegrees,positionData['longitude'].inDecimalDegrees,\
        positionData['speed'].inMetersPerSecond,positionData['heading'].inDecimalDegrees,self._vehicle_id)
        return self._dbpool.runQuery(query)#.addCallbacks(self.DbSucesses, self.DbError)#.addBoth(self.test#print)
                
    def DbError(self,error):
        ##print "###DbError = ",error
        pass
        
    def _checkIMEI(self,sucessResult,imei):
        print "###Check IMEI with database records..."
        for element in sucessResult:
            if imei == element[0]:
                self._vehicle_id = element[1]
                return True
         
        raise ValueError("Unauthorized IMEI")
        
    
    def validateDevice(self,imei):
        #print "#### validateDevice",imei
        query = """select imei,vehicle_id from vehicle_details where imei = {} """.format(imei)
        ##print query
        return self._dbpool.runQuery(query).addCallback(self._checkIMEI, imei)
        
        
        
    def sendToApproval(self,imei):
        query = """insert into not_approved_imei values("{}",0,now()) ON DUPLICATE KEY UPDATE last_connection_attempt = now()"""\
        .format(imei)
        return self._dbpool.runQuery(query).addBoth(self.shutdownDBBridge)
        
    
    def shutdownDBBridge(self,*args):
        """
            Shutdown function
            It's a required task to shutdown the database connection pool:
                garbage collector doesn't shutdown associated thread
        """
        self._dbpool.close()
    
    
    
class GpsStringReceiver(NMEAProtocol):
    """
        sample GPS strin from MVT380
        $$A138,862170013556541,AAA,35,7.092076,79.960473,140412132808,A,10,9,57,275,1,14,5783799,7403612,413|1|F6E0|3933,0000,000B|0009||02D8|0122,*EE
    """
    
    def __init__(self):

        configurationDetails = ['MySQLdb',
                                '127.0.0.1',
                                'root',
                                
                                'kasun123',
                                'syscall'
                                ]
        #self._AUTHORIZED_CONNECTION = False
        ##print "initializing GpsStringReceiver"
        self._dbBridge = DbBridge(configurationDetails)
        self._isFirstLineFromDevice = True
        self._imei = None
        NMEAProtocol.__init__(self)
        

    def connectionMade(self):
        """
        @change: Send device a controll commands to flush buffered coordinates 
        """
        self.factory.number_of_connections +=1
        try:
            self.transport.setTcpKeepAlive(1)
	    #print "#### Enable Keep alive"
        except AttributeError: pass
	print "### Connection made...\n\tcurrent connected clients = {}\n\tgetPeer = {}".format(self.factory.number_of_connections, self.transport.getPeer())

        
    def connectionLost(self, reason):
        self.factory.number_of_connections -=1
        self._disconnectFromDevice(reason)


    def _initialData(self, sentenceData):
        imei = str(sentenceData['IMEI'])
        validationDeferred = self._dbBridge.validateDevice(imei)
        validationDeferred.addCallbacks\
        (self._authorizedDevice, self._unauthorizedDevice, callbackArgs=(sentenceData,), errbackArgs=(imei,))
        
    
    def _autharization(self):
        """
        @todo: combine _authorizedDevice and _unauthorizedDevice methods for simplicity  
        """
        pass
    
    
    def _authorizedDevice(self,success,positionData):
        print "###Authorized device...!",success
        deviceIMEI = str(positionData['IMEI'])
        self._isFirstLineFromDevice = False
        self._imei = deviceIMEI #FIXME this variable is not necessary
#         query = """insert into vehicle_status(imei,connected_on,current_status)\
#         values("{}",now(),1) ON DUPLICATE KEY UPDATE\
#         connected_on = now(), current_status = 1 """.format(imei)
        query = """\
        insert into live_status (sat_time,latitude,longitude,speed,bearing,vehicle_id,connected_on,disconnected_on)\
        values("{}",{},{},{},{},{},now(),NULL)\
        ON DUPLICATE KEY UPDATE
        sat_time=VALUES(sat_time),latitude=VALUES(latitude),longitude=VALUES(longitude),speed=VALUES(speed),\
        bearing=VALUES(bearing),connected_on=now(),disconnected_on=VALUES(disconnected_on)
        """.\
        format(positionData['time'],positionData['latitude'].inDecimalDegrees,positionData['longitude'].inDecimalDegrees,\
        positionData['speed'].inMetersPerSecond,positionData['heading'].inDecimalDegrees,self._dbBridge._vehicle_id)
        self._dbBridge._dbpool.runQuery(query)
        print "###Update vehicle position and set online flag..."
#         saveDeferred = self._dbBridge.savePosition(positionData)
#         saveDeferred.addCallback(self._setOnlineFlag)

#     def _setOnlineFlag(self,dbReturnedObject,imei):# no longer needed since change the database structure
#         #print "###_setOnlineFlag dbReturnedObject = {} imei = {}".format(dbReturnedObject,imei)
#         query = """insert into vehicle_status(imei,connected_on,current_status)\
#         values("{}",now(),1) ON DUPLICATE KEY UPDATE\
#         connected_on = now(), current_status = 1 """.format(imei)
#          
#         #print "###query = {}".format(query)
#          
#         self._dbBridge._dbpool.runQuery(query)
        
        
    def _unauthorizedDevice(self,error,imei):
        print "###Unauthorized device  send for approval...\n###shutdown dbPool...\n###disconnect device... ",imei
        approvalSentDeferred = self._dbBridge.sendToApproval(imei)
        approvalSentDeferred.addBoth(self._disconnectFromDevice)
    
    
    def _disconnectFromDevice(self,*args):
        print "####Disconnect From Device..."
        self.transport.loseConnection()
        #print "### Connection lost from the client, current connected clients = {} getPeer = {}".format(self.factory.number_of_connections,self.transport.getPeer())
        if self._isFirstLineFromDevice:
            print "###Device init fails...!"
            return True
        #print "down the online flag and shutdown dbpool for this connection reason = {}".format(reason)
        self._resetOnlineFlag(self._imei)
        self._dbBridge.shutdownDBBridge()
        #TODO check wheather this is a valid vehicle if so, run resetflag method to set offline
        #self.transport.abortConnection()
        
        
    def _setConditionalCallbak(self,condition,validDevice = False):
        ##print "###setConditionalCallbak validDevice = {}".format(validDevice)
        if validDevice:
            self._conditionalCallbak = '_fireSentenceCallbacks'
            self._dbBridge.updatePosition(self._sentenceData)
            ##print "### valid device"
            return True
        ##print "### in-valid device"
        self._dbBridge.sendToApproval(self._sentenceData['IMEI'])


    def _resetOnlineFlag(self,imei):
        #print "###_resetOnlineFlag imei = {}".format(imei)
        #FIXME chcek this query??
        query = """update live_status set disconnected_on = now() where vehicle_id = {} """.format(self._dbBridge._vehicle_id)
#         print "###query = {}".format(query)
        self._dbBridge._dbpool.runQuery(query)
        

class GpsStringReceiverFactory(ServerFactory):
    
    number_of_connections = 0
    protocol = GpsStringReceiver
    
        
    def startFactory(self):
        d = devices()
        #print "### Starting GpsStringReceiverFactory \nsupported devices {}".format(d.supportedDevices)



def main():
    
    print "### Running main()"
    factory = GpsStringReceiverFactory()
    reactor.listenTCP(9090, factory, 100)
    reactor.run()
#     print "### Listening on port 9090....."
  
  
  
if __name__ == '__main__':
    main()
    

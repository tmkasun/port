try:
  # try to install MySQLdb module
  import MySQLdb

except ImportError:
  # apt get code apt-get install python-mysqldb
  print "Import failed MySql Database module "

import logging  # reffrence doc http://docs.python.org/2/howto/logging.html
logging.basicConfig(filename="server_tcp.log", format='The event %(levelname)s was occored in %(asctime)s : PID : %(process)d when executing : %(funcName)s @ line number : %(lineno)d', level=logging.DEBUG)

from datetime import datetime

""" 
What we recive from device ===>> example value
------------------------------------------------------------------------------------------------------- 
 serial (=local date and time) ===>> 130825112654
 admin phone number ===>> 
 ---------$GPRMC Recommended Minimum sentence C--------- ===>> GPRMC
 Satellite-Derived Time ===>> 112654.7
 Satellite Fix Status ===>> A
 Latitude Decimal Degrees ===>> 0703.5956
 Latitude Hemisphere ===>> N
 Longitude Decimal Degrees ===>> 07957.6700
 Longitude Hemisphere ===>> E
 Speed(in knots) ===>> 0.0
 Bearing(current direction of travel measured as an azimuth) ===>> 0.00
 UTC Date ===>> 250813
 Magnetic variation ===>> 0.0
 Magnetic variation (East/West) ===>> E
 Mode - A, D, E, N, S with checksum ===>> A*3C
 signal quality F or L ===>> F
 IMEI ===>> imei:359116031998504
 Number of satellites ===>> 07
 altitude in m ===>> 
 Battery status with voltage ===>> F:3.85V
 batterie mode 0 or 1 ===>> 0
 number of chars until field 22 ===>> 120
 some crc ===>> 
 mobile country code ===>> 413
 mobile network code ===>> 01
 location area code in hex ===>> 3A138
 cell id in hex ===>> 767A
"""


# CSV string which we reciving from GPS device is considered as an object
#from sqlalchemy.testing.plugin.noseplugin import logging #unkonw can remove magically appeare
class gpsString:
  def __init__(self, recivedString):
    self.isValidGpsString = False
    self.resonForInvalid = None
    self.isApprovedImei = False
    self.isConnectedToSatellites = False
    print recivedString # for debugging purpose
    # need to debug firmware info and alarm - move, speed, batteries, help me! or "" after F or L Signal quality    F
    if len(recivedString) < 1 :
      self.resonForInvalid = "Invalid String or Connection lost with Client Unexpecedly"
      self.isValidGpsString = False
      return None # this returen is for not execute the below potion of the code otherwise useless
    
    try:
      self.splitedGpsData = recivedString.split(',') # split string by ','
      #this if condition is only for debugging to prevent phone battry low alert ;)
      if len(self.splitedGpsData) == 28:
        self.splitedGpsData.pop(16)
      
      self.imei = self.splitedGpsData[1]#[16][5:] #tk102  
    except IndexError as e:
      print "eexception passed ({}) IMEI split error or wrong position in IMEI in GPS string".format(e)
      logging.error("exception passed for IMEI split error or wrong position in IMEI in GPS string")
      self.isValidGpsString = False
      return None
    
    self.isValidGpsString = True

    try:    
      self.latitude = float(self.splitedGpsData[4])#float(self.splitedGpsData[5][:2]) + float(self.splitedGpsData[5][2:]) / 60.0
      self.longitude = float(self.splitedGpsData[5])#float(self.splitedGpsData[7][:3]) + float(self.splitedGpsData[7][3:]) / 60.0
      self.isConnectedToSatellites = True
    except ValueError:
      print "Device not connected to GPS satalites (lat long passing error)"
      logging.error("Device not connected to GPS satalites (lat long passing error)")
      return None
    self.date = self.splitedGpsData[6]#self.splitedGpsData[11][4:] + self.splitedGpsData[11][2:4] + self.splitedGpsData[11][:2]
    #update +5:30 time zone fix setting device time zone not working :() 
    time = self.splitedGpsData[6]#self.date + self.splitedGpsData[3]
    hours = int(time[6:8])
    minutes = time[8:10]
    seconds = time[10:12]
    minutes = int(minutes) + 30
    if minutes >= 60:
        minutes = minutes%60
        hours +=1    
    #add +5 hours to UTC 0:0
    hours = hours + 5
    # convert single digit number to tow digits
    minutes = "%02d" %(minutes,)
    hours = "%02d" %(hours,)
    
    self.sat_time = time[:6]+hours+minutes+seconds
    #self.serial = self.splitedGpsData[0] # serial = sat_time = date
    #self.phone_number = self.splitedGpsData[1] #useless data
    self.sat_status = self.splitedGpsData[7] #self.splitedGpsData[4]
    self.speed = float(self.splitedGpsData[10])#float(self.splitedGpsData[9]) # speed in km/h
    self.bearing = int(self.splitedGpsData[11]) #float(self.splitedGpsData[10]) # Heading, in unit of degree. decimal digit (0~359)

#ID of the base station including
#MCC|MNC|LAC|CI
#Note: for SMS report, the Base ID is empty.
#MCC and MNC are decimal digits;
#LAC and CI are hexadecimal digits.
    cell_info = self.splitedGpsData[16].split("|")
    self.location_area_code = cell_info[2]#self.splitedGpsData[25] 
    self.cell_id = cell_info[3]#self.splitedGpsData[26]
    print self.splitedGpsData # for debuging purpose


  #(__Currently not using___)
  #this validation is for advance use, this validation is checking for the IMEI pattern
  # Check weather the IMIE number has desired pattern   
  def validateImie(self):
    if not self.isValidLuhnChecksum(imei): # need to debug were this imei coming from :P
      print imei  # only for debuging
      self.disconnect("invalid" + imie)
      return False
  
  def isValidLuhnChecksum(self, card_number):
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
  
  # Check weather the vehicle is an approved one(is in the approved vehicles DB) 
  def validateVehicleFromDB(self,databaseCursor): #take newConnection database cursor as a argument 
    print "Starting approval of vehicle from DB"
    databaseCursor.execute("select imei from approved_imei where imei = '{}'".format(self.imei))
    approvedImeiList = databaseCursor.fetchall()
    print approvedImeiList
    print self.imei
    
    if len(approvedImeiList) > 0:
      self.isApprovedImei = True
      print "IMEI Number is already approved"
      return self.isApprovedImei
    
    print "Not an approved IMEI number ({}),this IMEI number will send to approval ".format(self.imei)
    sql = """ insert IGNORE into not_approved_imei values("{}",{},"{}") """.format(self.imei, 0, datetime.now())
    databaseCursor.execute(sql) 
    return self.isApprovedImei
    
    

#custom Exception raised when recived GPS string containt null character 
class emptyGpsStringError(Exception):
  
  def __init__(self,message):
    self.errorMessage = message
    Exception.__init__(self,message)
    
  def __str__(self):
    return repr(self.errorMessage)

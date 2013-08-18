#! /usr/bin/python

#================================================================================
"""
Copyright (c) 2013 All Right Reserved, http://www.itfac.mrt.ac.lk
This source is subject to the GNU General Public License
</copyright>
<author>SysCall@UOM.itfac</author>
<email>syscall@knnect.com</email>
<date>2013-08-05</date>
<summary>Contains an optmizer for GPS location coordinates
This programm is designed to run on Amazone EC2 instances, running in other platforms may result in unexpected outputs,
This is an Open source project and you may take  this program as u wish with some rights reserved by www.itfac.mrt.ac.lk
Be open :)</summary>
"""
#================================================================================

"""
-------------------------------
For documentation purpose
-------------------------------

---------------------Haversine formula-------------------
From Wikipedia, the free encyclopedia

The haversine formula is an equation important in navigation, giving great-circle distances between two points on a sphere from
their longitudes and latitudes. It is a special case of a more general formula in spherical trigonometry, the law of haversines,
relating the sides and angles of spherical triangles.

These names follow from the fact that they are customarily written in terms of the haversine function, given by haversin(θ) = sin^2(θ/2).
The formulas could equally be written in terms of any multiple of the haversine, such as the older versine function (twice the haversine).
Historically, the haversine had, perhaps, a slight advantage in that its maximum is one, so that logarithmic tables of its values could end at
zero. These days, the haversine form is also convenient in that it has no coefficient in front of the sin^2 function.
"""

#================================================================================
# coding style CC python ie: variableName, ClassName ,functionName, _specialVariableName_
#================================================================================

import math

#================================================================================
# Getting the distance between two location coordinates
#================================================================================
def haversineDistance(oldLatitude,oldLongitude,newLatitude,newLongitude):
    _radius_ = 6731 *1000  # radius of the earth in meters
    rLat1, rLat2, rLon1, rLon2 = map(math.radians,[oldLatitude,newLatitude,oldLongitude,newLongitude])
    dLon = rLon2 - rLon1
    dLat = rLat2 - rLat1
    a = math.pow(math.sin(dLat/2),2) + math.cos(rLat1) * math.cos(rLat2) * math.pow(math.sin(dLon/2),2)
    c = 2 * math.atan2(math.sqrt(a), math.sqrt(1-a))
    return _radius_ * c

#================================================================================
# Getting the time difference of the last record and the newly arrived records
#================================================================================
def timeDifference(oldTime,newTime):
    #to be implemented
    return 11

#================================================================================
# Check wheter  newly arrived coordintes to be inserted to the table or not
# if 1 returned coordinates will be ignored otherwised they will be inserted
#================================================================================
def checkOptimize(oldTime,newTime,oldLat,oldLon,newLat,newLon):
    _minTime_ = 10 # minimum time is 10 seconds
    _minDistance_ = 10 # minimum distance allowed is 10 meters
    distance = haversineDistance(oldLat,oldLon,newLat,newLon)
    dTime = timeDifference(oldTime,newTime)
    if distance<=_minDistance_ and dTime<=_minTime_:
        return 1
    else:
        return 0

import threading
import socket #documentation http://docs.python.org/2/howto/sockets.html , http://docs.python.org/2/library/socket.html
from fileinput import filename
try:
  # try to install MySQLdb module
  import MySQLdb

except ImportError:
  # apt get code apt-get install python-mysqldb
  print "Import failed MySql Database module "

import time
from datetime import datetime
import os  # for configure linux server



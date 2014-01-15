
class devices():
    
    supportedDevices = ["tk102"]
    
    def deviceInfo(self,device):
        print "This is TK102 Device driver for sysCall"
        return device.details
    
    def addNewDevice(self):
        raise NotImplementedError( "Should have implemented this" )
        
    

class deviceTk102(devices):
    
    def __init__(self):
        self.name = "tk102"
    
    def info(self):
        return self.name
    
    
    
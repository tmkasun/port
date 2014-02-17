from twisted.internet import reactor
from twisted.internet.defer import Deferred
from twisted.internet.protocol import Protocol, ServerFactory
from twisted.protocols.basic import LineReceiver
from twisted.python.failure import Failure


def testDeferred():
    return Deferred()

def defret():
    d = Deferred()
    reactor.callLater(2,d.callback,"Failure()")
    return d

def fk(a):
    print "this is fk data = int fk",a
    
def error1(result):
    print "This is errorback 1, i raise error result = {}".format(result)

def error2(result):
    print "This is errorback 2, i result.trap(KeyError) "
    print "**********************8 yooo before trap "
    e = result.trap(ValueError)
    print "**********************8 yooo after trap "    
    print e
    
def error3(result):
    print "This is errorback 3, i return true expection callback4 to trigger result = {}".format(result)
    return "Result from error3"
    
def callback1(result):
    print "This is callback 1 result = {}".format(result)
    raise ValueError

def callback2(result):
    print "This is callback 2 result = {}".format(result)
    return True

def callback3(result):
    print "This is callback 3 result = {}".format(result)
    return True

def callback4(result):
    print "This is callback 4 result = {}".format(result)
    return True

    
def main():
    print "# in main"
    returnedDefer = defret()
    returnedDefer.addCallbacks(callback1,error1)
    returnedDefer.addCallbacks(callback2,error2)
    returnedDefer.addCallbacks(callback3,error3)
    returnedDefer.addCallback(callback4)
    reactor.run()
    
    

if __name__ == '__main__':
    print "# start main"
    main()
    
    
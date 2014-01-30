
class A(object):
    
    def aMethod(self):
        print "This is class A method "
        
    def stest(self):
        print "This is class A super test"

    def psupper(self):
        super(A, self).cMethod()

class B(object):
    
    def bMethod(self):
        print "This is class B method "
        
        
class C(object):
    
    def bMethod(self):
        print "This is class C method "

    def cMethod(self):
        print "This is class C method "

class Noo():

    def normal_method(self):
        print "This is a normal method" 
        
    @classmethod
    def  alone(cls):
        
        print "This is noo method ..................................."

    @staticmethod

    def staticm():

        print "This is a static method"
        
class Mixed(A,C,B):
    
    def mixed_class(self):
        print "This is mixed class"

    def supr(self):
        super(Mixed, self).stest()
        
##class Other(object):
##
##    def override(self):
##        print "OTHER override()"
##
##    def implicit(self):
##        print "OTHER implicit()"
##
##    def altered(self):
##        print "OTHER altered()"
##
##class Child(object):
##
##    def __init__(self):
##        self.other = Other()
##
##    def implicit(self):
##        self.other.implicit()
##
##    def override(self):
##        print "CHILD override()"
##
##    def altered(self):
##        print "CHILD, BEFORE OTHER altered()"
##        self.other.altered()
##        print "CHILD, AFTER OTHER altered()"
##
##son = Child()
##
##son.implicit()
##son.override()
##son.altered()

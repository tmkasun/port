from IPython.core.pylabtools import select_figure_formats

__author__ = 'kbsoft'

from twisted.internet import reactor, protocol
from twisted.enterprise import adbapi
import time


class Capture(object, protocol.Protocol):
    """
    This captures the incoming TCP data and store it on DB for later display
    """

    def __init__(self):
        print("DEBUG: Initing Capture")
        self.db = DbBridge()
        super(Capture, self).__init__()

    def connectionMade(self):
        print("Connection made from ")
        client = self.transport.client
        self.db.addTestData("Connection Made", client)

    def dataReceived(self, data):
        # global do
        client = self.transport.client
        self.db.addTestData(data, client)
        print("Data = {}".format(data))
        # do = self.transport
        # reactor.stop()


class DbBridge(object):
    """
    Manage connections and data in/out flow with server
    """

    def __init__(self):
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
        self._configurationDetails = ['MySQLdb',
                                      '127.0.0.1',
                                      'root',

                                      'vts@123',
                                      'testing'
        ]
        self._dbpool = adbapi.ConnectionPool(*self._configurationDetails)


    def addTestData(self, test_data, client):
        current_time = time.strftime("%Y-%m-%d %H:%M:%S")
        host_port = "{}:{}".format(client[0], client[1])
        query = """\
        insert into tests(title,message,created_at,updated_at) values("{}","{}","{}","{}")
        """. \
            format(host_port, test_data, current_time, current_time)
        print("Query = {}".format(query))
        return self._dbpool.runQuery(query)  # .addCallbacks(self.DbSucesses, self.DbError)#.addBoth(self.test#print)

    def DbError(self, error):
        # #print "###DbError = ",error
        pass


do = None


def main():
    factory = protocol.ServerFactory()
    factory.protocol = Capture
    reactor.listenTCP(9090, factory)
    print("Server running on port 9090")
    reactor.run()


if __name__ == '__main__':
    main()

#client.py

import socket

def main():
	print "ok"
	client = socket.socket()
	server_address = raw_input("Enter Server address: ")
	client.connect((server_address,12332))
	print client.recv(1024)
	
	while True:
    		message = raw_input("Enter A message to send:")
    		client.send(message)
    		print "Message Sent sucssesfully and waiting for a message"
    		client_message = client.recv(1024)
    		print client_message 
    		if (message == "exit") or (client_message == "exit_client") :
      			print "Bye :("
			client.send("exit_client")
      			client.close()
			break
	

if __name__ == "__main__":
	main()

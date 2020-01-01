import paho.mqtt.client as mqtt #pour pouvoir se connecter au broker mqtt
import mysql.connector as mariadb
import os

def charge_topics():
    cursor = mariadb_connection.cursor()
    topics = []
    cursor.execute("SELECT ID, topic_MQTT FROM enigmes WHERE type_signal_fin = 1")
    for ID, topic in cursor:
        sous_liste = [ID, str(topic)]
        topics.append(sous_liste)
    return topics

def on_connect(client, userdata, flags, rc): #permet de verifier que le raspberry est bien connecte au broker
    print("Connected with result code " + str(rc))
    client.subscribe("LCDB")
    
def on_message(client, userdata, msg): #definit un evenement sur chaque message
    mess = str(msg.payload)
    for i in charge_topics():
		if(i[1]==mess):
			os.system("python /home/pi/cloturer_enigme.py "+str(i[0]))
    
mariadb_connection = mariadb.connect(user='root',password='KqJ=4^QDf6._~]ET^k5u',database='telephone')
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message
client.connect("192.168.43.146", 1883, 60) #connecte le client au broker mqtt
topics = charge_topics()
client.loop_forever()

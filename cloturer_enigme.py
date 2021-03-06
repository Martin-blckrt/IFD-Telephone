import mysql.connector as mariadb
import os
import sys
from datetime import datetime
import time
import RPi.GPIO as GPIO

args = sys.argv
ID_enigme = int(args[1])

BuzzerPin = 10    # pin10
pin_racc = 16

SPEED = 1

# Les notes de musique (en fait ce sont des frequences)
TONES = {
        "sol1":500,
        "sol3":1500,
}

# La sonnerie
SONG = [
    ["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],
    ]

def setup():
    GPIO.setmode(GPIO.BOARD) 
    GPIO.setup(BuzzerPin, GPIO.OUT)
    GPIO.setup(pin_racc,GPIO.IN,pull_up_down=GPIO.PUD_DOWN)

def playTone(p,tone):
        # Calcul de la duree de la note
    duration = tone[1]

    if tone[0] == "p": # p => pause
        time.sleep(duration)
    else: # 
        frequency = TONES[tone[0]]
        p.ChangeFrequency(frequency)
        p.start(0.5)
        time.sleep(duration)
        p.stop()

def run():
    p = GPIO.PWM(BuzzerPin, 440)
    p.start(0.5)
    for t in SONG:
        playTone(p,t)

def destroy():
    GPIO.output(BuzzerPin, GPIO.HIGH)
    GPIO.cleanup()                     


def getcurrentgameid():
    cursor = mariadb_connection.cursor()
    cursor.execute("SELECT MAX(ID) AS maxi FROM parties")
    for maxi in cursor:
        return int(maxi[0])

def getstate(ID):
    cursor = mariadb_connection.cursor()
    cursor.execute("SELECT etat FROM details_parties WHERE ID_partie = "+str(getcurrentgameid())+" AND ID_enigme = "+str(ID))
    for etat in cursor:
        return int(etat[0])

def setstate(ID,new_state):
	cursor = mariadb_connection.cursor()
	cursor.execute("UPDATE details_parties SET etat = "+str(new_state)+" WHERE ID_partie = "+str(getcurrentgameid())+" AND ID_enigme = "+str(ID))

def updateduration(ID):
	cursor = mariadb_connection.cursor()
	cursor.execute("UPDATE details_parties SET duree_resolution = TIMEDIFF(UTC_TIMESTAMP(),(SELECT date_debut FROM parties WHERE ID = "+str(getcurrentgameid())+")) WHERE ID_partie = "+str(getcurrentgameid())+" AND ID_enigme = "+str(ID))
	#cursor.commit()

def charge_messages_fin():
    cursor = mariadb_connection.cursor()
    messages_fin = []
    cursor.execute("SELECT ID, type_message_fin, texte_message_fin FROM enigmes") #premiere passe pour les indices 1
    for ID, type_message_fin, texte_message_fin in cursor:
        sous_liste = [ID, type_message_fin, str(texte_message_fin)]
        messages_fin.append(sous_liste)
    return messages_fin

mariadb_connection = mariadb.connect(user='root',password='KqJ=4^QDf6._~]ET^k5u',database='telephone')

cursor = mariadb_connection.cursor()

etat_courant = getstate(ID_enigme)
nouvel_etat = 0
if(etat_courant==1 or etat_courant==2):
	nouvel_etat=etat_courant+2
else:
	nouvel_etat=5
setstate(ID_enigme,nouvel_etat)
updateduration(ID_enigme)
#sonnerie pour donner message final (a charger a partir de la BDD)

messages_fin = charge_messages_fin()
print messages_fin

for i in messages_fin:
	if(i[0]==ID_enigme):
		if(i[1]==1 or i[1]==2):
			setup()
			type_mess=i[1]-1
			run()
			run()
			while(GPIO.input(pin_racc) == GPIO.HIGH):
				run()    
			pass
			if(type_mess==0): #c'est un message qui doit etre lu par un bot
				message = str(i[2])
				os.system("/home/pi/speech.sh "+message)
			else: #c'est une bande son qui doit etre jouee
				bande = str(i[0])+".mp3"
				os.system("omxplayer "+"/var/www/html/sons_enigmes/messages_fin/"+bande);
			GPIO.cleanup()

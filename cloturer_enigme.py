import mysql.connector as mariadb
import os #pour la partie synthese vocale
import sys
from datetime import datetime
import time

args = sys.argv
ID_enigme = int(args[1])


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
#print datetime.strptime(date_debut, '%Y-%m-%d %H:%M:%S')


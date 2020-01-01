#!/usr/bin/python
import mysql.connector as mariadb
import RPi.GPIO as GPIO #pour pouvoir communiquer avec les ports GPIO = General Purpose Input Output
import time #pour pouvoir faire des pauses
import math #pour la fonction puissance math.pow(x,n)
import os #pour la partie synthese vocale
import subprocess

mariadb_connection = mariadb.connect(user='root',password='KqJ=4^QDf6._~]ET^k5u',database='telephone')

pin_btn = 12    #le cadran est branche sur l entree 10 (numero BOARD)

GPIO.setmode(GPIO.BOARD)
GPIO.setup(pin_btn,GPIO.IN,pull_up_down=GPIO.PUD_DOWN)

pin_racc = 16

GPIO.setup(pin_racc,GPIO.IN,pull_up_down=GPIO.PUD_DOWN)

def compose_numero():
    nb_chiffres = 3
    num = 0
    rang = 0
    while(rang<nb_chiffres):
        a = 0
        while GPIO.input(pin_btn) == GPIO.HIGH:
            time.sleep(0.01)
            pass
        start = time.time()
        while (time.time()-start)<=1.2:
            if GPIO.input(pin_btn) == GPIO.LOW:
                a+=1
                while GPIO.input(pin_btn) == GPIO.LOW:
                    time.sleep(0.01)
                    pass
        #attention il y a une exception a gerer : le numero 0 produit 10 impulsions, d ou la ligne suivante
        if a >= 10:
            a=0
        num += a*math.pow(10,nb_chiffres-rang-1)    #on ajoute a num le chiffre rentre en placant au bon rang (c-a-d a la bonne puissance de 10)
        rang += 1   #on incremente rang de 1 pour passer a la puissance de 10 suivante au prochain coup
        os.system("aplay /home/pi/retours_chiffres/"+str(a)+".wav")
    return num

def charge_nums():
    cursor = mariadb_connection.cursor()
    nums_tel = []
    cursor.execute("SELECT ID, numero_tel FROM enigmes")
    for ID, numero_tel in cursor:
        sous_liste = [ID,numero_tel]
        nums_tel.append(sous_liste)
    return nums_tel

def dire(phrase):
    os.system("./home/pi/speech.sh "+str(phrase))

def charge_indices():
    cursor = mariadb_connection.cursor()
    indices = []
    cursor.execute("SELECT ID, type_indice_1, texte_indice_1 FROM enigmes") #premiere passe pour les indices 1
    for ID, type_indice_1, texte_indice_1 in cursor:
        sous_liste = [ID, 1,type_indice_1, str(texte_indice_1)]
        indices.append(sous_liste)
    cursor.execute("SELECT ID, type_indice_2, texte_indice_2 FROM enigmes") #deuxieme passe pour les indices 2
    for ID, type_indice_2, texte_indice_2 in cursor:
        sous_liste = [ID, 2,type_indice_2, str(texte_indice_2)]
        indices.append(sous_liste)
    return indices

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

def indice_existe(liste_indices, ID_enigme, type_indice):
    for indice in liste_indices:
        if(indice[0]==ID_enigme and indice[1]==type_indice):
            if(indice[2]==1 or indice[2]==2):
                return 1
            else:
                return 0

def donner_indice(liste_indices, ID_enigme, type_indice):
    for indice in liste_indices:
        if(indice[0]==ID_enigme and indice[1]==type_indice):
            if(indice[2]==1): #c est un message a lire
                dire(indice[3])
            elif(indice[2]==2):
                #print("omxplayer /var/www/html/sons_enigmes/indices_"+str(type_indice)+"/"+str(ID_enigme)+".mp3")
                os.system("omxplayer /var/www/html/sons_enigmes/indices_"+str(type_indice)+"/"+str(ID_enigme)+".mp3")
            setstate(ID_enigme,type_indice)
#print "Partie en cours : ",getcurrentgameid()

intro_dite=0

while(1):
    nouv_num = compose_numero()
    if(nouv_num==0):    #demande d aide de la part des joueurs
        '''
        duree = 15
        dire("Vous avez demander une aide exterieure, decrivez votre probleme en parlant dans le telephone pendant "+str(duree)+" secondes apres le bip sonore.")
        time.sleep(1)
        os.system("aplay /home/pi/bip_sonore.wav")
        os.system("arecord -D hw:1,0 -d "+str(duree)+" -f cd /home/pi/help_request.wav -c 1")
        time.sleep(duree+1)
        os.system("aplay /home/pi/bip_sonore.wav")
        dire("Votre message vient detre transmis, nous allons vous repondre")
        os.system("sox /home/pi/help_request.wav /home/pi/help_requestAMP.wav vol 31 dB")
        os.system("lame --decode /home/pi/help_requestAMP.wav /var/www/html/help.mp3")
        time.sleep(2)
        #os.system("omxplayer /home/pi/help.mp3")
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO help_request(traitee) VALUES (0)")
        mariadb_connection.commit()
        '''
        proc_args=['arecord', '-D', 'hw:1,0','-d','60','-f','cd','-c','1','/home/pi/help_request.wav']
        while(GPIO.input(pin_racc) == GPIO.HIGH):
            dire("Veuillez decrocher le haut parleur.")
            time.sleep(1)
        if(intro_dite==0):
            dire("Vous avez demander une aide exterieure, decrivez votre probleme en parlant dans le telephone apres le bip sonore et terminez en raccrochant le haut parleur.")
            intro_dite=1
        os.system("aplay /home/pi/bip_sonore.wav")
        a=subprocess.Popen(proc_args,shell=False)
        while(GPIO.input(pin_racc) == GPIO.HIGH):
            time.sleep(0.5)
        while(GPIO.input(pin_racc) == GPIO.LOW):
            time.sleep(0.5)
        a.terminate()
        time.sleep(1)
        os.system("aplay /home/pi/bip_sonore.wav")
        dire("Votre message vient detre transmis, nous allons vous repondre")
        time.sleep(1)
        os.system("sox /home/pi/help_request.wav /home/pi/help_requestAMP.wav vol 31 dB")
        time.sleep(1)
        #os.system("rm /var/www/html/help.mp3")
        os.system("lame --decode /home/pi/help_requestAMP.wav /var/www/html/help.mp3")
        #os.system("omxplayer /home/pi/help.mp3")
        cursor = mariadb_connection.cursor()
        cursor.execute("INSERT INTO help_request(traitee) VALUES (0)")
        mariadb_connection.commit()
        
    else:
        liste_nums = charge_nums()
        print liste_nums
        liste_indices = charge_indices()
        num_trouve = 0
        for i in liste_nums:
            if(i[1]== nouv_num):
                num_trouve = 1
                ID_enigme = i[0]
                #print "Numero attribue a l enigme "+str(i[0])
                etat = getstate(ID_enigme)
                if (etat<=1):
                    if(indice_existe(liste_indices, ID_enigme, etat+1)):
                       dire("Voici lindice :")
                       donner_indice(liste_indices, ID_enigme, etat+1)
                    else:
                       dire("Il nexiste pas, ou plus dindice pour cette enigme")
                       
                else:
                    dire("Desoler, vous avez deja eu tous les indices possibles pour cette enigme")
        
                    
                
        if (num_trouve==0):
            #print "Numero non attribue"
            dire("Le numero que vous avez composer ne correspond a aucune enigme, veuillez recommencer")
       

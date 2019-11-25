import RPi.GPIO as GPIO #pour pouvoir communiquer avec les ports GPIO = General Purpose Input Output
import time #pour pouvoir faire des pauses
import math #pour la fonction puissance math.pow(x,n)
import os #pour la partie synthese vocale

pin_btn = 10    #le cadran est branche sur l entree 10 (numero BOARD)

GPIO.setmode(GPIO.BOARD)
GPIO.setup(pin_btn,GPIO.IN,pull_up_down=GPIO.PUD_DOWN)

rep = raw_input("Voulez-vous utiliser la synthese vocale ? (Y/n) : ")
if(rep=="Y"):
    son = 1
else:
    son = 0
    pass

def compose_numero():
    nb_chiffres = 4
    num = 0
    rang = 0
    print "Composez un numero a ",nb_chiffres," chiffres :"
    while(rang<nb_chiffres):
        a = 0
        while GPIO.input(pin_btn) == GPIO.HIGH:
            time.sleep(0.01)
            pass
        start = time.time()
        while (time.time()-start)<=0.8:
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
        print (a)
        if son:
            os.system("./speech.sh "+str(int(a)))
    return num

phrase = "Vous avez compose le " + str(int(compose_numero())) + ", nous allons vous repondre..."
print(phrase)
if son:
    os.system("./speech.sh "+phrase)
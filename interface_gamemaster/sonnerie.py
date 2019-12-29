#!/usr/bin/env python
import RPi.GPIO as GPIO
import time
import os
import sys

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

if __name__ == '__main__':     
    setup()
    try:
        run()
        run()
        while(GPIO.input(pin_racc) == GPIO.HIGH):
            run()    
        pass
        args = sys.argv
        type_mess = int(args[1])
        if(type_mess==0): #c'est un message qui doit etre lu par un bot
            message = str(args[2])
            os.system("./speech.sh "+message)
        else: #c'est une bande son qui doit etre jouee
            bande = str(args[2])+".mp3"
            os.system("omxplayer "+"bandes_sons/"+bande);
        GPIO.cleanup()
        
    except KeyboardInterrupt:  
        destroy()

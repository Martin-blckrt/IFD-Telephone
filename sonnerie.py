#!/usr/bin/env python
import RPi.GPIO as GPIO
import time

BuzzerPin = 10    # pin10

SPEED = 1

# Les notes de musique (en fait ce sont des frequences)
TONES = {
        "do1":131,
        "re1":147,
        "mi1":165,
        "fa1":175,
        "sol1":500,
        "la1":221,
        "si1":248,        
        "do2":262,
        "re2":294,
        "mi2":330,
        "fa2":350,
        "sol2":1000,
        "la2":441,
        "si2":495,
        "do3":525,
	"dod5":555,
        "re3":2000,
        "mi3":661,
        "fa3":700,
        "sol3":1500,
        "la3":882,
        "si3":990,        
        "c6":1047,
	"b5":988,
	"a5":880,
	"g5":784,
	"f5":698,
	"e5":659,
	"eb5":622,
	"d5":587,
	"c5":523,
	"b4":494,
	"a4":440,
	"ab4":415,
	"g4":392,
	"f4":349,
	"e4":330,
	"d4":294,
	"c4":262,
}



# La chanson
"""
SONG =	[
	["re3",16],["re3",16],["mi3",16],["mi3",16],
	["si2",16],["si2",16],["re3",8],
	["re3",16],["re3",16],["mi3",16],["mi3",16],
	["si2",16],["si2",16],["re3",8],
        ["re3",16],["re3",16],["mi3",16],["mi3",16],
        ["sol3",16],["sol3",16],["fa3",8],["fa3",8],
        ["mi3",8],["re3",8],["do3",8]
        
	]
"""
"""
SONG =  [
        ["e5",1000],["p",2000],["dod5",16],["dod5",16],["b4",16],["dod5",16],["e5",16]
        ]
"""

SONG = [
	["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],
["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],
["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],
["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],
["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],
["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],
["sol1",0.1],["sol3",0.1],["sol1",0.1],["sol3",0.1],

	]

def setup():
	GPIO.setmode(GPIO.BOARD) 
	GPIO.setup(BuzzerPin, GPIO.OUT)

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
		GPIO.cleanup()
	except KeyboardInterrupt:  
		destroy()

import RPi.GPIO as GPIO
import time

pin_btn = 10

GPIO.setmode(GPIO.BOARD)
GPIO.setup(pin_btn,GPIO.IN,pull_up_down=GPIO.PUD_DOWN)

a=0

while(1):
    if GPIO.input(pin_btn) == GPIO.HIGH:
        a=a+1
        print "Nombre d'appuis : ",a
        while GPIO.input(pin_btn) == GPIO.HIGH:
            pass


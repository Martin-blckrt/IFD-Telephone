import RPi.GPIO as GPIO
import time

pin_led = 3

GPIO.setmode(GPIO.BCM)
GPIO.setup(pin_led,GPIO.OUT)

while(1):
    GPIO.output(pin_led,GPIO.HIGH)
    time.sleep(0.5)
    GPIO.output(pin_led, GPIO.LOW)
    time.sleep(0.5)
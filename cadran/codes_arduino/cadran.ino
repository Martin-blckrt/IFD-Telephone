int cadran = 12;

void setup() {
  pinMode(cadran, INPUT_PULLUP);
  Serial.begin(9600);
}


void loop() {

  int numero = 0;
  while (!digitalRead(cadran)) { //tant que le cadran est à 0, on attend le premier front montant
    delay(10);
  }
  boolean fin = false;
  unsigned long temps = millis();
  while ((!fin)&&(millis()-temps<3000)) {
    if (digitalRead(cadran)) {
      numero++;
      while (digitalRead(cadran)) {
        delay(10);
      }
    }
  }
  Serial.print("NOUVEAU NUMERO COMPOSE : ");
  Serial.println(numero);
}

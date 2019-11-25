int buzzer = 3;
void setup() {
  pinMode(buzzer, OUTPUT);
}

void sonnerie(){
  tone(buzzer, 8000, 100);
  delay(100);
  tone(buzzer, 2000, 100);
  delay(100);
}

void loop() {
  for(int i = 0; i<5; i++){
    sonnerie();
  }
  delay(2000);
}

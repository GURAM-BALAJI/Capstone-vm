#include <SoftwareSerial.h>
void setup() {
  // Open serial communications and wait for port to open:
  Serial.begin(115200);
  while (!Serial) {
    ;  // wait for serial port to connect. Needed for native USB port only
  }
  pinMode(0, OUTPUT);
  pinMode(1, OUTPUT);
  pinMode(2, OUTPUT);
  pinMode(3, OUTPUT);
  pinMode(4, OUTPUT);
  pinMode(5, OUTPUT);
  pinMode(6, OUTPUT);
  pinMode(7, OUTPUT);
  pinMode(8, OUTPUT);
  pinMode(9, OUTPUT);
  pinMode(10, OUTPUT);
  pinMode(11, OUTPUT);
  pinMode(12, OUTPUT);
  pinMode(13, OUTPUT);
}
void loop() {
  if (Serial.available()) {
    int n,i;
    String str = "00010101020103010401050106010701080109011001110112011301";

    for (n = 0; n <= 56; n = n + 4) {
      for (i = 1; i <= str.substring(n + 2, (n + 4)).toInt(); i++) {
        digitalWrite(str.substring(n, (n + 2)).toInt(), HIGH);
        delay(2000);
        digitalWrite(str.substring(n, (n + 2)).toInt(), LOW);
        delay(3000);
        Serial.println(str.substring(n, (n + 2)).toInt());
      }
    }
  }
}
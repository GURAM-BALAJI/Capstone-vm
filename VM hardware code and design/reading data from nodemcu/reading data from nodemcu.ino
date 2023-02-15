#include <SoftwareSerial.h>
#define MOTER1 22
#define MOTER2 23
#define MOTER3 24
#define MOTER4 25
#define MOTER5 26
#define MOTER6 27
#define MOTER7 28
#define MOTER8 29
#define MOTER9 30
#define MOTER10 31
#define MOTER11 32
#define MOTER12 33
#define MOTER13 34
#define MOTER14 35
#define MOTER15 36
#define MOTER16 37
#define MOTER17 38
#define MOTER18 39
#define MOTER19 40
#define MOTER20 41
#define MOTER21 42
#define MOTER22 43
#define MOTER23 44
#define MOTER24 45
SoftwareSerial espSerial(5, 6);
void setup() {
  // Open serial communications and wait for port to open:
  Serial.begin(115200);
  espSerial.begin(115200);
  while (!Serial) {
    ;  // wait for serial port to connect. Needed for native USB port only
  }
  pinMode(MOTER1, OUTPUT);
  pinMode(MOTER2, OUTPUT);
  pinMode(MOTER3, OUTPUT);
  pinMode(MOTER4, OUTPUT);
  pinMode(MOTER5, OUTPUT);
  pinMode(MOTER6, OUTPUT);
  pinMode(MOTER7, OUTPUT);
  pinMode(MOTER8, OUTPUT);
  pinMode(MOTER9, OUTPUT);
  pinMode(MOTER10, OUTPUT);
  pinMode(MOTER11, OUTPUT);
  pinMode(MOTER12, OUTPUT);
  pinMode(MOTER13, OUTPUT);
  pinMode(MOTER14, OUTPUT);
  pinMode(MOTER15, OUTPUT);
  pinMode(MOTER16, OUTPUT);
  pinMode(MOTER17, OUTPUT);
  pinMode(MOTER18, OUTPUT);
  pinMode(MOTER19, OUTPUT);
  pinMode(MOTER20, OUTPUT);
  pinMode(MOTER21, OUTPUT);
  pinMode(MOTER22, OUTPUT);
  pinMode(MOTER23, OUTPUT);
  pinMode(MOTER24, OUTPUT);
}
void loop() {
  if (Serial.available()) {
    int N, n, i, count = 0, items[10], qty[10];
    String str = String(Serial.read());
    String chk = str.substring(0, 7);
    if (chk == "balaji") {
      str = str.substring(7);
      N = str.length();
      for (i = 0; i < 10; i++)
        items[i] = qty[i] = 0;
      for (n = 0; n < N; n = n + 4) {
        items[count] = str.substring(n, (n + 2)).toInt();
        qty[count] = str.substring(n + 2, (n + 4)).toInt();
        count++;
      }
      for (n = 0; n < N / 4; n++) {
        switch (items[n]) {
          case 1:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER1, HIGH);
              delay(2000);
              digitalWrite(MOTER1, LOW);
              delay(3000);
            }
            break;
          case 2:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER2, HIGH);
              delay(2000);
              digitalWrite(MOTER2, LOW);
              delay(3000);
            }
            break;
          case 3:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER3, HIGH);
              delay(2000);
              digitalWrite(MOTER3, LOW);
              delay(3000);
            }
            break;
          case 4:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER4, HIGH);
              delay(2000);
              digitalWrite(MOTER4, LOW);
              delay(3000);
            }
            break;
          case 5:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER5, HIGH);
              delay(2000);
              digitalWrite(MOTER5, LOW);
              delay(3000);
            }
            break;
          case 6:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER6, HIGH);
              delay(2000);
              digitalWrite(MOTER6, LOW);
              delay(3000);
            }
            break;
          case 7:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER7, HIGH);
              delay(2000);
              digitalWrite(MOTER7, LOW);
              delay(3000);
            }
            break;
          case 8:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER8, HIGH);
              delay(2000);
              digitalWrite(MOTER8, LOW);
              delay(3000);
            }
            break;
          case 9:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER9, HIGH);
              delay(2000);
              digitalWrite(MOTER9, LOW);
              delay(3000);
            }
            break;
          case 10:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER10, HIGH);
              delay(2000);
              digitalWrite(MOTER10, LOW);
              delay(3000);
            }
            break;
          case 11:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER11, HIGH);
              delay(2000);
              digitalWrite(MOTER11, LOW);
              delay(3000);
            }
            break;
          case 12:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER12, HIGH);
              delay(2000);
              digitalWrite(MOTER12, LOW);
              delay(3000);
            }
            break;
          case 13:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER13, HIGH);
              delay(2000);
              digitalWrite(MOTER13, LOW);
              delay(3000);
            }
            break;
          case 14:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER14, HIGH);
              delay(2000);
              digitalWrite(MOTER14, LOW);
              delay(3000);
            }
            break;
          case 15:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER15, HIGH);
              delay(2000);
              digitalWrite(MOTER15, LOW);
              delay(3000);
            }
            break;
          case 16:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER16, HIGH);
              delay(2000);
              digitalWrite(MOTER16, LOW);
              delay(3000);
            }
            break;
          case 17:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER17, HIGH);
              delay(2000);
              digitalWrite(MOTER17, LOW);
              delay(3000);
            }
            break;
          case 18:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER18, HIGH);
              delay(2000);
              digitalWrite(MOTER18, LOW);
              delay(3000);
            }
            break;
          case 19:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER19, HIGH);
              delay(2000);
              digitalWrite(MOTER19, LOW);
              delay(3000);
            }
            break;
          case 20:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER20, HIGH);
              delay(2000);
              digitalWrite(MOTER20, LOW);
              delay(3000);
            }
            break;
          case 21:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER21, HIGH);
              delay(2000);
              digitalWrite(MOTER21, LOW);
              delay(3000);
            }
            break;
          case 22:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER22, HIGH);
              delay(2000);
              digitalWrite(MOTER22, LOW);
              delay(3000);
            }
            break;
          case 23:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER23, HIGH);
              delay(2000);
              digitalWrite(MOTER23, LOW);
              delay(3000);
            }
            break;
          case 24:
            for (i = 1; i <= qty[n]; i++) {
              digitalWrite(MOTER24, HIGH);
              delay(2000);
              digitalWrite(MOTER24, LOW);
              delay(3000);
            }
            break;
          default:
            Serial.println("Wrong inputs.");
            break;
        }
      }
      espSerial.println(str);
    }
  }
}
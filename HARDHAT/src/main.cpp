#include <Arduino.h>
#include <WiFi.h>
#include <WiFiManager.h>
#include <Firebase_ESP_Client.h>
#include "addons/TokenHelper.h"
#include "addons/RTDBHelper.h"
#include <TinyGPSPlus.h>
#include <ESP32Servo.h>
#include "soc/soc.h"
#include "soc/rtc_cntl_reg.h"
#include <EEPROM.h>

const char* wifiSsid = "SmartHardHat_1";
const char* wifiPassword = "SmartHardHat_1";

// Firebase Credentials //                                                                                                      //
#define API_KEY "AIzaSyAy_bQFynVXe_RflYLYgsU0skc8ThOKDYE"                                       // Project API Key              //
#define DB_URL "https://smarthardhat-22267-default-rtdb.asia-southeast1.firebasedatabase.app/"  // Realtime Database Url        //
#define STORAGE_BUCKET_ID "smarthardhat-22267.appspot.com"                                      // Firebase Storage Bucket ID   //           
#define DB_SECRET "Zzb4ijFS1tspaGaC1YRFdIHw44JklfwRnDei7bx1"                                    // Database Secret              //

//                                                                                                                                              //
// Hard Hat Unit setter
#define HARDHAT 2   // 
//#define HARDHAT 2 //
//                                                                                                                                              //
// Define user credentials and paths based on the hard hat selection 
#if HARDHAT == 1                                                        //                                                                      //
  #define USER_EMAIL "hardhat1@smarthardhat.com"                        // 1 Define the user email for hard hat 1                                 //
  #define USER_PASSWORD "hardhat1@smarthardhat.com"                     // 2 Define the user password for hard hat 1                              //
  #define IS_REQUESTING_IMAGE_PATH "/hardHats/hardHat1/isRequestingImg" // 3 Path to check if an image is being requested for hard hat 1          //
  #define IS_SERVO_DEPLOYED_PATH "/hardHats/hardHat1/isServoDeployed"   // 4 Path to check if the servo is deployed for hard hat 1                //
  #define IMAGE_RETURNED_PATH "/hardHats/hardHat1/imageReturned"        // 5 Path indicating if the image has been returned for hard hat 1        //
  #define FILE_PHOTO_PATH "/user1.jpg"                                  // 6 Local file path for the user photo of hard hat 1                     //
  #define BUCKET_PHOTO "/image/user1.jpg"                               // 7 Cloud storage path for the user photo of hard hat 1                  //
  #define LOC_LATITUDE_PATH "/hardHats/hardHat1/locLatitude"            // 8 Path to store the latitude of hard hat 1                             //
  #define LOC_LONGITUDE_PATH "/hardHats/hardHat1/locLongitude"          // 9 Path to store the longitude of hard hat 1                            //
  #define IS_ACTIVE_PATH "/hardHats/hardHat1/isActive"                  // 10 Path to store status of hard hat 1

#elif HARDHAT == 2                                                      //                                                                      //
  #define USER_EMAIL "hardhat2@smarthardhat.com"                        // 1 Define the user email for hard hat 2                                 //
  #define USER_PASSWORD "hardhat2@smarthardhat.com"                     // 2 Define the user password for hard hat 2                              //
  #define IS_REQUESTING_IMAGE_PATH "/hardHats/hardHat2/isRequestingImg" // 3 Path to check if an image is being requested for hard hat 2          //
  #define IS_SERVO_DEPLOYED_PATH "/hardHats/hardHat2/isServoDeployed"   // 4 Path to check if the servo is deployed for hard hat 2                //
  #define IMAGE_RETURNED_PATH "/hardHats/hardHat2/imageReturned"        // 5 Path indicating if the image has been returned for hard hat 2        //
  #define FILE_PHOTO_PATH "/user2.jpg"                                  // 6 Local file path for the user photo of hard hat 2                     //
  #define BUCKET_PHOTO "/image/user2.jpg"                               // 7 Cloud storage path for the user photo of hard hat 2                  //
  #define LOC_LATITUDE_PATH "/hardHats/hardHat2/locLatitude"            // 8 Path to store the latitude of hard hat 2                             //
  #define LOC_LONGITUDE_PATH "/hardHats/hardHat2/locLongitude"          // 9 Path to store the longitude of hard hat 2                            //
  #define IS_ACTIVE_PATH "/hardHats/hardHat2/isActive"                  // 10 Path to store status of hard hat 2

#endif     

#define eepromSize 256
#define latitudeAddress 0
#define longitudeAddress 20

const byte servoLeftPin = 22;
const byte servoRightPin = 23;
bool isServoDeployed = false;
bool isServoDeployedFirebase = false;
bool cameraDeployed = false;
bool cameraRetracted = false;
bool cameraDeployedFirebase = false;
bool locationObtained = false;
bool locationUpdated = false;
bool statusUpdated = false;
bool isActive = false;
bool imageUploaded = false;
int servoPulse = 10;
bool updatedOnce = false;

// Location saved in EEPROM
double eepromLatitude = 14.198757;    
double eepromLongitude = 120.881493;

// Location saved to store current location
double currentLatitude = 0.0;
double currentLongitude = 0.0;

// Location saved to store new location from GPS module
double newLatitude = 0.0;
double newLongitude = 0.0;

bool wifiConnected = false;
int capacitiveThreshold = 25;
const byte touchPin = 27;
const byte buzzerPin = 19;
bool isRequestingImage = false;

bool syncStarted = false;
bool beeping = false;

TinyGPSPlus gps;
FirebaseAuth firebaseAuth;
FirebaseConfig firebaseConfig;
FirebaseData fbdo, fbdoLocLatitude, fbdoLocLongitude, fbdoIsRequestingImageWrite, fbdoIsRequestingImageRead, fbdoIsServoDeployedRead, fbdoIsServoDeployedWrite, fbdoIsActive;

Servo servoRight, servoLeft;

//----------------------------------------------------------------
void setupServo (){
  servoRight.attach (servoRightPin);
  servoLeft.attach (servoLeftPin);

  servoRight.write(0);
  servoLeft.write(180); 
  Serial.println ("Servo at home");
  isServoDeployed = false; 
}

// Function to retract servos to home position
void retractCamera() {
    if (isServoDeployed) {
        for (int angle = 180; angle >= 0; angle--) {
            servoRight.write(angle);
            servoLeft.write(180 - angle);
            delay(servoPulse);
        }
        Serial.println("Servo retracted to home position.");
        isServoDeployed = false;
    } else {
        Serial.println("Servo already at home position.");
    }
}

// Function to deploy servos to full position
void deployCamera() {
    if (!isServoDeployed) {
        for (int angle = 0; angle <= 180; angle++) {
            servoRight.write(angle);
            servoLeft.write(180 - angle);
            delay(servoPulse);
        }
        isServoDeployed = true;
        Serial.println("Servo deployed to full position.");
        
    } else {
        Serial.println("Servo already deployed.");
    }
}

// Function to detect whether the hardhat is worn or not
bool isWorn(int _threshold) {
    int totalReading = 0; 
    int numReadings = 20; 
    int singleReading = 0;
    bool _result = false;

    Serial.print("Readings : ");
    for (int i = 0; i < numReadings; i++) {
        singleReading = touchRead(touchPin); 
        totalReading += singleReading; 
        Serial.printf("%d | ", singleReading);
        delay(50);
    }
    int averageReading = totalReading / numReadings;
    _result = averageReading < _threshold;
    Serial.printf("Average Reading: %d, Result: %s\n", averageReading, _result ? "True (Worn)" : "False (Not Worn)");
    return _result;
}

TaskHandle_t beepingTaskHandle = NULL; // Task handle for managing the beeping task

// Task to toggle the buzzer pin on Core 0
void beepingTask(void *parameter) {
    bool state = false;
    while (true) { state = !state; digitalWrite(buzzerPin, state ? HIGH : LOW); delay(state ? 500 : 1000);}
}

// Function to start beeping (create the task on Core 0)
void startBeeping() {
    if (beepingTaskHandle == NULL) { // Ensure the task isn't already running
        xTaskCreatePinnedToCore(beepingTask, "BeepingTask",1000,NULL,1,&beepingTaskHandle,0);
        Serial.println("Beeping started.");
    }
}

// Function to stop beeping (delete the task on Core 0)
void endBeeping() {
    if (beepingTaskHandle != NULL) { // Check if the task is running
        vTaskDelete(beepingTaskHandle); // Delete the task
        beepingTaskHandle = NULL;       // Reset the handle
        digitalWrite(buzzerPin, LOW);  // Ensure the pin is LOW
        Serial.println("Beeping stopped.");
    }
}

// Function to write global latitude and longitude to EEPROM
void writeToEeprom() {
    EEPROM.begin(eepromSize); // Initialize EEPROM with defined size

    // Write global latitude and longitude to EEPROM
    EEPROM.put(latitudeAddress, currentLatitude);
    EEPROM.put(longitudeAddress, currentLongitude);

    EEPROM.commit(); // Save changes to EEPROM
    Serial.printf("New Latitude: %.6f New Longitude:  %.6f\n", newLatitude,newLongitude);

    currentLatitude = newLatitude;
    currentLongitude = newLongitude;
    EEPROM.end();
}

// Function to write global latitude and longitude to EEPROM
void writeDefaultToEeprom() {
    EEPROM.begin(eepromSize); // Initialize EEPROM with defined size
    delay (5000);

    // Write global latitude and longitude to EEPROM
    EEPROM.put(latitudeAddress, eepromLatitude);
    EEPROM.put(longitudeAddress, eepromLongitude);

    EEPROM.commit(); // Save changes to EEPROM
    Serial.printf("New Latitude: %.6f New Longitude:  %.6f\n", eepromLatitude,eepromLongitude);

    //currentLatitude = newLatitude;
    //currentLongitude = newLongitude;
    EEPROM.end();
}


// Function to read latitude and longitude from EEPROM into global variables
void readFromEeprom() {
    EEPROM.begin(eepromSize); // Initialize EEPROM with defined size

    // Read latitude and longitude from EEPROM into global variables
    EEPROM.get(latitudeAddress, eepromLatitude);
    EEPROM.get(longitudeAddress, eepromLongitude);

    Serial.printf("Latitude from EEPROM: %.6f Longitude from EEPROM:  %.6f\n", eepromLatitude, eepromLongitude); 
    EEPROM.end();
}

// Function to read gps coordinates
void readGps (){
        // Read GPS data and update EEPROM when valid data is received
    if (Serial2.available() > 0) {
        while(Serial2.available()) {
            char c = Serial2.read();
            //Serial.print(c);
            gps.encode(c);
        }
        if (gps.location.isValid()) {
            Serial.println("GPS location is valid");
            newLatitude = gps.location.lat();
            newLongitude = gps.location.lng();
            Serial.printf("New Latitude: %.6f New Longitude:  %.6f\n", newLatitude,newLongitude);
        } else {
            Serial.println ("GPS location is invalid");
            readFromEeprom();
            newLatitude = eepromLatitude;
            newLongitude = eepromLongitude;
        }
    }
}

//# Check wifi network connection status
void checkWifi(){
  //static bool wifiConnected = false; // Static variable to maintain state between calls
  if (WiFi.status() == WL_CONNECTED){
    if (!wifiConnected){
      wifiConnected = true;
      Serial.printf("\n\n----------------\n\nWiFi Connected\n\n----------------\n");
    }
  }else{
    if (wifiConnected){
      wifiConnected = false;
      Serial.printf("\n\n________________________\n WiFi Disconnected \n________________________ \n \n");
    }
  }
}

bool firebaseReady (){
  if (wifiConnected){
    if (!Firebase.ready()){
      Firebase.begin(&firebaseConfig, &firebaseAuth);
      delay(2000);
    } else {
      //Serial.println ("Firebase is ready");
  }
  return Firebase.ready();
  }
  return false;
}

bool firebaseReadBool(FirebaseData &_fbdo, const char *_path, bool &_boolData) {
  if (!firebaseReady()) {
    return false;
  } else {
    if (!Firebase.RTDB.getBool(&_fbdo, _path)){
      Serial.printf("FIREBASE: Read failed due to %s", _fbdo.errorReason().c_str());
      return false;
    } else {
      if (_fbdo.dataType() == "boolean"){
        _boolData = _fbdo.boolData();
        Serial.printf("FIREBASE: Successful read from: %s | Value: %o | ", _path, _boolData);
      } else {                   
        Serial.printf("FIREBASE: Unexpected data type. Please check database path: %s | Expected Data Type: Boolean \t", _path);
        return false;
      }
    }
  }
  return true;
}

// Function to write bool data to Firebase
bool firebaseWriteBool(FirebaseData &_fbdo, const char *_path, bool _data) {
    bool _writeSuccess = false;
    Serial.printf("FIREBASE: Writing %s to %s -> RESULT: ", _data ? "TRUE" : "FALSE", _path);

    // Attempt to write the data to the specified Firebase path
    if (!Firebase.RTDB.setBool(&_fbdo, _path, _data)) {
        Serial.printf("FAILED! \t\t\t Error: %s", _fbdo.errorReason().c_str());
        _writeSuccess = false;
    } else {
        Serial.printf("SUCCESS!\n");
        _writeSuccess = true;
    }
    return _writeSuccess;
}

// Function to write bool data to Firebase
bool firebaseWriteFloat(FirebaseData &_fbdo, const char *_path, double _data) {
  bool _writeSuccess = false;
  // Print debug message with the data and path being written to Firebase
  Serial.printf("FIREBASE: Writing %.6f to %s -> RESULT: ", _data, _path);

  // Attempt to write the data to the specified Firebase path
  if (!Firebase.RTDB.setFloat(&_fbdo, _path, _data)) {
    // Print failure message with error reason if writing fails
    Serial.printf("FAILED! \t\t\t Error: %s", _fbdo.errorReason().c_str());
    _writeSuccess = false;
  } else {
    // Print success message if writing is successful
    Serial.printf("SUCCESS!\n");
    _writeSuccess = true;
  }
  return _writeSuccess;
}

void setupWifi(){
    WiFi.mode(WIFI_STA);
    WiFi.begin(wifiSsid, wifiPassword);
    Serial.printf ("Connecting to: %s ", wifiSsid);
    while (WiFi.status() != WL_CONNECTED){
        Serial.print("#");
        delay(50);
    }
}

// Function to start Firebase
void setupFirebase(){ 
  firebaseConfig.api_key = API_KEY;                                                                                                 // Set API Key
  firebaseConfig.database_url = DB_URL;                                                                                             // Set database URL
  firebaseConfig.token_status_callback = tokenStatusCallback;                                                                       // Set token status callback for debugging
  firebaseAuth.user.email = USER_EMAIL;                                                                                             // Set user email
  firebaseAuth.user.password = USER_PASSWORD;                                                                                       // Set user password
  Serial.printf("\nAPI key: %s \nDatabase URL: %s \nUser: %s \nPassword: %s\n", API_KEY, DB_URL, USER_EMAIL, USER_PASSWORD);        
  Serial.println("Starting Firebase...");
  Firebase.begin(&firebaseConfig, &firebaseAuth);                                                                                   // Attempt firebase connection using user-credentials
  Firebase.reconnectWiFi(true);                                                                                                     // Enable reconnect network after disconnection  
}

bool updateCameraPositionToFirebase (){
  //write true to isServoDeployed and isRequestingImage node 
  return  firebaseWriteBool(fbdoIsRequestingImageWrite, IS_REQUESTING_IMAGE_PATH, true) && 
          firebaseWriteBool(fbdoIsServoDeployedWrite, IS_SERVO_DEPLOYED_PATH, true);
}

bool imageUploadDone(){
  //wait for isServoDeployed and isRequestingImage to turn false
  return (firebaseReadBool(fbdoIsRequestingImageRead, IS_REQUESTING_IMAGE_PATH, isRequestingImage) && 
          firebaseReadBool(fbdoIsServoDeployedRead, IS_SERVO_DEPLOYED_PATH, isServoDeployedFirebase) && 
          !isRequestingImage && !isServoDeployedFirebase);
}

// write the GPS location to Firebase Realtime Database
bool updateLocationToFirebase(){
  return firebaseWriteFloat(fbdoLocLatitude, LOC_LATITUDE_PATH, newLatitude) && firebaseWriteFloat(fbdoLocLongitude, LOC_LONGITUDE_PATH, newLongitude);
}

bool updateStatus (bool _status){
  return firebaseWriteBool(fbdoIsActive, IS_ACTIVE_PATH, _status);
}



void setupGps (){
  readFromEeprom();
}


void setup() {
    Serial.begin(115200);
    Serial2.begin(9600);
    setupGps();
    setupWifi();
    setupFirebase();
    setupServo();
    pinMode(buzzerPin, OUTPUT);

    updateStatus(isActive);
}

void loop() {
    checkWifi();
    if (!syncStarted){
        isActive = isWorn(capacitiveThreshold);
        if (isActive){
            if (!updatedOnce){
                Serial.println ("\n\n________________________________________\n\nHard hat is worn. Initiate sync now.\n________________________________________\n\n");
                syncStarted = true;
                statusUpdated = false;
            }
        } else {
          if (!statusUpdated){
            statusUpdated = updateStatus(isActive);
            updatedOnce = false;
          }
        }
        if (beeping){
            endBeeping();
            beeping = false;
        }
        delay(2000);
    } else {
        if (!beeping){
            startBeeping();
            delay(4000);
            beeping = true; 
        } else {
            if (!cameraDeployed) {
                Serial.println("\n\n_____________________\n\nDeploying camera...\n_____________________\n\n");
                deployCamera();
                delay(7000);
                cameraDeployed = true;
            }

            if (!cameraDeployedFirebase) {
                Serial.println("Updating camera position to Firebase...");
                cameraDeployedFirebase = updateCameraPositionToFirebase();
            }

            if (!statusUpdated){
                statusUpdated = updateStatus(isActive);
            }

            if (!locationObtained) {
                Serial.println("\n\n____________________\n\nReading GPS data...\n____________________\n\n");
                readGps();
                locationObtained = true; 
            }

            if (!locationUpdated) {
                Serial.println("\n\n__________________________________\n\nUpdating location to Firebase...\n__________________________________\n\n");
                locationUpdated = updateLocationToFirebase(); 
            }

            if (!imageUploaded) {
                Serial.println("\n\n__________________\n\nUploading image...\n__________________\n\n");
                imageUploaded = imageUploadDone();
                delay(1000);  
            }

            if (!cameraRetracted){
                if (cameraDeployed && imageUploaded){
                    Serial.println("\n\n__________________\n\nRetracting camera...\n__________________\n\n");
                    retractCamera();
                    delay(5000);
                    cameraRetracted = true;
                }
            }

            if (cameraDeployed && cameraDeployedFirebase && locationObtained && locationUpdated && cameraRetracted && statusUpdated && imageUploaded) {
                Serial.println("\n\n_____________________________________________________\n\nAll tasks completed successfully. Resetting flags...\n_____________________________________________________\n\n");
                statusUpdated = false;
                cameraDeployed = false;
                cameraDeployedFirebase = false;
                locationObtained = false;
                locationUpdated = false;
                imageUploaded = false;
                cameraRetracted = false;
                syncStarted = false;
                updatedOnce = true;
                Serial.println("Flags reset complete.");
            }
        }
    }
}
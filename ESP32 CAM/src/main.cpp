#include <Arduino.h>
#include "WiFi.h"
#include "esp_camera.h"
#include "soc/soc.h"           // Disable brownout problems
#include "soc/rtc_cntl_reg.h"  // Disable brownout problems
#include "driver/rtc_io.h"
#include <LittleFS.h>
#include <FS.h>

#include <Firebase_ESP_Client.h>
#include "addons/RTDBHelper.h"
#include "addons/TokenHelper.h"

const char* wifiSsid = "SmartHardHat_1";
const char* wifiPassword = "SmartHardHat_1";

bool wifiConnected = false;
const byte discardFirstImages = 5;
const byte maxCaptureAttempt = 5; 
bool takeNewPhoto = false;
bool imageCaptured = false;
bool uploading = false;
bool imageUploaded = false;
bool imageWritten  = false;
bool imageRequested = false;
bool imageTaskStarted = false;
bool cameraDeployed = false;
bool isServoDeployed = false;
bool isRequestingImage = false;



String imageUrl = "";
String inactiveImageUrl = "https://firebasestorage.googleapis.com/v0/b/smarthardhat-22267.appspot.com/o/image%2Finactive.jpg?alt=media&token=092edc42-6923-4ab8-8b62-d3a5584b8043";

//                                                                                                                                              //
// Firebase Credentials 
#define API_KEY "AIzaSyAy_bQFynVXe_RflYLYgsU0skc8ThOKDYE"                                       // Project API Key              //
#define DB_URL "https://smarthardhat-22267-default-rtdb.asia-southeast1.firebasedatabase.app/"  // Realtime Database Url        //
#define STORAGE_BUCKET_ID "smarthardhat-22267.appspot.com"                                      // Firebase Storage Bucket ID   //           
#define DB_SECRET "Zzb4ijFS1tspaGaC1YRFdIHw44JklfwRnDei7bx1"                                    // Database Secret              //

//                                                                                                                                              //
// Hard Hat Unit setter
//#define HARDHAT 1   // 
#define HARDHAT 2 //
//                                                                                                                                              //
// Define user credentials and paths based on the hard hat selection 
#if HARDHAT == 1                                                        //                                                                      //
  #define USER_EMAIL "hardhat1@smarthardhat.com"                        // Define the user email for hard hat 1                                 //
  #define USER_PASSWORD "hardhat1@smarthardhat.com"                     // Define the user password for hard hat 1                              //
  #define IS_REQUESTING_IMAGE_PATH "/hardHats/hardHat1/isRequestingImg" // Path to check if an image is being requested for hard hat 1          //
  #define IS_SERVO_DEPLOYED_PATH "/hardHats/hardHat1/isServoDeployed"   // Path to check if the servo is deployed for hard hat 1                //
  #define IMAGE_RETURNED_PATH "/hardHats/hardHat1/imageReturned"        // Path indicating if the image has been returned for hard hat 1        //
  #define IMAGE_UPLOADED_PATH "/hardHats/hardHat1/isImageUploaded"      // Path indicating if an image has been uploaded for hard hat 1         //
  #define FILE_PHOTO_PATH "/user1.jpg"                                  // Local file path for the user photo of hard hat 1                     //
  #define BUCKET_PHOTO "/image/user1.jpg"                               // Cloud storage path for the user photo of hard hat 1                  //
  #define IS_IMAGE_UPLOADED_PATH "/hardHats/hardHat1/isImageUploaded"   // Path indicating if an image upload status is updated for hard hat 1  //
  #define IS_STATUS_UPDATED_PATH "/hardHats/hardHat1/isStatusUpdated"   // Path indicating if the status of the hard hat is updated             //
  #define IS_HARDHAT_ACTIVE_PATH "/hardHats/hardHat1/isActive"          // Path indicating if hard hat 1 is active                              //
  #define IS_ESP32CAM_DONE_PATH "/hardHats/hardHat1/isEsp32CamDone"     // Path indicating if the ESP32-CAM process is done for hard hat        //
  #define LOC_LATITUDE_PATH "/hardHats/hardHat1/locLatitude"            // Path to store the latitude of hard hat 1                             //
  #define LOC_LONGITUDE_PATH "/hardHats/hardHat1/locLongitude"          // Path to store the longitude of hard hat 1                            //

#elif HARDHAT == 2                                                      //                                                                      //
  #define USER_EMAIL "hardhat2@smarthardhat.com"                        // Define the user email for hard hat 2                                 //
  #define USER_PASSWORD "hardhat2@smarthardhat.com"                     // Define the user password for hard hat 2                              //
  #define IS_REQUESTING_IMAGE_PATH "/hardHats/hardHat2/isRequestingImg" // Path to check if an image is being requested for hard hat 2          //
  #define IS_SERVO_DEPLOYED_PATH "/hardHats/hardHat2/isServoDeployed"   // Path to check if the servo is deployed for hard hat 2                //
  #define IMAGE_RETURNED_PATH "/hardHats/hardHat2/imageReturned"        // Path indicating if the image has been returned for hard hat 2        //
  #define IMAGE_UPLOADED_PATH "/hardHats/hardHat2/isImageUploaded"      // Path indicating if an image has been uploaded for hard hat 2         //
  #define FILE_PHOTO_PATH "/user2.jpg"                                  // Local file path for the user photo of hard hat 2                     //
  #define BUCKET_PHOTO "/image/user2.jpg"                               // Cloud storage path for the user photo of hard hat 2                  //
  #define IS_IMAGE_UPLOADED_PATH "/hardHats/hardHat2/isImageUploaded"   // Path indicating if an image upload status is updated for hard hat 2  //
  #define IS_STATUS_UPDATED_PATH "/hardHats/hardHat2/isStatusUpdated"   // Path indicating if the status of the hard hat is updated             //
  #define IS_HARDHAT_ACTIVE_PATH "/hardHats/hardHat2/isActive"          // Path indicating if hard hat 2 is active                              //
  #define IS_ESP32CAM_DONE_PATH "/hardHats/hardHat2/isEsp32CamDone"     // Path indicating if the ESP32-CAM process is done for hard hat 2      //
  #define LOC_LATITUDE_PATH "/hardHats/hardHat2/locLatitude"            // Path to store the latitude of hard hat 2                             //
  #define LOC_LONGITUDE_PATH "/hardHats/hardHat2/locLongitude"          // Path to store the longitude of hard hat 2                            //
#endif                                                                  //                                                                      //


// Camera pins  ----------------------
#define PWDN_GPIO_NUM     32        //
#define RESET_GPIO_NUM    -1        //
#define XCLK_GPIO_NUM      0        //
#define SIOD_GPIO_NUM     26        //
#define SIOC_GPIO_NUM     27        //
#define Y9_GPIO_NUM       35        //
#define Y8_GPIO_NUM       34        //
#define Y7_GPIO_NUM       39        //
#define Y6_GPIO_NUM       36        //
#define Y5_GPIO_NUM       21        //
#define Y4_GPIO_NUM       19        //
#define Y3_GPIO_NUM       18        //
#define Y2_GPIO_NUM        5        //
#define VSYNC_GPIO_NUM    25        //
#define HREF_GPIO_NUM     23        //
#define PCLK_GPIO_NUM     22        //

FirebaseAuth firebaseAuth;
FirebaseConfig firebaseConfig;
FirebaseData fbdoImage, fbdoImageUrl, fbdoIsServoDeployed, fbdoIsRequestingImage, fbdoResetImageRequest;

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

bool firebaseReady (){
  if (!Firebase.ready()){
    Firebase.begin(&firebaseConfig, &firebaseAuth);
    delay(2000);
  } else {
    //Serial.println ("Firebase is ready");
  }
  return Firebase.ready();
}

// The Firebase Storage upload callback function
void fcsUploadCallback(FCS_UploadStatusInfo info){
    if (info.status == firebase_fcs_upload_status_init){
      Serial.printf("Uploading file %s (%d) to %s\n", info.localFileName.c_str(), info.fileSize, info.remoteFileName.c_str());
      uploading = true;
    }
    else if (info.status == firebase_fcs_upload_status_upload)
    {
      Serial.printf("Uploaded %d%s, Elapsed time %d ms\n", (int)info.progress, "%", info.elapsedTime);
    }
    else if (info.status == firebase_fcs_upload_status_complete)
    {
      Serial.println("Upload completed\n");
      FileMetaInfo meta = fbdoImage.metaData();
      Serial.printf("Name: %s\n", meta.name.c_str());
      Serial.printf("Bucket: %s\n", meta.bucket.c_str());
      Serial.printf("contentType: %s\n", meta.contentType.c_str());
      Serial.printf("Size: %d\n", meta.size);
      Serial.printf("Generation: %lu\n", meta.generation);
      Serial.printf("Metageneration: %lu\n", meta.metageneration);
      Serial.printf("ETag: %s\n", meta.etag.c_str());
      Serial.printf("CRC32: %s\n", meta.crc32.c_str());
      Serial.printf("Tokens: %s\n", meta.downloadTokens.c_str());
      Serial.printf("Download URL: %s\n\n", fbdoImage.downloadURL().c_str());
      imageUrl = fbdoImage.downloadURL();
      uploading = false;
    }
    else if (info.status == firebase_fcs_upload_status_error){
        Serial.printf("Upload failed, %s\n", info.errorMsg.c_str());
    }
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

// Initiate the filesystem to save the images
void setupLittleFS(){
  if (!LittleFS.begin(true)) {
    Serial.println("An Error has occurred while mounting LittleFS");
    ESP.restart();
  } else {
    delay(500);
    Serial.println("LittleFS mounted successfully");
  }
}

//Configure the camera module
void configureCamera (camera_config_t &_config){
    _config.xclk_freq_hz = 20000000;
    _config.pixel_format = PIXFORMAT_JPEG;
    _config.grab_mode = CAMERA_GRAB_LATEST;

  if (psramFound()) {
    _config.frame_size = FRAMESIZE_UXGA;
    _config.jpeg_quality = 10;
    _config.fb_count = 1;
  } else {
    _config.frame_size = FRAMESIZE_SVGA;
    _config.jpeg_quality = 12;
    _config.fb_count = 1;
  }
  // Camera init
  esp_err_t err = esp_camera_init(&_config);
  if (err != ESP_OK) {
    Serial.printf("Camera init failed with error 0x%x", err);
    ESP.restart();
  } else {
    Serial.println ("Camera is ready");
  }

  sensor_t * s = esp_camera_sensor_get();
  s->set_hmirror(s, 0);        // 0 = disable , 1 = enable
  s->set_vflip(s, 0);          // 0 = disable , 1 = enable

}

// Bind the camera sensor pins to the ESP32 pins
void setCameraPins (camera_config_t &_config){
    _config.ledc_channel = LEDC_CHANNEL_0;
    _config.ledc_timer = LEDC_TIMER_0;
    _config.pin_d0 = Y2_GPIO_NUM;
    _config.pin_d1 = Y3_GPIO_NUM;
    _config.pin_d2 = Y4_GPIO_NUM;
    _config.pin_d3 = Y5_GPIO_NUM;
    _config.pin_d4 = Y6_GPIO_NUM;
    _config.pin_d5 = Y7_GPIO_NUM;
    _config.pin_d6 = Y8_GPIO_NUM;
    _config.pin_d7 = Y9_GPIO_NUM;
    _config.pin_xclk = XCLK_GPIO_NUM;
    _config.pin_pclk = PCLK_GPIO_NUM;
    _config.pin_vsync = VSYNC_GPIO_NUM;
    _config.pin_href = HREF_GPIO_NUM;
    _config.pin_sscb_sda = SIOD_GPIO_NUM;
    _config.pin_sscb_scl = SIOC_GPIO_NUM;
    _config.pin_pwdn = PWDN_GPIO_NUM;
    _config.pin_reset = RESET_GPIO_NUM;
}

void setupCamera(){
    camera_config_t configCamera;
    setCameraPins(configCamera);
    configureCamera(configCamera);
}

// Capture Photo and Save it to LittleFS
void capturePhotoSaveLittleFS() {
    camera_fb_t* image = NULL;

    // Dispose first pictures because of bad quality
    for (int i = 0; i < discardFirstImages; i++) {
        image = esp_camera_fb_get();
        esp_camera_fb_return(image);
        image = NULL;
        delay(500); // Short delay to allow for camera processing
    }
        
    // Take a new photo
    image = NULL;
    delay(1000);
    image = esp_camera_fb_get();

    delay (1000);

    if (!image) {
        Serial.println("Camera capture failed");
        delay(1000);
        ESP.restart();
        return;
    }
    
    // Photo file name
    Serial.printf("Picture file name: %s\n", FILE_PHOTO_PATH);
    File imageFile = LittleFS.open(FILE_PHOTO_PATH, FILE_WRITE);

    // Insert the data in the photo file
    if (!imageFile) {
        Serial.println("Failed to open file in writing mode");
    } else {
        imageFile.write(image->buf, image->len); // payload (image), payload length
        Serial.printf("The picture has been saved in %s - Size: %d bytes\n", FILE_PHOTO_PATH, image->len);

        imageFile.close();
    }

    esp_camera_fb_return(image);
    if (image) imageCaptured = true; else imageCaptured = false;

}

// Capture image up to maxCapture attempt, set imageCaptured to true if successful
void captureImage (){
  if (!imageCaptured){
    Serial.println ("Taking image");
    takeNewPhoto = true;
    for (byte i = 1; i < maxCaptureAttempt; i++) {
        if (takeNewPhoto) {
        Serial.printf ("Taking photo attemp: %d \n", i);
        capturePhotoSaveLittleFS();
        if (imageCaptured){
            takeNewPhoto = false;
            Serial.printf("Image capture succeeded in %d attempt \n", i); 
            break;
        }
        if (i == (maxCaptureAttempt) && !imageCaptured){
            Serial.printf ("Camera failed to take photo in %d attempts. Restarting ESP now", maxCaptureAttempt);
            ESP.restart();
        }
        }
        Serial.println (imageCaptured ? "Image captured": "Image capture failed");
    }
  }
}

void uploadImage (){
  if (imageCaptured){
    if (Firebase.ready() && !imageUploaded){
      Serial.println ("Uploading picture... ");
      if (firebaseReady()){
        if (Firebase.Storage.upload(&fbdoImage, STORAGE_BUCKET_ID, FILE_PHOTO_PATH, mem_storage_type_flash, BUCKET_PHOTO, "image/jpeg", fcsUploadCallback)){
          imageUploaded = true;
        } else {
          Serial.println(fbdoImage.errorReason());
        }
      }
    }
  } else { 
    captureImage ();
    uploadImage();
  }
}

bool firebaseWriteString(FirebaseData &_fbdo, const char *_path, String _data) {
  bool _writeSuccess = false;
  // Print debug message with the data and path being written to Firebase
  Serial.printf("\nFIREBASE: Writing %s to %s -> RESULT: \n", _data.c_str(), _path);

  // Attempt to write the string data to the specified Firebase path
  if (!Firebase.RTDB.setString(&_fbdo, _path, _data)) {
    // Print failure message with error reason if writing fails
    Serial.printf("FAILED! \t\t\t Error: %s \n", _fbdo.errorReason().c_str());
    _writeSuccess = false;
  } else {
    // Print success message if writing is successful
    Serial.printf("SUCCESS!\n");
    _writeSuccess = true;
  }
  return _writeSuccess;
}

bool firebaseReadBool(FirebaseData &_fbdo, const char *_path, bool &_boolData) {
  //Store the print content in a string named debugMessage
  if (!firebaseReady()) {
    return false;
  } else {
    if (!Firebase.RTDB.getBool(&_fbdo, _path)){
      Serial.printf("FIREBASE: Read failed due to %s", _fbdo.errorReason().c_str());
      return false;
    } else {
      if (_fbdo.dataType() == "boolean"){
        _boolData = _fbdo.boolData();
        Serial.printf("FIREBASE: Successful read from: %s | Value: %o | \n", _path, _boolData);
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
  // Print debug message with the data and path being written to Firebase
  Serial.printf("FIREBASE: Writing %s to %s -> RESULT: ", _data ? "true" : "false", _path);

  // Attempt to write the data to the specified Firebase path
  if (!Firebase.RTDB.setBool(&_fbdo, _path, _data)) {
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

void writeImageUrl (){
  if (imageCaptured && imageUploaded){
    Serial.println ("Writing image URL");
    if(firebaseReady()){
        if (firebaseWriteString (fbdoImageUrl, IMAGE_RETURNED_PATH, imageUrl)){
        imageWritten = true;
      } else {
        imageWritten = false;
        ESP.restart ();
      }
    }
  } else {
    captureImage ();
    uploadImage ();
    writeImageUrl ();
  }
}

bool requestingImage(){
    //return true if the is isRequestingImage node is true
    return firebaseReadBool (fbdoIsRequestingImage, IS_REQUESTING_IMAGE_PATH, isRequestingImage) && isRequestingImage;
}



bool isCameraDeployed(){
    //return true if the isServoDeployed node is true
    return firebaseReadBool (fbdoIsServoDeployed, IS_SERVO_DEPLOYED_PATH, isServoDeployed) && isServoDeployed;

}

bool fulfillRequest(){
    //write false to isRequestingImagev node
    return  firebaseWriteBool(fbdoResetImageRequest, IS_REQUESTING_IMAGE_PATH, false) && 
            firebaseWriteBool(fbdoResetImageRequest, IS_SERVO_DEPLOYED_PATH, false);
    
}

void setup (){
    Serial.begin (115200);
    setupWifi();
    setupFirebase();
    setupCamera();
    setupLittleFS();
}

void loop (){
    checkWifi();
    
    if (!imageRequested){
            Serial.print ("Waiting for image request | ");
            delay(2000);
        if (requestingImage()){
            Serial.println ("\n\n________________________\n\nImage request received.\n________________________\n\n");
            imageRequested = true;
        }
    } else {
        if(cameraDeployed){
            if (!imageCaptured){
                Serial.println ("\n\n______________________________________\n\nCamera is deployed. Taking image now.\n______________________________________\n\n");
                captureImage();
            }

            if (!imageUploaded){
                Serial.println ("\n______________________________________\n\nUploading image to Firebase storage\n______________________________________\n\n");
                uploadImage();
            }
                                                              
            if (!imageWritten){
                Serial.println ("\n______________________________________\n\nWriting image url to Realtime Database\n______________________________________\n\n");
                writeImageUrl();
            }

            if (imageCaptured && imageUploaded && imageWritten){
                Serial.println ("\n___________________________________________________________________________________\n\n An image is successfully captured and uploaded to database. Ressetting task flags.\n__________________________________________________________________________________\n\n");
                
                if(fulfillRequest()){
                    // Reset image capture, upload, and write flags
                    imageRequested = false;
                    imageCaptured = false;
                    imageUploaded = false;
                    imageWritten = false;
                    cameraDeployed = false;
                    Serial.println ("\n______________________\n\nReset flags successful\n______________________\n\n");
                }
            }
        } else {
            Serial.print ("Waiting for camera deployment | ");
            delay(2000);
            cameraDeployed = isCameraDeployed ();
        }
    }
}
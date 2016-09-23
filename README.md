# Hop-On server
<img src="http://i.imgur.com/HOofG19.png" align="left" width="200" height="200" hspace="10" vspace="6"></a>
**Hop-On** is a bicycle sharing system. Hop-On project proposes an **IoT solution** which enable users to share bicycle in convenient way. The system contains 3 components:
- Hop-On Module (mounted on bicycles)
- Hop-On Station (installed at parking areas)
- Hop-On Mobile App
- Hop-On Server
**This repository** is **Hop-On server** of the system.

## Server Description
* **Hop-On Server** uses [Yii2 framework](http://www.yiiframework.com/). It provides API services for Hop-On Mobile App.
* **API URL**: ```188.166.247.154/hopon-web/api/web/index.php/v1/```

## Server Documentation
* [Wiki](https://github.com/qinjie/HopOn-Web/wiki)
* [Yii2 documentation](http://www.yiiframework.com/doc-2.0/guide-index.html)

## Set up server in Ubuntu
Instructions for setting up server
1. Install ```LAMP```. [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-14-04)
2. Install ```Git```. [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-14-04)
3. Run ```git clone https://github.com/qinjie/HopOn-Web.git```
4. Install ```Composer```. [Guide](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)
5. Go to repository directory. Run ```php init```
6. Run this sql file ```docs/hop_on.sql``` in repository directory.
7. Edit database configuration in ```common/config/main-local.php```
8. Add local parameters in file ```common/config/params-local.php``` as following:
```
<?php
return [
    'API_BASEURL' => 'http://localhost/hopon-web/api/web/index.php/',
    'WEB_BASEURL' => 'http://localhost/hopon-web/frontend/web/index.php/',
    'BACKEND_BASEURL' => 'http://localhost/hopon-web/backend/web/',
];
```
9. Change permissions of these folders to be writable. Run ```chmod -R 777 api/runtime api/web/assets backend/runtime backend/web/assets frontend/runtime frontend/web/assets console/runtime``` in repository directory.
10. Run ```composer install```.
 

##CODES
###Status of bicycles:
```
STATUS_FREE = 0;
STATUS_MAINTENANCE = 1;
STATUS_LOCKED = 2;
STATUS_UNLOCKED = 3;
STATUS_BOOKED = 4;
```
###Issues in feedback:
```
ISSUE_OTHERS = 0;
ISSUE_BREAK_NOT_EFFECTIVE = 1;
ISSUE_TYRE_FLAT = 2;
ISSUE_CHAIN_GEARS_FAULTY = 3;
ISSUE_PARTS_LOOSE = 4;
```
###Error code in 400
```
CODE_INCORRECT_USERNAME = 0;
CODE_INCORRECT_PASSWORD = 1;
CODE_UNVERIFIED_EMAIL = 3;
CODE_INVALID_ACCOUNT = 6;
CODE_INVALID_PASSWORD = 8;
```
###Common HTTP status
```
200 - Success
400 - Bad Request HTTP
401 - Unauthorized
500 - Server error
```

##API
###POST ```user/login```
```
=> Login to app
```
####Header: None
####Request:
```
{
    username: '1234',
    password: '123456'
}
```
####Response:
- Success: 200
```
{
  "user_id": 1,
  "auth_key": "ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA",
  "token": "Br9UTkeDWrrUs-_FkojG1duzSpEsSA4T",
  "fullname": "ADRIAN YOO"
}
```
- Error: 400
```
{
  code: (
    0: CODE_INCORRECT_USERNAME,
    1: CODE_INCORRECT_PASSWORD,
    3: CODE_UNVERIFIED_EMAIL,
    6: CODE_INVALID_ACCOUNT
  )
}
```

***

###POST ```user/change-password```
```
=> Change password
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
    oldPassword: '123456',
    newPassword: '111111'
}
```
####Response:
- Success: 200
```
change password successfully
```
- Error: 400
```
{
  code: (
    1: CODE_INCORRECT_PASSWORD,
    8: CODE_INVALID_PASSWORD
  )
}
```

***

###POST ```user/reset-password```
```
=> Reset password
```
####Header: None
####Request:
```
{
    email_mobile: '1234'
}
```
####Response:
- Success: 200
```
reset password successfully
```

***

###POST ```user/signup```
```
=> Sign up new user. An activation email will be sent.
```
####Header: None
####Request:
```
{
    fullname: 'Tan Ah Boy',
    email: '123@mail.com',
    mobile: '12345678',
    password: '123456',
    role: (10: role user)
}
```
####Response:
- Success: 200
```
register successfully
```
- Error: 400
```
{
  code: (
    8: CODE_INVALID_PASSWORD,
    10: CODE_INVALID_EMAIL,
    11: CODE_INVALID_PHONE,
    12: CODE_INVALID_FULLNAME
  )
}
```

***

###POST ```user/resend-email```
```
=> Resend activation email
```
####Header: None
####Request:
```
{
    email: '123@mail.com'
}
```
####Response:
```
resend email
```

***

###POST ```user/activate```
```
=> Activate an account
```
####Header: None
####Request:
```
{
  email,
  token: '123456'
}
```
####Response:
```
{
  "token": "TakSpFYW4eS-w5_58NA9Uc0U-X5ko8ON",
  "fullname": "Tan Ah Boy"
}
```

***

###POST ```user/change-email```
```
=> Change new email.
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
    newEmail: 'canhnhtse03860@fpt.edu.vn',
    password: '123456'
}
```
####Response:
```
{
  "id": 1,
  "fullname": "ADRIAN YOO",
  "email": "canhnht1709@gmail.com",
  "mobile": "12345678",
  "status": 10,
  "role": 10,
  "name": "user"
}
```

***

###POST ```user/change-mobile```
```
=> Change new mobile phone.
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
    newMobile: '12345678',
    password: '123456'
}
```
####Response:
```
{
  "id": 1,
  "fullname": "ADRIAN YOO",
  "email": "canhnht1709@gmail.com",
  "mobile": "12345678",
  "status": 10,
  "role": 10,
  "name": "user"
}
```

***

###POST ```user/activate-email```
```
=> Activate a new email
```
####Header: None
####Request:
```
{
    token: '123456'
}
```
####Response:
```
'activate email successfully'
```

***

###GET ```user/logout```
```
=> Log out app
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request: None
####Response:
```
logout successfully
```

***

###GET ```user/profile```
```
=> Get profile of current user
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request: None
####Response:
```
{
  "fullname": "Tan Ah Boy",
  "email": "canhnht1709@gmail.com",
  "mobile": "1"
}
```

***

###POST ```station/search```
```
=> Get list of stations which are nearest to a position (lat, lng).
Limit to 10 nearest stations. Sorted ascending by distance.
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
  latitude: 1.339835,
  longitude: 103.776095
}
```
####Response:
```
[
  {
    "id": "5",
    "name": "NP Main Gate",
    "address": "535 Clementi Road",
    "latitude": "1.334284",
    "longitude": "103.776649",
    "postal": "234235",
    "bicycle_count": "10",
    "available_bicycle": "0",
    "distanceText": "456 km",
    "distanceValue": 455660
  },
  {
    "id": "1",
    "name": "Ang Mo Kio",
    "address": "Ang Mo Kio MRT",
    "latitude": "1.370015",
    "longitude": "103.849446",
    "postal": "",
    "bicycle_count": "30",
    "available_bicycle": "8",
    "distanceText": "494 km",
    "distanceValue": 494497
  }
]
```

***

###GET ```station/detail?stationId=1```
```
=> Get list of bicycle types in a station. Only bicycle types having availableBicycle > 0 are returned.
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request: None
####Response:
```
[
  {
    "bicycle_type_id": "6",
    "brand": "Bianchi",
    "model": "Hybrid",
    "desc": "Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.",
    "availableBicycle": "1",
    "totalBicycle": "2",
    "listImageUrl": [
      "http://localhost/hopon-web/backend/web/uploads/images/bike-3.jpg",
      "http://localhost/hopon-web/backend/web/uploads/images/bike-1.jpg"
    ]
  },
  {
    "bicycle_type_id": "26",
    "brand": "Trek Bicycles",
    "model": "Kids Bicycles",
    "desc": "Bicycles are built to handle all the use and abuse you can throw at them, with minimal service.",
    "availableBicycle": "1",
    "totalBicycle": "1",
    "listImageUrl": [
      "http://localhost/hopon-web/backend/web/uploads/images/bike-3.jpg",
      "http://localhost/hopon-web/backend/web/uploads/images/bike-1.jpg"
    ]
  }
]
```

***

###POST ```bicycle/book```
```
=> Book a bicycle
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
  stationId: 4,
  bicycleTypeId: 26
}
```
####Response:
```
{
  "id": 1,
  "serial": "SG11111",
  "bicycle_type_id": 1,
  "desc": "Hybrid",
  "status": 4,
  "station_id": 1,
  "beacon_id": 5,
  "created_at": 1461214049,
  "updated_at": 1472780124,
  "enc": "782f66ea8fc539ba0a8cec1383060559"
}
```

***

###GET ```rental/current-booking```
```
=> Get current booking of current user
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request: None
####Response:
```
{
  "rental_id": "6",
  "booking_id": "SG57DA45CAB601E",
  "bicycle_id": "1",
  "bicycle_serial": "SG11111",
  "desc": "Hybrid",
  "brand": "Apollo Bikes",
  "model": "Hybrid",
  "pickup_station_name": "Ang Mo Kio",
  "pickup_station_address": "Ang Mo Kio MRT",
  "pickup_station_postal": "",
  "pickup_station_lat": "1.370015",
  "pickup_station_lng": "103.849446",
  "book_at": "02:55 PM, 15 Sep 2016",
  "pickup_at": null,
  "beacon_station_uuid": "23A01AF0-232A-4518-9C0E-323FB773F5EF",
  "beacon_station_major": "61667",
  "beacon_station_minor": "30640",
  "beacon_bicycle_uuid": "23A01AF0-232A-4518-9C0E-323FB773F5EF",
  "beacon_bicycle_major": "31483",
  "beacon_bicycle_minor": "13575",
  "bean_bicycle_name": "SG11111",
  "bean_bicycle_address": "88:C2:55:AC:35:5F",
  "status": "4",
  "listImageUrl": [
    "http://localhost/hopon-web/backend/web/uploads/images/bike-1.jpg",
    "http://localhost/hopon-web/backend/web/uploads/images/bike-2.jpg",
    "http://localhost/hopon-web/backend/web/uploads/images/bike-2.jpg"
  ],
  "user_id": 1,
  "auth_key": "ZdHvM_ryoZgGJiNsQhh2y95vllLXVseA",
  "enc": "441a96b31571f9a3d4a20daa1a0ca1e2"
}
```

***

###POST ```bicycle/return```
```
=> Return a bicycle
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
  bicycleId: 17,
  latitude: 1.5,
  longitude: 103,
  listBeacons: [
    {
      uuid: 'B9407F30-F5F8-466E-AFF9-25556B57FE6D',
      major: '58949',
      minor: '29933',
      rssi: -10
    }
  ]
}
```
####Response:
```
{
  "id": 13,
  "user_id": 1,
  "bicycle_id": 2,
  "serial": "SG11112",
  "book_at": "2016-08-31 14:28:14",
  "pickup_at": "2016-08-31 14:29:02",
  "return_at": "2016-08-31 14:42:02",
  "return_station_id": "1",
  "duration": 14
}
```

***

###POST ```bicycle/lock```
```
=> Lock a bicycle
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
  bicycleId: 17,
  latitude: 1.1,
  longitude: 103
}
```
####Response:
```
{
  "id": 13,
  "user_id": 1,
  "bicycle_id": 2,
  "serial": "SG11112",
  "book_at": "2016-08-31 14:28:14",
  "pickup_at": "2016-08-31 14:29:02",
  "return_at": "2016-08-31 14:42:02",
  "return_station_id": "1",
  "duration": 14
}
```

***

###POST ```bicycle/unlock```
```
=> Unlock a bicycle
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
  bicycleId: 17,
  latitude: 1.1,
  longitude: 103
}
```
####Response:
```
{
  "id": 13,
  "user_id": 1,
  "bicycle_id": 2,
  "serial": "SG11112",
  "book_at": "2016-08-31 14:28:14",
  "pickup_at": "2016-08-31 14:29:02",
  "return_at": "2016-08-31 14:42:02",
  "return_station_id": "1",
  "duration": 14
}
```

***

###POST ```rental/history```
```
=> History of booking of current user. Sorted from newest to oldest by return at
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request: None
####Response:
```
[
  {
    "rental_id": "1",
    "booking_id": "A1234B1111C",
    "bicycle_id": "1",
    "bicycle_serial": "SG11111",
    "desc": "Hybrid",
    "brand": "Apollo Bikes",
    "model": "Hybrid",
    "pickup_station_name": "Ang Mo Kio",
    "pickup_station_address": "Ang Mo Kio MRT",
    "pickup_station_postal": "",
    "pickup_station_lat": "1.370015",
    "pickup_station_lng": "103.849446",
    "book_at": "03:00 PM, 01 Aug 2016",
    "pickup_at": "03:05 PM, 01 Aug 2016",
    "return_at": "04:30 PM, 01 Aug 2016",
    "duration": "90",
    "return_station_name": "NP Main Gate",
    "return_station_address": "535 Clementi Road",
    "return_station_postal": "234235",
    "return_station_lat": "1.334284",
    "return_station_lng": "103.776649"
  }
]
```

***

###GET ```station/get-all```
```
=> Get all stations
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request: None
####Response:
```
[
  {
    "id": "1",
    "name": "Ang Mo Kio",
    "address": "Ang Mo Kio MRT",
    "latitude": "1.370015",
    "longitude": "103.849446",
    "postal": "",
    "bicycle_count": "30"
  },
  {
    "id": "2",
    "name": "Mayflower",
    "address": "253 Ang Mo Kio Street 21",
    "latitude": "1.369732",
    "longitude": "103.835231",
    "postal": "560253",
    "bicycle_count": "20"
  }
]
```

***

###POST ```feedback/new```
```
=> Submit a feedback. Issue will be one of values:
0: ISSUE_OTHERS;
1: ISSUE_BREAK_NOT_EFFECTIVE
2: ISSUE_TYRE_FLAT
3: ISSUE_CHAIN_GEARS_FAULTY
4: ISSUE_PARTS_LOOSE
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request:
```
{
  rentalId: 10,
  listIssue: [1, 2],
  comment: 'This is a comment',
  rating: 5
}
```
####Response:
```
"Feedback saved"
```
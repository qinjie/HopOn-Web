#Hop On
##CODES
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
    token: '3kj2rh3k2rhk2j3hkj42hk43h2kh4j32'
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
####Header: None
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
=> Request a new password
```
####Header: None
####Request:
```
{
    email: 'abc@mail.com'
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
=> Sign up new user
```
####Header: None
####Request:
```
{
    fullname: 'Tan Ah Boy',
    password: '123456',
    email: '123@mail.com',
    mobile: '91234123',
    role: (10: role user)
}
```
####Response:
```
{
    token: '3kj2rh3k2rhk2j3hkj42hk43h2kh4j32'
}
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

###GET ```user/info```
```
=> Get info of current user
```
####Header:
```
Authorization: 'Bearer <token>'
```
####Request: None
####Response:
```
{
  "currentDate": "2016-08-10",
  "fullname": "ADRIAN YOO",
  "username": "1111",
  "email": "1111@gmail.com"
}
```

***

###GET ```station/list-station```
```
=> Get list of stations
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
  },
  {
    "id": "3",
    "name": "Yio Chu Kang",
    "address": "3000 Ang Mo Kio Avenue 8",
    "latitude": "1.381841",
    "longitude": "103.844959",
    "postal": "569813",
    "bicycle_count": "30"
  },
  {
    "id": "4",
    "name": "Ang Mo Kio Garden",
    "address": "Opposite Ang Mo Kio Town Library, Ang Mo Kio Avenue 6",
    "latitude": "1.374542",
    "longitude": "103.843353",
    "postal": "567740",
    "bicycle_count": "25"
  }
]
```


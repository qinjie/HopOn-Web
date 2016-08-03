#Hop On
##CODES
###Error code in 400
```
CODE_INCORRECT_USERNAME = 0;
CODE_INCORRECT_PASSWORD = 1;
CODE_INCORRECT_DEVICE = 2;
CODE_UNVERIFIED_EMAIL = 3;
CODE_UNVERIFIED_DEVICE = 4;
CODE_UNVERIFIED_EMAIL_DEVICE = 5;
CODE_INVALID_ACCOUNT = 6;
CODE_DUPLICATE_DEVICE = 7;
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
    username: '1234',
    password: '123456',
    email: '123@mail.com',
    role: (10: role user, 20: role student, 30: role teacher),
    device_hash
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

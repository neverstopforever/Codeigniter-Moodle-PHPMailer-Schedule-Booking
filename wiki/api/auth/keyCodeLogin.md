# API keyCodeLogin



**Get auth/keyCodeLogin section**
----
  login via key_code, username, password .

* **URL**

  http://app.dev.akaud.com/api/auth/keyCodeLogin

* **Method:**

  `POST`
  
*  **URL Params**

   **Required:**
 
   `key_code=[string]`
   `username=[string]`
   `password=[string]`
  

* **Data Params**

* **Success Response:**

  * **Code:** 200 <br />
   **Content:** 
    ```json
    {
        "active": true,
        "status": true,
        "message": "OK",
        "twice_login": false
    }
    ```
 
* **Error Response:**

  * **Code:** 404 Not Found <br />
    **Content:** 
    ```json
   {
       "active": true,
       "status": false,
       "message": "Key Code is invalid",
       "twice_login": false
   }
    ```
    ```json
    {
        "active": true,
        "status": false,
        "message": "Wrong username / password combination",
        "twice_login": false
    }
    ```
    ```json
    {
        "active": true,
        "status": false,
        "message": "You have logged in yet",
        "twice_login": false
    }
    ```
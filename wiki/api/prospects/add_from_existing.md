# API Prospects add from existing

**Prospects/add_from_existing section**
----
  Prospect add .

* **URL**

  http://app.dev.akaud.com/api/prospects/add_from_existing

* **Method:**

  `POST`
  
*  **URL Params**

*   **Required:**   
    `user_id=[integer]`
    `profile_id=[integer]`
    
* **Data Params** 
  

* **Success Response:**

  * **Code:** 200 OK
   **Content:** 
```json
{
    "status": true,
    "message": "Prospect have been added successfully",
    "new_prospect_id": 29
}
```
 
* **Error Response:**

  * **Code:** 404 Not Found
    **Content:** 
    ```json
    {
        "status": false,
        "message": "Oops... Something went wrong. Please try again latter.",
        "new_prospect_id": null
    }
    ```    
    ```json
    {
      "status": false,
      "message": {
        "user_id": "The User Id field must only contain digits and must be greater than zero.",
        "profile_id": "The Profile Id field must only contain digits and must be greater than zero."
      }
    }
    ```    
    ```json
    {
      "status": false,
      "message": {
        "user_id": "The User Id field must only contain digits and must be greater than zero.",
        "profile_id": "The Profile Id field is required."
      }
    }
    ```    
    ```json
    {
      "status": false,
      "message": {
        "profile_id": "The Profile Id field is required."
      }
    }
    ```    
    ```json
    {
      "status": false,
      "message": {
        "user_id": "The User Id field is required."
      }
    }
    ```    
    ```json
   {
     "status": false,
     "message": {
       "user_id": "The User Id field is required.",
       "profile_id": "The Profile Id field must only contain digits and must be greater than zero."
     }
   }
    ```
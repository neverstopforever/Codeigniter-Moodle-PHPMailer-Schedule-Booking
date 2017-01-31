# API Prospects add a blank lead

**Prospects/add_blank_lead section**
----
  Prospect add .

* **URL**

  http://app.dev.akaud.com/api/prospects/add_blank_lead

* **Method:**

  `POST`
  
*  **URL Params**

*   **Required:**   
    `Nombre=[string]`
    `sApellidos=[string]`
    
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
        "Nombre": "The Firstname field is required.",
        "sApellidos": "The Surname field is required."
      }
    }
    ```    
    ```json
    {
      "status": false,
      "message": {
        "sApellidos": "The Surname field is required."
      }
    }
    ```    
    ```json
    {
      "status": false,
      "message": {
        "Nombre": "The Firstname field is required."
      }
    }
    ```
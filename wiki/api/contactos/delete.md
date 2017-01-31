# API Contactos delete

**Contactos/delete/{contact_id} section**
----
  Contact delete by id .

* **URL**

  http://app.dev.akaud.com/api/contactos/delete/{contact_id}

* **Method:**

  `DELETE`
  
*  **URL Params**

*   **Required:** 
  `contact_id=[integer]`

* **Data Params**
  

* **Success Response:**

  * **Code:** 200 OK
   **Content:** 
```json
{
    "status": true,
    "message": "Contact have been deleted successfully"
}
```
 
* **Error Response:**

  * **Code:** 404 Not Found
    **Content:** 
    ```json
    {
        "status": false,
        "message": "Oops... Something went wrong. Please try again latter."
    }
    ```
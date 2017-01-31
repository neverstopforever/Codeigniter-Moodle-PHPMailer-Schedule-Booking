# API Prospects

**Get prospects section**
----
  Returns  prospects .

* **URL**

  http://app.dev.akaud.com/api/prospects

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:** 
  
   **Header:** 
   X-API-KEY

* **Data Params**
  

* **Success Response:**

  * **Code:** 200 OK <br />
   **Content:** 
```json
[
  {
    "prospect_id": "2013189",
    "contact_name": "sname, sname fname",
    "company_name": null,
    "prospect_priority": "0",
    "phone": "6666",
    "mobile": "6666",
    "email": "test@test.es",
    "leido": "1",
    "prospect_state": "Pendiente Contactar",
    "state_color": "32C5D2",
    "prospect_score": "0",
    "prospect_user": null,
    "source": null,
    "campaign": null,
    "date_creation": "2016-03-09 00:00:00",
    "last_upadte": "2016-03-09 00:00:00",
    "last_followup": "2016-02-25",
    "enrolled": "No"
  },
  {
    "prospect_id": "2013188",
    "contact_name": "sname, sname fname",
    "company_name": null,
    "prospect_priority": "0",
    "phone": "1234",
    "mobile": "1234",
    "email": "test@test.es",
    "leido": "1",
    "prospect_state": "Pendiente Contactar",
    "state_color": "32C5D2",
    "prospect_score": "0",
    "prospect_user": null,
    "source": null,
    "campaign": null,
    "date_creation": "2016-03-09 00:00:00",
    "last_upadte": "2016-03-09 00:00:00",
    "last_followup": "2016-02-25",
    "enrolled": "No"
  }
]
```
 
* **Error Response:**

  * **Code:** 401 Unauthorized <br />
    **Content:** 
    ```json
    {
        "message": false,
        "status": false
    }
    ```
    
    
# API Prospects By Id

**Get prospects?prospect_id={id} section**
----
  Returns  prospects by Id .

* **URL**

  http://app.dev.akaud.com/api/prospects?prospect_id=2013189

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:** 
   `prospect_id=[integer]`
  **Header:** 
     X-API-KEY

* **Data Params**
  

* **Success Response:**

  * **Code:** 200 OK <br />
   **Content:** 
```json
{
    "prospect_id": "2013189",
    "contact_name": "sname, sname fname",
    "company_name": null,
    "prospect_priority": "0",
    "phone": "6666",
    "mobile": "6666",
    "email": "test@test.es",
    "leido": "1",
    "prospect_state": "Pendiente Contactar",
    "state_color": "32C5D2",
    "prospect_score": "0",
    "prospect_user": null,
    "source": null,
    "campaign": null,
    "date_creation": "2016-03-09 00:00:00",
    "last_upadte": "2016-03-09 00:00:00",
    "last_followup": "2016-02-25",
    "enrolled": "No"
}
```
 
* **Error Response:**

  * **Code:** 401 Unauthorized <br />
    **Content:** 
    ```json
    {
        "status": false,
        "message": "Contact could not be found"
    }
    ```
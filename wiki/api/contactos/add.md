# API Contactos add

**Contactos/add section**
----
  Contact add .

* **URL**

  http://app.dev.akaud.com/api/contactos/add

* **Method:**

  `POST`
  
*  **URL Params**

*   **Required:**   

* **Data Params**
  `Snombre=[string]`
  `Sapellidos=[string]`
  `Domicilio=[string]`
  `Poblacion=[string]`
  `Provincia=[string]`
  `Distrito=[string]`
  `Telefono1=[string]`
  `Telefono2=[string]`
  `Movil=[string]`
  `Pais=[string]`
  `email=[string]`
  `nif=[string]`
  `fnacimiento=[string]`
  `skype=[string]`
  `Idsexo=[string]`
  `iban=[string]`
  `Cc1=[string]`
  `Cc2=[string]`
  `Cc3=[string]`
  `Cc4=[string]`
  `facturara=[integer]`
  `seguimiento=[string]`

* **Success Response:**

  * **Code:** 200 OK
   **Content:** 
```json
{
    "status": true,
    "message": "Contact have been added successfully",
    "new_content_id": 29
}
```
 
* **Error Response:**

  * **Code:** 404 Not Found
    **Content:** 
    ```json
    {
        "status": false,
        "message": "Oops... Something went wrong. Please try again latter.",
        "new_content_id": null
    }
    ```
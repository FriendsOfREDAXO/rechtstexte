# The client model

## Properties
The model properties.
There may be internal modifications in future releases, but there will always be the same getter and setter.
Internal names of properties may change, so avoid direct access.
```php
/**
 * @class eRecht24\RechtstexteSDK\Model\Client
 *
 * @property int client_id          // client_id is used to identify user`s client 
 * @property int project_id         // project_id is used to identify user`s project
 * @property string push_uri        // HTTP url endpoint
 * @property string push_method     // HTTP method of push_uri "GET" or "POST"
 * @property string cms             // name of cms (not mandatory, but they will help us in case of failures)
 * @property string cms_version     // version of cms (not mandatory, but they will help us in case of failures)
 * @property string plugin_name     // plugin name (not mandatory, but they will help us in case of failures)
 * @property string author_mail     // plugin author email (not mandatory, but they will help us in case of failures)
 * @property string created_at      // client creation date
 * @property string updated_at      // client update date
 */
```

### Editable properties
The following properties you may change on creating or updating the client data.
```php
/**
 * @property string push_uri        // HTTP url endpoint
 * @property string push_method     // HTTP method of push_uri "GET" or "POST"
 * @property string cms             // name of cms (not mandatory, but they will help us in case of failures)
 * @property string cms_version     // version of cms (not mandatory, but they will help us in case of failures)
 * @property string plugin_name     // plugin name (not mandatory, but they will help us in case of failures)
 * @property string author_mail     // plugin author email (not mandatory, but they will help us in case of failures)
 */
```

See example: [update client](./client_update.md).

## Registration
Clients have to be registered in order to receive push notifications.
You have to register a client with at least 2 information
 
  - `push_uri` (required)
  - `push_method` (required)

Without registration, you won't be able to push legal documents to your clients.
Ensure the given ***push_uri*** is publicly accessible with the given ***push_method*** (GET or POST).
If registration is done correctly you'll get a ***secret*** and a ***client_id***.
Please store both values on the client side in order to verify incoming push notifications.
The `secret` is used to check whether incoming push notifications are from eRecht24 and to prevent DoS attacks against our servers.
The `client_id` can be used to update client information or to remove them from your project.
There is a limit of 3 clients per project.

See example: [register client](./client_register.md).


## Receiving push notification
When requested in [eRecht24 Projekt Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/), the eRecht24 server will send a request to the registered `push_uri` with the registered `push_method`.
The request includes 2 data

  - `erecht24_secret` -> the secret generated while register/update the client
  - `erecht24_type` -> the type for the push notification

You have to ensure this request is authorized.

See [push controller example](./push_controller.md)



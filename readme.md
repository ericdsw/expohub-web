## ExpoHub Web

[ ![Codeship Status for 05eric/expohub-web](https://codeship.com/projects/e4d03980-d04e-0133-6c47-1e2b23aa142a/status?branch=master)](https://codeship.com/projects/141357)

Web component for the application **Expo Hub**. This component will expose resources using standard API rules defined for JSONApi (more information about this specification can be found here: http://jsonapi.org/format/).

This project is based on **Laravel v5.1**, so it requires the same technologies to work.

**Disclaimer:** ExpoHub is a thesis project used to demonstrate a client-server architecture development, and thus it should be considered to be in an **exprimental phase**. An example client implementation can be found here: https://github.com/ericdsw/expohub-android

#### Querying the API

Every public resource will be exposed using CRUD endpoints (which stands for *create*, *read*, *update* and *destroy*) in the following format:
* `GET /resource` Will give a list of the resource.
* `GET /resource/{id}` Will give the specified resource for the `id` parameter.
* `POST /resource` Will create a new resource.
* `PUT /resource/{id}` Will update an existing resource.
* `DELETE /resource/{id}` Will delete specified resource.

Depending on the specified resource, additional verification will be applied to ensure user can perform requested action on the resource (such as ownership and user type).
Additional endpoints are exposed as sub-resources for related entities, or as properties for the object if it is not a sub-resource.

Every **GET** endpoint support the following extra query parameters:
* `sort`: will sort response by the specified fields. Multiple sort fields can be defined (separated by comma), and sort order can be reversed by preceding the value with the "-" character.
* `include`: will include related objects in the response. Each object has a defined set of related objects that can be included, which is defined in the object graph. Generally speaking, include will only support inclusion of first-order relationships, and can accept multiple include parameteres separated by comma.
* `page`: array argument for cursor-based pagination. array keys are `cursor` and `limit`, and they will allow the client to format the response length as needed.
	* `cursor`: The current page's offset.
	* `limit`:  How many items will be displayed after the `cursor` declaration.

#### Exposed Resources

The following entities are exposed via this API:

Endpoint | Resource
-------- | ------------------
`fairs` | Fairs registered to the system
`fairEvents` | Events registered to the system (N:1 relationship with fairs)
`categories` | ategories that it's events can register to
`maps` | Maps registered to the system (N:1 relationship with fairs)
`stands` | Stands registered to the system (N:1 relationship with fairs)
`news` | News registered to the system (N:1 relationship with fairs)
`sponsors` | Fair's sponsors
`speakers` | Event's speakers
`comments` | News' comments

#### Authorization

Authorization will be performed via **Json Web Token**, which will verify identified users; and **Api Access Token**, which will allow transactions for authorized apps.

To identify a user for the **Json Web Token** filter, the customer must make a request either to the `POST /login` or `POST register` (in case the user does not exists) endpoints, which will return meta data containing the user's respective key. This key must be included via a header with the format `Authorization: Bearer {key}` as defined by the JsonWebToken standard (RFC 7519).
Failure to provide this key will result in a **401 Unauthorized** status code, and providing a user without sufficient permissions will result in a **403 Forbidden** status.

#### Access Controllers

The **Api Access Token** will decide which clients can communicate with the api, and the client must include the api token via a header with the format `x-api-authorization: {YOUR_APP_ID}.{YOUR_APP_SECRET}`.
This token is a concatenation of the app's id and secret keys, which can be obtained by executing the following command: `php artisan apiToken:create {YOUR_APP_NAME}`, which will generate the following output:

```
Created api token with the following info:
app_id: {YOUR_APP_ID}
app_secret: {YOUR_APP_SECRET}
```

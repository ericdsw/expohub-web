## ExpoHub Web Component

[ ![Codeship Status for 05eric/expohub-web](https://codeship.com/projects/e4d03980-d04e-0133-6c47-1e2b23aa142a/status?branch=master)](https://codeship.com/projects/141357)

Web component for the application **Expo Hub**. This component will expose resources using standard API rules defined for jsonApi. (http://jsonapi.org/format/).

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
* `page`: array argument for cursor-based pagination. array keys can be `cursor`, `limit` and `previous`, and they will allow the client to format the response length as needed.

Authorization will be performed via **Json Web Token**, which will verify identified users; and **Api Access Token**, which will allow transactions for authorized apps.

To identify a user for the **Json Web Token** filter, the customer must make a request either to the `POST /login` or `POST register` (in case the user does not exists) endpoints, which will return meta data containing the user's respective key. This key must be included via a header with the format `Authorization: Bearer {key}` as defined by the JsonWebToken standard (RFC 7519).
Failure to provide this key will result in a **401 Unauthorized** status code, and providing a user without sufficient permissions will result in a **403 Forbidden** status.

The **Api Access Token** will decide which clients can communicate with the api, and the client must include the api token via a header with the format `X-Api-Authorization: {apiToken}`.
This token is a concatenation of the app's id and secret keys, which can be obtained by contacting the app administrator.
# Kanye West Quotes

## Requirements
- Docker


## Installation

run following command to install application
```bash
make service-install
```
.env file should have been generated with default values from .env.example file.
Additionally, the API_TOKEN should have been generated by the service-install command as well as the APP_KEY.

you can generate a new API_TOKEN by running the following command
```bash
make generate-api-token
```

## remove the service
```bash
  make docker-down
````


## Usage

you should be able to call the following endpoint with a Bearer token which is the API_TOKEN generated in the installation step.

To get the quotes, quotes are refreshed every 5 minutes by default.
```
GET: http://localhost:8080/api/kanye-west/quotes
```

For refreshing the quotes
```
POST: http://localhost:8080/api/kanye-west/quotes/refresh
```

A Postman collection can be found in the root of the project.
```
Quotes_Api.postman_collection.json
```



## Running Tests
To run the tests run the following command
```bash
make unit-tests
```

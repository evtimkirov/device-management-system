# IoT Device Management System

## How to setup

* Download the repository
```githubexpressionlanguage
git clone git@github.com:evtimkirov/device-management-system.git && cd device-management-system
```

* Build the containers
```dockerfile
docker compose up --build
```

## API endpoints
| HTTP Method | Endpoint                                       | Description                       | Middleware / Auth               |
| ----------- | ---------------------------------------------- | --------------------------------- | ------------------------------- |
| POST        | `/api/v1/login`                                | Login user and return token       | —                               |
| POST        | `/api/v1/logout`                               | Logout current user               | `auth:sanctum`                  |
| GET         | `/api/v1/me`                                   | Get current authenticated user    | `auth:sanctum`                  |
| POST        | `/api/v1/users`                                | Create new user                   | `auth:sanctum`                  |
| DELETE      | `/api/v1/users/{user}`                         | Delete user by ID                 | `auth:sanctum`                  |
| POST        | `/api/v1/devices`                              | Create new device                 | `auth:sanctum`, `device.access` |
| DELETE      | `/api/v1/devices/{id}`                         | Delete device by ID               | `auth:sanctum`, `device.access` |
| POST        | `/api/v1/users/{user}/devices/{device}/attach` | Attach device to user             | `auth:sanctum`, `device.access` |
| DELETE      | `/api/v1/users/{user}/devices/{device}/detach` | Detach device from user           | `auth:sanctum`, `device.access` |
| GET         | `/api/v1/users/{user}/measurements`            | Get measurements for a user       | `auth:sanctum`, `device.access` |
| POST        | `/api/v1/devices/{device}/measurements`        | Create new measurement for device | `auth:sanctum`, `device.access` |
| GET         | `/api/v1/users/{user}/alerts`                  | Get alerts for a user             | `auth:sanctum`, `device.access` |

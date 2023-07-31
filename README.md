# Light IT Patient Registry Application

This repository contains a challenge solution for Light IT. The application serves as a patient registry system.

## Tools Used

- PHP 8.1
- Kool.dev (https://kool.dev/docs/presets/laravel) for Docker setup
- Mailhog (https://github.com/mailhog/MailHog) for email testing
- MySQL 8.0

## Getting Started

To set up the environment, follow these steps:

1. Download the project from the repository.
2. Run `kool run setup` to install necessary Composer packages, generate the Laravel key, create the `patients_db` database, and create the storage link. (For details on the enabled scripts, refer to kool.yml). Additionally, this command will generate the `.env` file based on the `.env.example`.
3. The application will run by default on port **8565**.
4. You can test if the application is running on http://localhost:8565

## Sending Emails

Emails are sent using Laravel's job feature with the database as the queue. To start listening to Laravel jobs, run `kool run jobs`.

## API Endpoints

The following API endpoints are available:

1. **POST** `api/v1/patients`: Add a new patient record.
2. **GET** `api/v1/patients`: Get a list of all patients.
3. **GET** `api/v1/patients/{id}`: Get details of a specific patient.

Example of adding a patient record (Remember to attach a file for the identification photo):

```bash
curl --location --request POST 'localhost:8565/api/v1/patients' \
--form 'name="Tromp"' \
--form 'email="Erik.Zemlak@hotmail.com"' \
--form 'phone_number="589-930-1251"' \
--form 'identification_photo=@"/home/user/images/file.png"'
```

## Testing Application
To run tests, execute the following command:
```bash
# This command will execute the features tests.
kool run test
```

## Future Improvements
Some potential future improvements for the application include:

- Incorporating Localstack (https://github.com/localstack/localstack) into the application's 
docker-compose for saving images in S3 and jobs in SQS.
- Implementing unit tests for application services.
- Implementing SMS notifications






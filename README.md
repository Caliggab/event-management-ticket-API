# Event Management and Ticketing API

An API solution to allow event organizers to create, manage, and sell tickets for their events. Event enthusiasts can browse and purchase tickets seamlessly. Integrated with Stripe for payment processing.

## Table of Contents

- [Installation](#installation)
- [API Endpoints](#api-endpoints)
- [Testing](#testing)
- [Documentation](#documentation)
- [Tech Stack](#tech-stack)
- [Feedback & Contribution](#feedback--contribution)

## Installation

This project utilizes Laravel Sail for development. Ensure you have Docker installed on your machine.

1. Clone the repository:
   ```bash
   git clone https://github.com/Caliggab/event-management-ticket-API event-management-api
   ```

2. Navigate to the project directory:
   ```bash
   cd event-management-api
   ```

3. Start Laravel Sail:
   ```bash
   ./vendor/bin/sail up
   ```

4. Migrate the database:
   ```bash
   ./vendor/bin/sail artisan migrate
   ```


## API Endpoints

All endpoints follow the REST standard.

- `POST /auth/register`: Register a new event planner.
- `POST /auth/login`: Login for an event planner.
- `POST /events`: Create a new event.

Complete list of endpoints can be found in the [API documentation](https://elaniin-ticketing.stoplight.io/docs/https-github-com-caliggab-event-management-ticket-api/b8qvpomuiqjxm-event-ticketing-api).

## Testing

1. To run integration tests:
   ```bash
   ./vendor/bin/sail test
   ```

## Documentation

API documentation has been crafted following the OpenAPI standard. 

- [Check the documentation here](https://elaniin-ticketing.stoplight.io/docs/https-github-com-caliggab-event-management-ticket-api/b8qvpomuiqjxm-event-ticketing-api)

## Tech Stack

- Laravel
- MySQL
- Docker (via Laravel Sail)
- Stripe for payment processing

## Feedback & Contribution

Feel free to fork, raise issues, or submit pull requests. If you'd like to discuss any improvements or provide feedback, reach out to [your-email@email.com](mailto:your-email@email.com).

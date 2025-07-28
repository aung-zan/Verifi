# Verifi

This project is a API based application that allows users to upload content(text) and have it checked. It consists of two main services: a Laravel-based API for handling user authentication and content management, and an Express.js service for content checking. The services are orchestrated using Docker Compose, with PostgreSQL as the database and RabbitMQ for messaging.

## Services

*   **`upload` (Laravel API):** Handles user registration, login, profile management, and content CRUD operations.
*   **`check` (Express.js Service):** Provides a content checking functionality.
*   **`pgsql` (PostgreSQL):** The primary database for the application.
*   **`verifi-rabbitmq` (RabbitMQ):** A message broker for communication between services.

## Getting Started

### Prerequisites

*   [Docker](https://docs.docker.com/get-docker/)
*   [Docker Compose](https://docs.docker.com/compose/install/)

### Installation

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/verifi.git
    cd verifi
    ```

2.  **Build and run the services:**

    ```bash
    docker compose up -d --build
    ```

## Usage

### API Documentation

The OpenAPI documentation for the `upload` service is available at `/doc/api` after starting the services.

### API Endpoints

The `upload` service provides the following API endpoints:

*   **Authentication:**
    *   `POST /api/register`: Register a new user.
    *   `POST /api/login`: Log in a user.
    *   `POST /api/logout`: Log out the current user (requires authentication).
*   **User Profile:**
    *   `GET /api/profile`: Get the current user's profile (requires authentication).
    *   `PUT /api/profile`: Update the current user's profile (requires authentication).
*   **Content:**
    *   `GET /api/content`: Get a list of content for the current user (requires authentication).
    *   `POST /api/content`: Create new content (requires authentication).
    *   `GET /api/content/{id}`: Get specific content by ID (requires authentication).
    *   `PUT /api/content/{id}/update`: Update specific content by ID (requires authentication).
    *   `DELETE /api/content/{id}/delete`: Delete specific content by ID (requires authentication).

The `check` service has a single endpoint:

*   `GET /`: A simple health check endpoint.

### Running Commands

You can run commands within the `upload` service container for tasks like database migrations and seeding:

```bash
docker compose exec laravel-app php artisan migrate --seed
```

## Development

The `upload` service includes a `dev` script in its `composer.json` to facilitate development. This script starts the Laravel development server, a queue worker, a log watcher, and the Vite development server.

To start the development environment, run:

```bash
docker compose exec laravel-app composer run dev
```
To run the test cases, first create test database:

```bash
docker compose exec -it postgres psql -U aungminzan -d verifi
create database verifi_testing;
exit;
```

Then run:

```bash
docker compose exec -it laravel-app php artisan test
```
# 🏨 Maximized Profit Stats Application

This project is designed to help you calculate the best possible profit stats for your bookings.
It's built with PHP (Symfony framework) and uses Composer for dependency management.
The API lives in a Docker container and is ready to go with a simple `make` command.

## 🚀 Getting Started

To get started with the project, follow these simple steps:

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/your-username/maximized-profit-stats.git
   cd maximized-profit-stats
   ```

2. 🔥 **Application execution:**
    - Download all images to bring up the project: `make build`
    - Bring up the project: `make start`
    - Setup project (Install all the dependencies && migrations if any): `make setup`

### Running the Project

Now the API is ready to go! You can do a first API call to ensure everything is working correctly:

```bash
GET http://localhost:8080/public/health
```

### Running Tests

I have a suite of unit tests to ensure everything is working correctly. To run the tests, use the following command:

```bash
make test
```

Unfortunately, I didn't have time to do some end to end tests 😢. **However**, there is an .http file available with all the API endpoints calls ready to run and compare the results. The data examples are the same as in the challenge description, so the results should be the same 😉.

### 👋 Finishing
To stop the project, you can use the following command:

```bash
make stop
```

## 📚 How it is structured
The code follows the DDD and Hexagonal Architecture principles, it is split into the 3 layers:
- Infrastructure
- Application
- Domain

We can find two bounded contexts:
- **Booking**
- **Shared**

An inside the Booking bounded context, there is the **ProfitStat** module. Inside this module we can find the domain aggregates and domain services in the domain layer, and the queries, handlers and views in the application layer.

Happy coding! 🍻

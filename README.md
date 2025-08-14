# Vue + Laravel Full-Stack Application

This application consists of a Vue.js frontend (TypeScript) and a Laravel backend API.

## Project Structure

```
Oefenopdracht/
├── client/          # Vue.js TypeScript application
└── server/          # Laravel API
```

## Setup & Installation

### Requirements

- Node.js (v18+)
- PHP (v8.1+)
- Composer
- pnpm
- MySQL database

### Client (Vue.js) Setup

```bash
cd client
pnpm install
pnpm dev
```

The client runs on: http://localhost:5174

### Server (Laravel) Setup

```bash
cd server
composer install
cp .env.example .env
php artisan key:generate
```

Configure your database settings in `.env` file, then run:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

The API runs on: http://localhost:8001

**Important:** You must seed the database to create a test user for login testing:

- Email: `test@golfspot.io`
- Password: `wachtwoord123`

## Development

### Starting both servers simultaneously

From the root directory:

```bash
# Terminal 1 - Laravel API
cd server && php artisan serve

# Terminal 2 - Vue.js Client
cd client && pnpm dev
```

### API Endpoints

#### Authentication

- `POST /api/auth/login` - User authentication
- `POST /api/auth/logout` - User logout
- `POST /api/auth/refresh` - Refresh JWT token
- `GET /api/auth/me` - Get authenticated user profile
- `PUT /api/auth/profile` - Update user profile

#### News

- `GET /api/news` - Get all news articles
- `GET /api/news/{id}` - Get specific news article

### Frontend Features

- TypeScript support
- Vue 3 with Composition API
- Tailwind CSS for styling
- Axios for API calls
- JWT authentication
- Reactive data binding
- Error handling
- Multi-language support (i18n)
- Profile photo upload functionality
- Responsive design

### Backend Features

- Laravel 11
- JWT Authentication
- API Resource Controllers
- CORS support
- MySQL database
- Database migrations and seeders
- Profile management
- Image upload handling (base64)
- Request validation

## Database Seeding

The application includes seeders for testing:

```bash
# Seed test user and sample data
php artisan db:seed

# Or seed specific seeders
php artisan db:seed --class=TestUserSeeder
php artisan db:seed --class=NewsSeeder
```

### Test Credentials

After seeding, you can login with:

- **Email:** test@golfspot.io
- **Password:** wachtwoord123

## Testing

The application includes comprehensive tests for login functionality.

### Running Tests

```bash
cd server

# Run all tests
php artisan test

# Run only login tests
php artisan test --filter LoginTest

# Run tests with coverage
php artisan test --coverage
```

### Test Coverage

The login tests cover:

- ✅ Successful login with valid credentials
- ✅ Failed login with invalid email
- ✅ Failed login with invalid password
- ✅ Login validation (required fields)
- ✅ Email format validation
- ✅ Login returns correct user data and JWT token

The application includes comprehensive tests for authentication functionality.

### Running Tests

```bash
cd server

# Run all tests
php artisan test

# Run only authentication tests
php artisan test --filter AuthenticationTest

# Run tests with coverage
php artisan test --coverage
```

### Test Coverage

The authentication tests cover:

- ✅ Successful login with valid credentials
- ✅ Failed login with invalid email
- ✅ Failed login with invalid password
- ✅ Login validation (required fields)
- ✅ Email format validation
- ✅ Logout functionality
- ✅ Token refresh functionality
- ✅ Profile access with authentication
- ✅ JWT token expiration handling

## Configuration

### CORS

The Laravel API is configured to accept requests from `localhost:5174`.

### Database

The application uses MySQL. Configure your database connection in the `.env` file.

### Environment Variables

Check the `.env` files in both projects for configuration options.

## Production

For production deployment:

1. Build the Vue.js client: `cd client && pnpm build`
2. Configure Laravel for production environment
3. Set up database connection
4. Configure web server (Nginx/Apache)
5. Set proper JWT secrets and API keys

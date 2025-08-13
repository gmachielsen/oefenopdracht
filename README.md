# Vue + Laravel Full-Stack Application

Deze applicatie bestaat uit een Vue.js frontend (TypeScript) en een Laravel backend API.

## Project Structuur

```
Oefenopdracht/
├── client/          # Vue.js TypeScript applicatie
└── server/          # Laravel API
```

## Setup & Installatie

### Vereisten

- Node.js (v18+)
- PHP (v8.1+)
- Composer
- pnpm

### Client (Vue.js) Setup

```bash
cd client
pnpm install
pnpm dev
```

De client draait op: http://localhost:5173

### Server (Laravel) Setup

```bash
cd server
composer install
php artisan serve
```

De API draait op: http://localhost:8000

## Development

### Beide servers tegelijk starten

Van de root directory:

```bash
# Terminal 1 - Laravel API
cd server && php artisan serve

# Terminal 2 - Vue.js Client
cd client && pnpm dev
```

### API Endpoints

- `GET /api/test` - Test API verbinding
- `GET /api/examples` - Alle voorbeelden ophalen
- `POST /api/examples` - Nieuw voorbeeld aanmaken
- `GET /api/examples/{id}` - Specifiek voorbeeld ophalen
- `PUT /api/examples/{id}` - Voorbeeld bijwerken
- `DELETE /api/examples/{id}` - Voorbeeld verwijderen

### Frontend Features

- TypeScript ondersteuning
- Axios voor API calls
- Reactieve data binding
- Error handling
- CORS configuratie

### Backend Features

- Laravel 11
- API Resource Controllers
- CORS ondersteuning
- SQLite database (standaard)
- Laravel Sanctum voor authenticatie
- Request validatie

## Configuratie

### CORS

De Laravel API is geconfigureerd om requests van `localhost:5173` toe te staan.

### Database

Standaard gebruikt de applicatie SQLite. De database wordt automatisch aangemaakt bij de eerste migratie.

### Environment Variables

Bekijk de `.env` bestanden in beide projecten voor configuratie opties.

## Productie

Voor productie deployment:

1. Build de Vue.js client: `cd client && pnpm build`
2. Configureer Laravel voor productie environment
3. Stel database verbinding in
4. Configureer webserver (Nginx/Apache)

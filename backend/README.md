# DineOps Backend

Node.js + Express backend skeleton for DineOps.

## Source structure

- `src/app.js` - express app configuration
- `src/server.js` - application entrypoint
- `src/routes/` - api routes
- `src/controllers/` - controller logic
- `src/services/` - business logic layer
- `src/models/` - database access

## Scripts

- `npm install`
- `npm run dev` - start with nodemon
- `npm start` - start production server

## Configuration

Copy `.env.example` to `.env` and update database values.

## Endpoints

- `GET /api/health`
- `GET /api/users`
- `POST /api/users`

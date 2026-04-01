# DineOps Backend

Node.js + Express backend skeleton for DineOps.

## Architecture

- Express API server
- MongoDB via Mongoose
- Realtime Socket.io support
- API routes for users and orders

## Source structure

- `src/app.js` - express app configuration
- `src/server.js` - application entrypoint
- `src/routes/` - api routes
- `src/controllers/` - controller logic
- `src/services/` - business logic layer
- `src/models/` - database schemas and models
- `src/socket.js` - realtime socket initialization

## Scripts

- `npm install`
- `npm run dev` - start with nodemon
- `npm start` - start production server

## Configuration

Copy `.env.example` to `.env` and update the MongoDB connection string.

## Endpoints

- `GET /api/health`
- `GET /api/users`
- `POST /api/users`
- `GET /api/orders`
- `POST /api/orders`

# DineOps Project Skeleton

This workspace now contains a basic backend and Expo mobile frontend structure.

## Backend
- Path: `backend/`
- Node.js + Express
- Example endpoints in `backend/src/routes/users.js`
- Database config in `backend/src/config/db.js`

## Mobile frontend
- Path: `mobile/`
- React Native Expo app
- Navigation in `mobile/src/navigation/AppNavigator.js`
- Screens in `mobile/src/screens/`
- API client in `mobile/src/api/api.js`

## Web frontend
- Path: `frontend/`
- React + Vite app
- Entry point in `frontend/src/main.jsx`
- Pages in `frontend/src/pages/`
- Components in `frontend/src/components/`
- API client in `frontend/src/api/`

## Getting started

### Backend
1. `cd backend`
2. `npm install`
3. Copy `.env.example` to `.env`
4. `npm run dev`

### Mobile
1. `cd mobile`
2. `npm install`
3. `npm start`

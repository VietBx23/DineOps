# DineOps Project Skeleton

DineOps is an end-to-end starter kit for building a modern restaurant management platform. It combines a powerful backend, a web dashboard, and a mobile app to support real-world F&B operations across multiple stores.

This repository is built to showcase a production-ready architecture for:
- Multi-location restaurant management
- QR-based table ordering
- Inventory and supply tracking
- Role-based access for admin, manager, staff, and kitchen users
- Realtime order flow and kitchen updates

## Project purpose
The goal of DineOps is to provide a practical foundation for an F&B SaaS solution. It is structured to help teams move quickly from prototype to scalable product by delivering:
- A modular backend API with clean separation of routes, controllers, services, and data models
- Web frontend scaffolding for administrative dashboards and store management
- Mobile frontend scaffolding for customer order experience and staff workflows
- Realtime socket support for fast order notifications and status updates

## Key features
- Multi-store support with isolated data per branch
- QR table ordering workflow
- Order management and kitchen status updates
- Inventory and product tracking structure
- Role-based access control (RBAC) for admin, manager, staff, and kitchen
- Realtime events for order creation and status changes

## Architecture overview
The workspace includes three main apps:

### Backend
- Path: `backend/`
- Node.js + Express API server
- MongoDB integration using Mongoose
- Realtime layer via Socket.io
- Clean folder structure with `routes`, `controllers`, `services`, and `models`
- Example resources: users and orders

### Web frontend
- Path: `frontend/`
- React + Vite single page app
- `src/pages/` for page views
- `src/components/` for reusable UI elements
- `src/api/` for backend integration
- Example structure supports future admin dashboard expansion

### Mobile frontend
- Path: `mobile/`
- React Native Expo application
- `src/screens/` for mobile screens
- `src/navigation/` for app routing
- `src/api/` for backend requests
- Ready for mobile order flow and staff operations

## Workspace structure
- `backend/` - API server and realtime backend
- `frontend/` - browser-based React UI
- `mobile/` - Expo-based mobile app
- `document.txt` - project requirement and architecture notes

## How to run

### Backend
1. `cd backend`
2. `npm install`
3. Copy `.env.example` to `.env`
4. Update `MONGODB_URI` as needed
5. `npm run dev`

### Web
1. `cd frontend`
2. `npm install`
3. `npm run dev`

### Mobile
1. `cd mobile`
2. `npm install`
3. `npm start`

## Notes
- The backend is ready for extension with additional resource modules such as products, stores, tables, and inventory.
- The web and mobile apps use a shared API pattern for easier integration.
- The current setup is a skeleton; you can add authentication, permissions, and deeper business logic based on the PRD.

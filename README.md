<img src="./readme/title1.svg"/>

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg"/>

> **SmartDine** is your restaurant’s secret weapon.  
> It’s not just about menus and orders — it’s about making every branch, every client, and every owner feel like they’re part of something seamless and smart.  
> Whether you're running one location or fifty, SmartDine gives you a command center to manage it all effortlessly.  
> Real-time insights, AR-powered previews, AI-based combos, and client-facing assistants — it's not a system, it's your digital restaurant empire.

<br><br>

<!-- System Design -->
<img src="./readme/title3.svg"/>

### Architecture Overview

- **Client App**: Built in Flutter for a fast, native experience
- **Web Dashboard**: React-powered control panel for owners and admins
- **API Layer**: Laravel handles authentication, business logic, and DB interaction
- **Real-Time**: Express + Socket.IO for WebSocket-powered updates
- **Infrastructure**: Dockerized services, deployed via GitHub Actions to AWS EC2
- **Caching & Queues**: Redis is used across the stack for performance and task management

#### Database Diagram – Restaurant-Manager

<img src="./readme/erd.svg"/>

<br><br>

<!-- Project Highlights -->
<img src="./readme/title4.svg"/>

### What Makes SmartDine Special

- AI-generated meal combos tailored to each user’s preferences
- Augmented reality dish preview before ordering
- Smart chair sensors show real-time seat availability
- In-app assistant that guides users and answers menu questions
- Branch-level control for price, availability, and product descriptions
- Real-time updates pushed to users instantly through WebSockets
- Three distinct role-based views: admin, owner, and client

<br><br>

<!-- Admin Panel Extras -->
<img src="./readme/title4.svg"/>

### Admin Control Panel

- Register new restaurants and assign ownership
- Audit restaurant menus, data, and performance
- Moderate public reviews with platform-level visibility
- Track analytics across all branches
- Manage system-level settings like feature flags, cache, and background jobs
- Override content where necessary — always with audit tracking

<br><br>

<!-- Demo -->
<img src="./readme/title5.svg"/>

> Demo animations (5s or less) are being finalized. Coming soon.

### User Screens (Mobile)

| Login                          | Register                        | Home                            |
| ----------------------------- | ------------------------------- | ------------------------------- |
| ![Login](./readme/demo/login.png) | ![Register](./readme/demo/register.png) | ![Home](./readme/demo/home.png) |

### Admin Screens (Web)

| Dashboard                      | Product Management              |
| ----------------------------- | ------------------------------- |
| ![Dashboard](./readme/demo/admin1.png) | ![Products](./readme/demo/admin2.png) |

<br><br>

<!-- Development & Testing -->
<img src="./readme/title6.svg"/>

### Development Flow

- Modular folder structure with feature-based separation
- FormRequests and DTOs for input validation and transformation
- PHPUnit, Flutter Test, and Postman used across layers
- AI services and Redis caching are unit-tested in isolation
- Pint, Dart Format, and ESLint maintain code quality on every commit

<br><br>

<!-- Deployment -->
<img src="./readme/title7.svg"/>

### Deployment Pipeline

- Each service (Laravel, React, Express, Flutter) is containerized with Docker
- GitHub Actions handles testing, building, and deployment
- Deployed to AWS EC2 with persistent volume binding and `.env` configs
- Public API: `https://api.smartdine.app:8010`
- Health Check: `GET /v1/health` → `{ "status": "ok" }`
- Postman Collection: `/docs/SmartDine.postman_collection.json`

| Auth API                         | Order API                         | AI API                            |
| -------------------------------- | ---------------------------------- | --------------------------------- |
| ![Auth](./readme/demo/postman1.png) | ![Order](./readme/demo/postman2.png) | ![AI](./readme/demo/postman3.png) |

<br><br>

SmartDine empowers clients, equips owners, and keeps admins in control.  
This is restaurant tech — done right.

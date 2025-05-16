<img src="./readme/title1.svg"/>

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg"/>

> **SmartDine** is a next-generation restaurant management system built for chains with many branches and even more hungry guests.  
> It unifies mobile ordering, branch operations, and owner analytics under one roof—sprinkled with AI personalisation and IoT smarts.  
> 
> • **Flutter** mobile app (clients)  
> • **React** web dashboard (owners & admins)  
> • **Laravel** REST API + MySQL + Redis  
> • WebSockets via **Express + Socket.IO**  
> • Containers & CI with **Docker**, **GitHub Actions**, and **AWS EC2**

<br><br>

<!-- System Design -->
<img src="./readme/title3.svg"/>

### Architecture Overview

- **Frontend**  
  - Flutter (client app)  
  - React (owner & admin web)

- **Backend**  
  - Laravel REST API (auth, business logic)  
  - Redis (caching & queues)  
  - MySQL (relational data)  
  - **Express + Socket.IO** (WebSockets for real-time features)

- **DevOps**  
  - Docker-compose for container orchestration  
  - GitHub Actions for CI/CD  
  - EC2 hosts the app with auto deployment

> ER Diagram: `readme/erd.svg`  
> Architecture Diagram: `readme/architecture.svg`

<br><br>

<!-- Project Highlights -->
<img src="./readme/title4.svg"/>

### Key Features

- AI-powered dish and combo recommendations personalized per user
- AR menu preview — customers can place virtual dishes on real tables
- Smart chair sensors showing live seat availability + triggers for cleaners
- In-app AI assistant — answers menu questions and helps new users
- Multi-restaurant and multi-branch support with local overrides
- Real-time order tracking using **Express + Socket.IO**
- Role-based access for admins, owners, and clients

<br><br>

<!-- Admin Panel Extras -->
<img src="./readme/title4.svg"/>

### Admin Panel Duties

- Register restaurants and assign owners
- Audit or override any restaurant's content
- Moderate reviews and manage platform content
- View global analytics across all restaurants
- System management tools (caching, queues, feature toggles)
- Product editing is restricted to owners, but admins can override if needed

<br><br>

<!-- Demo -->
<img src="./readme/title5.svg"/>

> Demo coming soon — animated GIFs (≤ 5 sec) will be added once UI is finalized

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

### Dev & QA Process

| Services                         | Validation                         | Testing                          |
| -------------------------------- | ---------------------------------- | -------------------------------- |
| ![Services](./readme/demo/services.png) | ![Validation](./readme/demo/validation.png) | ![Tests](./readme/demo/tests.png) |

- PHPUnit for backend testing, Flutter test for mobile
- Code linting: Pint, ESLint, Dart Format
- Highlight: `ProductRecommendationService.php` — AI integration + Redis caching, fully unit tested

<br><br>

<!-- Deployment -->
<img src="./readme/title7.svg"/>

### Deployment Strategy

- Dockerized Laravel, React, Express (WebSockets), and Flutter apps
- CI/CD pipeline: test → build → push → deploy on EC2 via SSH
- API URL: `https://api.smartdine.app:8010`
- Health check: `GET /v1/health` → `{ \"status\": \"ok\" }`
- Postman Collection: `/docs/SmartDine.postman_collection.json`

| Auth API                         | Order API                         | AI API                            |
| -------------------------------- | ---------------------------------- | --------------------------------- |
| ![Auth](./readme/demo/postman1.png) | ![Order](./readme/demo/postman2.png) | ![AI](./readme/demo/postman3.png) |

<br><br>

Made with caffeine, good food, and a dash of AI 🤖

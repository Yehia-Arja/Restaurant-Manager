```markdown
<img src="./readme/title1.svg"/>

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg"/>

> **SmartDine** is a next-generation restaurant management system built for chains with many branches and even more hungry guests. It unifies mobile ordering, branch operations, and owner analytics under one roof—sprinkled with AI personalisation and IoT smarts.
>
> • **Flutter** mobile app (clients)  
> • **React** web dashboard (owners & admins)  
> • **Laravel** REST API + MySQL + Redis  
> • WebSockets via **Express + Socket.IO**  
> • Containers & CI with **Docker** + **GitHub Actions** + **AWS EC2**

<br><br>

<!-- System Design -->
<img src="./readme/title3.svg"/>

### Architecture Overview

* **Frontend**  
  * Flutter (client app)  
  * React (owner & admin web)

* **Backend**  
  * Laravel REST API (auth, business logic)  
  * Redis (caching & queues)  
  * MySQL (relational data)  
  * **Express + Socket.IO** (WebSockets for live order & sensor events)

* **DevOps**  
  * Docker-compose for local parity  
  * GitHub Actions pipeline → build, test, push images, deploy  
  * EC2 host pulls latest images and runs `docker-compose up -d`

> ER diagram: `readme/erd.svg`  
> Component diagram: `readme/architecture.svg`

<br><br>

<!-- Project Highlights -->
<img src="./readme/title4.svg"/>

### Key Features

* AI-powered food recommendations based on order history and taste profiles
* AR dish preview—upload a photo, get a 3D model clients can drop on their table
* Smart chair sensors stream occupancy updates, triggering cleaner alerts in real time
* Conversational AI assistant answers menu questions and guides first-time users
* Branch-level overrides for price, availability, and description—central catalogue, local tweaks
* Real-time order board for chefs and waiters via **Express + Socket.IO**
* Role-based access (owner, manager, staff, client)

<br><br>

<!-- Admin Panel Extras -->
<img src="./readme/title4.svg"/>

### Admin Panel Duties

* Register new restaurants and assign owners
* View and audit any restaurant, branch, or menu item
* Moderate reviews and ratings across the platform
* Global analytics: sales, traffic, sensor metrics
* System-wide settings: feature flags, cache, queue monitor
* Admins **can** edit product data if absolutely needed—but only through an override panel with warnings and audit logs

<br><br>

<!-- Demo -->
<img src="./readme/title5.svg"/>

> **Demo GIFs coming soon** (≤ 5 s each). Screens are getting their final polish.

### User Screens (Mobile)

| Login screen                      | Register screen                         | Home screen                     |
| --------------------------------- | --------------------------------------- | ------------------------------- |
| ![Login](./readme/demo/login.png) | ![Register](./readme/demo/register.png) | ![Home](./readme/demo/home.png) |

### Admin Screens (Web)

| Dashboard                              | Product Management                    |
| -------------------------------------- | ------------------------------------- |
| ![Dashboard](./readme/demo/admin1.png) | ![Products](./readme/demo/admin2.png) |

<br><br>

<!-- Development & Testing -->
<img src="./readme/title6.svg"/>

### Dev & QA Process

| Services                                | Validation                                  | Testing                           |
| --------------------------------------- | ------------------------------------------- | --------------------------------- |
| ![Services](./readme/demo/services.png) | ![Validation](./readme/demo/validation.png) | ![Tests](./readme/demo/tests.png) |

* Testing tools: PHPUnit (Laravel), Flutter test, Postman tests
* State management: BLoC (Flutter), Redux (React)
* Linting: Integrated pre-commit lint checks
* Notable snippet: `ProductRecommendationService.php` uses AI calls + Redis caching and is fully unit-tested

<br><br>

<!-- Deployment -->
<img src="./readme/title7.svg"/>

### Deployment Strategy

* Docker images built for Laravel, React, Express (WebSockets), and Flutter
* GitHub Actions: CI runs tests, builds, pushes to Docker Hub
* EC2 pulls latest images, runs via `docker-compose up -d`
* Production API lives at: `https://api.smartdine.app:8010`
* Health-check: `GET /v1/health` → `{ "status": "ok" }`
* Postman collection: `/docs/SmartDine.postman_collection.json`

| Postman Auth API                    | Postman Order API                    | Postman AI API                    |
| ----------------------------------- | ------------------------------------ | --------------------------------- |
| ![Auth](./readme/demo/postman1.png) | ![Order](./readme/demo/postman2.png) | ![AI](./readme/demo/postman3.png) |

<br><br>

Made with caffeine, good food, and a dash of AI 🤖
```

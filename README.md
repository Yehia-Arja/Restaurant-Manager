<img src="./readme/title1.svg"/>

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg"/>

> **SmartDine** brings your restaurant brand to life across every branch, screen, and interaction.  
> Whether you're running one location or fifty, it transforms the chaos of operations into a connected, delightful experience.  
> Clients enjoy smoother ordering, owners stay in control, and admins manage it all from the top.  
> 
> It’s fast. It’s smart. And it’s built for restaurants ready to scale without losing their soul.

<br><br>

<!-- System Design -->
<img src="./readme/title3.svg"/>

### Architecture Overview

The client experience runs on Flutter.  
Owners and admins manage everything through a responsive React dashboard.  
Backend APIs are powered by Laravel, with Redis and MySQL under the hood.  
Express with Socket.IO handles live communication.  
Everything runs in isolated containers, orchestrated via Docker Compose and deployed using GitHub Actions on EC2.

<img src="./readme/erd.svg">

<br><br>

<!-- Project Highlights -->
<img src="./readme/title4.svg"/>

### What Makes SmartDine Special

AI suggests full combo meals tailored to each user’s taste and order history  
AR menu preview shows clients how their food looks before they order  
Live seat tracking from smart chair sensors helps users avoid the wait  
In-app assistant answers questions and guides new users through the menu  
Branch-specific overrides let owners fine-tune prices and availability  
Real-time updates keep clients informed instantly  
Every role sees exactly what they need: admin, owner, or client

<br><br>

<!-- Admin Panel Extras -->
<img src="./readme/title4.svg"/>

### Admin Control Panel

Register new restaurants and assign ownership  
View and audit any restaurant or product  
Moderate reviews and manage platform data  
Track global performance and metrics across all branches  
Control feature flags, cache, queues, and system settings  
Admin overrides are tracked and limited to safeguard owner control

<br><br>

<!-- Demo -->
<img src="./readme/title5.svg"/>

> Demo animations are coming soon. Expect short, sharp previews that show off the experience.

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

Services follow modular architecture for maintainability and clarity  
Validation logic is handled cleanly using Laravel FormRequests and DTOs  
Testing is integrated across backend, mobile, and APIs  
AI logic and Redis caching are tested in isolation with fakes  
Formatters and linters ensure consistency across every commit

<br><br>

<!-- Deployment -->
<img src="./readme/title7.svg"/>

### Deployment Pipeline

Every component is containerized and built through CI  
GitHub Actions automates testing, builds, and remote deployment  
The platform runs on EC2 with a simple `docker-compose` process  
Public API endpoint: `https://api.smartdine.app:8010`  
Health check route: `GET /v1/health` → `{ "status": "ok" }`  
Postman file: `/docs/SmartDine.postman_collection.json`

| Auth API                         | Order API                         | AI API                            |
| -------------------------------- | ---------------------------------- | --------------------------------- |
| ![Auth](./readme/demo/postman1.png) | ![Order](./readme/demo/postman2.png) | ![AI](./readme/demo/postman3.png) |

<br><br>

Built to empower clients.  
Designed for owners.  
Controlled by admins.  
That’s SmartDine.

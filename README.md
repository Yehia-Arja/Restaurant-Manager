<img src="./readme/title1.svg"/>

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg"/>

> **SmartDine** is built with modern, cloud-powered tech that’s fast, scalable, and ready to grow with you.  
Everything happens in real time — from AR-powered menus your guests explore to IoT-powered seat tracking and live insights for owners behind the scenes.  
The backend runs smooth and secure. The frontend is clean, fast, and built for an effortless experience.  
It’s designed to be easy to update, easy to scale, and hard to live without.

Under the hood, SmartDine keeps every part of your operation in sync — menus, orders, pricing, occupancy, and users — so your team can focus on delivering great service, not fighting slow systems.  
Whether you're opening a new branch or updating tonight’s specials, it’s quick, intuitive, and just works.  
Feels like magic. Powered by engineering.


<br><br>

<!-- System Design -->
<img src="./readme/title3.svg"/>

### Architecture Overview

- Client App: Built in Flutter for a fast, native experience  
- Web Dashboard: React-powered control panel for owners and admins  
- API Layer: Laravel handles authentication, business logic, and DB interaction  
- Real-Time: Express + Socket.IO for WebSocket-powered updates  
- Infrastructure: Dockerized services, deployed via GitHub Actions to AWS EC2  
- Caching & Queues: Redis is used across the stack for performance and task management

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
- Real-time updates pushed to users through WebSockets  
- Three role-based views: admin, owner, and client

<br><br>

<!-- Demo -->
<img src="./readme/title5.svg"/>

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

| Services                         | Validation                         | Testing                          |
| -------------------------------- | ---------------------------------- | -------------------------------- |
| ![Empty](./readme/demo/1440x1024.png) | ![Empty](./readme/demo/1440x1024.png) | ![Empty](./readme/demo/1440x1024.png) |

- Modular folder structure with feature-based separation  
- FormRequests and DTOs for input validation and transformation  
- PHPUnit, Flutter Test, and Postman used across layers  
- AI services and Redis caching are unit-tested in isolation  
- Pint, Dart Format, and ESLint maintain code quality

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
| ![Empty](./readme/demo/1440x1024.png) | ![Empty](./readme/demo/1440x1024.png) | ![Empty](./readme/demo/1440x1024.png) |

<br><br>

SmartDine empowers clients, equips owners, and keeps admins in control.  
This is restaurant tech done right.

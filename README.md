<img src="./readme/title1.svg"/>

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg"/>

> **SmartDine** is a cloud-powered restaurant system built for speed, scalability, and real-time operations.  
> From AR menus and AI combos to live seat tracking and admin insights — everything works instantly and in sync.  
> Clean Flutter UI. Secure Laravel backend. Real-time updates via WebSockets.  
> Built to scale. Easy to use. Feels like magic, runs like engineering ⚙️

<br><br>

<!-- System Design -->
<img src="./readme/title3.svg"/>

### Architecture Overview

✅ **Client App**: Flutter mobile app  
✅ **Web Dashboard**: React interface for admins/owners  
✅ **API Layer**: Laravel backend for business logic  
✅ **Real-Time**: Node.js + Socket.IO for WebSocket updates  
✅ **Infrastructure**: Docker + GitHub Actions → AWS EC2  
✅ **Performance**: Redis for caching and queues

#### Database Diagram

![ERD](./readme/erd.svg)

#### Component Diagram

![Components](./readme/componentsDiagram.drawio.png)

<br><br>

<!-- Project Highlights -->
<img src="./readme/title4.svg"/>

![Highlights](./readme/projectHighlight.svg)

<br><br>

<!-- Demo -->
<img src="./readme/title5.svg"/>

### User Screens (Mobile)

| Home                             | Onboarding                          | Assistant Screen                     |
| -------------------------------- | ----------------------------------- | ------------------------------------ |
| ![Home](./readme/homepage.jpg)   | ![Onboarding](./readme/onboarding_screen.jpg) | ![Assistant](./readme/empty_chatting.jpg) |

| Product Details                      | Search Page                         |                                      |
| ----------------------------------- | ----------------------------------- | ------------------------------------ |
| ![Product](./readme/product_details.jpg) | ![Search](./readme/search_page.jpg) |                                      |

### Admin Screens (Web)

| Dashboard                              | Product Management                    |
| -------------------------------------- | ------------------------------------- |
| ![Dashboard](./readme/admin1.png)      | ![Products](./readme/admin2.png)      |

<br><br>

<!-- Development & Testing -->
<img src="./readme/title6.svg"/>

### Development Flow

| Services                               | Validation                             | Testing                                |
| ------------------------------------- | -------------------------------------- | -------------------------------------- |
| ![Services](./readme/Screenshot_2025-05-21_071221.png) | ![Validation](./readme/Screenshot_2025-05-21_071627.png) | ![Test](./readme/1440x1024.png) |

🧩 Modular, feature-based folder structure  
✅ Clean validation with FormRequests + DTOs  
🧪 Tests: PHPUnit (Laravel), Flutter Test, Postman  
🧠 AI + Redis logic tested independently  
🎯 Code formatting enforced via Pint, Dart Format, ESLint

<br><br>

<!-- Deployment -->
<img src="./readme/title7.svg"/>

### Deployment Pipeline 🚀

📦 Dockerized services (Laravel, React, Express, Flutter)  
🔁 CI/CD via GitHub Actions  
🌐 Hosted on AWS EC2 (Docker Compose)  
📶 API: `https://api.smartdine.app:8010`  
📋 Health: `GET /v1/health` → `{ "status": "ok" }`  
📄 Postman collection: `/docs/SmartDine.postman_collection.json`

| Auth API                          | Order API                         | AI API                            |
| -------------------------------- | --------------------------------- | --------------------------------- |
| ![Auth](./readme/1440x1024.png)  | ![Order](./readme/1440x1024.png)  | ![AI](./readme/1440x1024.png)     |

<br><br>

SmartDine empowers clients, equips owners, and keeps admins in control.  
This is restaurant tech done right 🍴

<br><br>

## License

This project is licensed under the [MIT License](./LICENSE).

```markdown
<img src="./readme/title1.svg"/>

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg"/>

> **SmartDine** is a next‑generation restaurant management system built for chains with many branches and even more hungry guests. It unifies mobile ordering, branch operations, and owner analytics under one roof—sprinkled with AI personalisation and IoT smarts.
>
> • **Flutter** mobile app (clients)  
> • **React** web dashboard (owners & admins)  
> • **Laravel** REST API + MySQL + Redis  
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
  * Docker‑compose for local parity  
  * GitHub Actions pipeline → build, test, push images, deploy  
  * EC2 host pulls latest images and runs `docker-compose up -d`

> ER diagram: `readme/erd.svg`  
> Component diagram: `readme/architecture.svg`

<br><br>

<!-- Project Highlights -->
<img src="./readme/title4.svg"/>

### Key Features

* AI‑powered food recommendations based on order history and taste profiles
* AR dish preview—upload a photo, get a 3D model clients can drop on their table
* Smart chair sensors stream occupancy updates, triggering cleaner alerts in real time
* Conversational AI assistant answers menu questions and guides first‑time users
* Branch‑level overrides for price, availability, and description—central catalogue, local tweaks
* Real‑time order board for chefs and waiters via **Express + Socket.IO**
* Role‑based access (owner, manager, staff, client)

<br><br>

<!-- Admin Panel Extras -->
<img src="./readme/title4.svg"/>

### Admin Panel Duties

* Register new restaurants and assign owners
* Manage branches, categories, products, and tags
* Moderate reviews and ratings
* View global analytics: sales, traffic, sensor metrics
* System‑wide settings: feature flags, cache, queue monitor

<br><br>

<!-- Demo -->
<img src="./readme/title5.svg"/>

> **Demo GIFs coming soon** (≤ 5 s each). Screens are getting their final polish.

<br><br>

<!-- Development & Testing -->
<img src="./readme/title6.svg"/>

### Dev & QA Process

* Feature branches & pull‑request reviews
* PHPUnit, Flutter test suites, and Postman collections run in CI
* Highlight snippet: `app/Services/ProductRecommendationService.php`—unit‑tested with Redis fakes
* Code style enforced by Pint, Dart fmt, ESLint pre‑commit hooks

<br><br>

<!-- Deployment -->
<img src="./readme/title7.svg"/>

### Deployment Snapshot

* Images: `smartdine-api`, `smartdine-web`, `smartdine-mobile`, `smartdine-sockets`
* Pipeline: build → test → push → EC2 pull & restart
* Production API: `https://api.smartdine.app:8010`  
* Health‑check: `GET /v1/health` → `{ "status": "ok" }`
* Postman collection: `/docs/SmartDine.postman_collection.json`

<br><br>

Made with caffeine, good food, and a dash of AI 🤖
```

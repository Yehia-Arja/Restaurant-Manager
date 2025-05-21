<img src="./readme/title1.svg" />

<br><br>

<!-- project overview -->
<img src="./readme/title2.svg" />

> **SmartDine** is a cloud-powered restaurant system built for speed, scalability, and real-time operations.  
> From AR menus and AI combos to live seat tracking and AI assistant — everything works instantly and in sync.  
> Clean Flutter UI. Secure Laravel backend. Real-time updates via WebSockets.  
> Built to scale. Easy to use. Feels like magic, runs like engineering ⚙️

<br><br>

<!-- System Design -->
<img src="./readme/title3.svg" />

### Architecture Overview

✅ **Client App**: Flutter mobile app  
✅ **Admin Panel**: React.js dashboard  
✅ **API Layer**: Laravel backend for business logic  
✅ **Real-Time**: Node.js + Socket.IO for WebSocket updates  
✅ **Infrastructure**: Docker + GitHub Actions → AWS EC2  
✅ **Performance**: Redis for caching and queues

#### ER Diagram

![ER Diagram](./readme/erd.svg)

#### Component Diagram

![Component Diagram](./readme/componentsDiagram.drawio.png)

<br><br>

<!-- Admin Panel -->
<img src="./readme/title4.svg" />

### Admin Dashboard Screens

| Dashboard Overview               | Restaurant Management          | Order Analytics               |
| -------------------------------- | ------------------------------ | ----------------------------- |
| <img src="./readme/admin_dashboard.png" width="220"/> | <img src="./readme/admin_restaurants.png" width="220"/> | <img src="./readme/admin_orders.png" width="220"/> |

| Menu Management                  | Customer Insights              | Real-Time Monitoring          |
| -------------------------------- | ------------------------------ | ----------------------------- |
| <img src="./readme/admin_menu.png" width="220"/> | <img src="./readme/admin_customers.png" width="220"/> | <img src="./readme/admin_monitoring.png" width="220"/> |

### Admin Features

> - **Real-time order tracking** with live updates  
> - **Restaurant performance** analytics  
> - **Menu management** with AI-powered suggestions  
> - **Staff management** with role-based access  
> - **Customer insights** with spending patterns  

<br><br>

<!-- Project Highlights -->
<img src="./readme/title5.svg" />

<img src="./readme/projectHighlight.svg" width="100%"/>

> - Personalized dish combos powered by AI  
> - Real-time seat tracking via IoT  
> - AR-enabled menu browsing  
> - Owner dashboards for product insights and recommendations

<br><br>

<!-- Demo -->
<img src="./readme/title6.svg" />

### User Screens (Mobile)

| Home                              | Onboarding                           | Assistant                           |
| --------------------------------- | ------------------------------------ | ----------------------------------- |
| <img src="./readme/homepage.jpg" width="220"/> | <img src="./readme/onboarding_screen.jpg" width="220"/> | <img src="./readme/empty_chatting.jpg" width="220"/> |

| Product Details                         | Search Page                        | AR Dish View                        |
| --------------------------------------- | ---------------------------------- | ----------------------------------- |
| <img src="./readme/product_details.jpg" width="220"/> | <img src="./readme/search_page.jpg" width="220"/> | <img src="./readme/Burger_AR.jpg" width="220"/> |

| AI Chat UI                             |                                     |                                     |
| -------------------------------------- | ---------------------------------- | ---------------------------------- |
| <img src="./readme/chatting.jpg" width="220"/> |                                    |                                     |

### Action Demo (GIFs)

| Splash & Login                     | Home Flow                          | Search                              |
| ---------------------------------- | ---------------------------------- | ----------------------------------- |
| <img src="./readme/LoginVid.gif" width="220"/> | <img src="./readme/homeScreenVid.gif" width="220"/> | <img src="./readme/search_vid.gif" width="220"/> |

| Assistant Interaction              | AR Preview                         |                                     |
| ---------------------------------- | ---------------------------------- | ----------------------------------- |
| <img src="./readme/chatting_vid.gif" width="220"/> | <img src="./readme/AR.gif" width="220"/> |                                     |

<br><br>

<!-- Development -->
<img src="./readme/title7.svg" />

### Development Flow

> SmartDine separates logic cleanly across services and validations:
>
> - **Services:** Modular logic using service classes and sensor integrations.  
> - **Validation:** All inputs go through FormRequest validation and structured schemas.

#### Services

<img src="./readme/ProductService.png" width="500"/>

#### Validation

<img src="./readme/ProductValidation.png" width="500"/>

<br><br>

<!-- AI Integration -->
<img src="./readme/title8.svg" />

### AI-Powered Recommendations 🤖

> SmartDine uses OpenAI to personalize user experience:
>
> 1. **Prompt Parsing** – Structured schema inputs (preferences, past behavior)  
> 2. **Smart Replies** – Recommendations with confidence scores and AI reasoning  
> 3. **Redis Caching** – Cached results for fast load  
> 4. **Multi-role Support** – Personalized AI for users, chefs, and restaurant owners

#### AI Prompt Input

<img src="./readme/Prompt.png" width="500"/>

#### AI Response Output

<img src="./readme/returned_message_schema.png" width="500"/>

#### AI Demo

<img src="./readme/chatting_vid.gif" width="500"/>

<br><br>

<!-- Deployment -->
<img src="./readme/title9.svg" />

### Deployment Pipeline 🚀

> The **SmartDine** app is deployed using **AWS EC2 instances**:  
>
> - **Production**: `http://52.47.117.218`  
> - **Admin Panel**: `http://52.47.117.218/admin`  
>
> The application is **containerized using Docker** to ensure consistency across all environments.  
> **CI/CD pipelines** are implemented via **GitHub Actions**, enabling automatic testing and deployment on every push to `main`.

#### GitHub Actions Workflow

<img src="./readme/github_workflow.png" width="500"/>

#### API Health & Postman Verification

| Login API                        | Fetch Products                     | Fetch Restaurants                  |
| ------------------------------- | ---------------------------------- | ---------------------------------- |
| <img src="./readme/login_postman.png" width="220"/> | <img src="./readme/fetch_products_postman.png" width="220"/> | <img src="./readme/fetch_restaurants_postman.png" width="220"/> |

<br><br>

SmartDine empowers diners, equips restaurateurs, and elevates operations.  
This is restaurant tech done right 🍴

<br><br>

## License

This project is licensed under the [MIT License](./LICENSE)

# CargoTrace AgriLian 🌿🚢
### Highland Agro-Export Visibility Platform

[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-blue.svg)](https://php.net)
[![Tailwind CSS 4](https://img.shields.io/badge/TailwindCSS-4.x-38bdf8.svg)](https://tailwindcss.com)
[![Leaflet.js](https://img.shields.io/badge/Maps-Leaflet.js-199900.svg)](https://leafletjs.com)
[![Sanctum API](https://img.shields.io/badge/API-Laravel_Sanctum-green.svg)](https://laravel.com/docs/sanctum)
[![Tests Passing](https://img.shields.io/badge/Tests-13%20Passed-brightgreen.svg)]()

> **Final Project (UAS) - Web Programming 2**  
> **Author:** Annisa Liandes (Ayaa)  
> **Student ID / NIM:** 250180123  
> **Institution:** Universitas Malikussaleh (Unimal), Aceh  

---

## 📌 Executive Summary & Domain Context

**CargoTrace AgriLian** is a multimodal agro-commodity supply chain visibility platform tailored for high-value agricultural exports originating in the **Gayo Highlands (Aceh Tengah, Indonesia)** and destined for global ports like **Singapore** and the **Port of Rotterdam (Netherlands)**.

The hero commodity is **Specialty Arabica Gayo Coffee (Fair Trade Organic & Wine Process)** alongside highland perishables (Takengon Butter Avocado & Bird's Eye Chili). The platform bridges mountain trucking across landslide-prone corridors with ocean container transport and air express samples.

### 🗺️ End-to-End Export Corridors
1. **Takengon Warehouse (`IDTKN`)** &mdash; Origin packaging, quality inspection & phytosanitary sealing.
2. **Bireuen Mountain Transit (`IDBIR`)** &mdash; Mountain corridor safety checkpoint & weather radar monitoring.
3. **Belawan Container Terminal (`IDBLW`)** &mdash; Export customs clearance (PEB) & ocean feeder loading.
4. **Kualanamu Cargo Terminal (`KNO`)** &mdash; Priority air express for competition micro-lots.
5. **PSA Singapore Hub (`SGSIN`)** &mdash; Southeast Asia transshipment to global mother vessels.
6. **Port of Rotterdam Maasvlakte (`NLRTM`)** &mdash; Final European consignee delivery.

---

## 🏗️ Architecture & Engineering Highlights

### 1. Service Layer Design Pattern
Instead of fat controllers, business logic is decoupled into dedicated services:
- **`ShipmentService`**: Enforces strict lifecycle state machines (`CREATED` &rarr; `BOOKED` &rarr; `PICKED_UP` &rarr; `IN_TRANSIT` &rarr; `DELIVERED`). Illegal jumps (e.g. `CREATED` directly to `DELIVERED`) are strictly rejected.
- **`TrackingService`**: Records immutable chronological checkpoint milestones without mutating past event history.
- **`EtaService`**: Deterministic delay evaluator comparing estimated arrival with scheduled expected arrival, categorizing severity into `LOW` (< 6h), `MEDIUM` (6–24h), and `HIGH` (> 24h).
- **`ExceptionService`**: Handles customs holds, port congestions, and weather halts, automatically dispatching alert notifications to stakeholders.
- **`WeatherService`**: Live third-party HTTP integration with **OpenWeatherMap API** to monitor precipitation and wind hazards along mountain routes.

### 2. Role-Based Access Control (RBAC)
- **Admin (`admin`)**: Complete system overview, metrics dashboard, user management, and global audit logs.
- **Operator (`operator`)**: Dispatch cargo, advance shipment lifecycles, log checkpoint events, and report route exceptions.
- **Customer (`customer`)**: Consignee portal to track active orders, inspect container items, and receive delay notifications.

### 3. Interactive Leaflet.js Geospatial Mapping
- Real-time GPS coordinate plotting of logistics hubs.
- Dynamic route polyline connecting origin, active transit checkpoint, and destination port.
- Color-coded status markers (Emerald = On Schedule, Amber = Delayed/Alert, Indigo = Moving).

### 4. RESTful API with Laravel Sanctum
- Complete set of stateless JSON endpoints for external integration.
- Bearer token authentication via Laravel Sanctum.
- Ready-to-import Postman Collection (`cargotrace_postman_collection.json`).

---

## 🔑 Default Demo Accounts

For evaluation and testing convenience, the login page features a **One-Click Demo Switcher**:

| Role | Name | Email | Password |
| :--- | :--- | :--- | :--- |
| **Admin** | Ayaa Liandes | `admin@cargotrace.com` | `password123` |
| **Operator** | Reza Pratama (Gayo Dispatcher) | `operator@cargotrace.com` | `password123` |
| **Customer** | Amsterdam Coffee Roasters B.V. | `buyer.amsterdam@eurocoffee.nl` | `password123` |
| **Customer** | SingaAgro Fresh Singapore | `procurement@singaagro.sg` | `password123` |

---

## 🚀 Installation & Local Setup

### Prerequisites
- PHP $\ge$ 8.3 with extensions: `pdo_mysql`, `pdo_sqlite`, `curl`, `mbstring`, `zip`, `fileinfo`
- MySQL $\ge$ 8.0 (or XAMPP 8.3)
- Composer $\ge$ 2.7
- Node.js $\ge$ 20 & npm

### Setup Steps
```bash
# 1. Navigate to project root
cd D:\Projects\cargotrace

# 2. Install dependencies
composer install
npm install

# 3. Environment configuration
cp .env.example .env
php artisan key:generate

# 4. Run database migrations with sample Gayo-to-Rotterdam dataset
php artisan migrate --seed

# 5. Compile frontend assets
npm run build

# 6. Start local server
php artisan serve
```
Visit `http://127.0.0.1:8000` in your web browser.

---

## 🧪 Automated Testing Suite

The project includes unit and feature test coverage verifying authentication, service contracts, and status machines:

```bash
php artisan test
```

**Test Coverage Summary:**
- `Tests\Unit\EtaServiceTest` &bull; 4 assertions (On-time, Low delay, Medium delay, High delay severity).
- `Tests\Feature\ShipmentLifecycleTest` &bull; 3 assertions (Creation, valid transitions, illegal jump rejection).
- `Tests\Feature\AuthAndApiTest` &bull; 4 assertions (Web login, Sanctum Bearer token issue, 401 handling, public tracking API).

---

## 📡 API Endpoints Reference

| Method | Endpoint | Access | Description |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/login` | Public | Authenticate and obtain Sanctum Bearer token |
| `GET` | `/api/track/{tracking_number}` | Public | Public shipment radar & live weather lookup |
| `GET` | `/api/weather` | Public | Live OpenWeather query by coordinates |
| `GET` | `/api/me` | Bearer Token | Authenticated user profile |
| `GET` | `/api/shipments` | Bearer Token | Filterable consignment listings |
| `POST` | `/api/shipments` | Operator / Admin | Register new consignment & manifest items |
| `GET` | `/api/shipments/{id}` | Authenticated | Shipment details, items, timeline, & map |
| `POST` | `/api/shipments/{id}/status` | Operator / Admin | Advance lifecycle state |
| `POST` | `/api/shipments/{id}/events` | Operator / Admin | Log checkpoint milestone |
| `POST` | `/api/shipments/{id}/exceptions` | Operator / Admin | Report route exception & trigger delay recalculation |
| `POST` | `/api/exceptions/{id}/resolve` | Operator / Admin | Mark exception resolved with notes |

---

## 💡 Code Ownership & Design Reflection (Interview Readiness)

* **Why Service Layer over Model Hooks?**  
  Complex multi-step actions (e.g. updating shipment status also requires recording an immutable tracking event, recalculating ETA, creating user notifications, and logging an audit trace) violate Single Responsibility if placed in models. The service layer wraps these in atomic `DB::transaction` blocks.
* **Why OpenWeather integration?**  
  Highland agriculture logistics in Aceh are severely affected by mountain rainfall and flash floods. By querying real-time precipitation and wind speed when a delay is reported, cargo managers can substantiate insurance claims and provide transparent updates to international buyers.
* **Why Leaflet over Google Maps?**  
  Leaflet.js paired with OpenStreetMap provides a lightweight, open-source mapping stack that requires zero proprietary credit card billing, loads rapidly, and delivers high precision for maritime and highway coordinates.

---
*Created with pride for Gayo Agro-Export Community & Universitas Malikussaleh.*

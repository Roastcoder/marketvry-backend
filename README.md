# PHP Backend API

Complete PHP REST API for Marketvry application.

## Setup

1. **Database Setup**
```bash
mysql -u root -p < schema.sql
```

2. **Environment Configuration**
```bash
cp .env.example .env
# Edit .env with your database credentials
```

3. **Start PHP Server**
```bash
cd public
php -S localhost:8000
```

4. **Configure Frontend**
Update frontend `.env`:
```
VITE_API_URL=http://localhost:8000/api
```

## Default Admin Credentials
- Email: `admin@marketvry.com`
- Password: `admin123`

## API Endpoints

### Authentication
- `POST /api/auth/login` - Login
- `POST /api/auth/register` - Register
- `GET /api/auth/profile` - Get profile (requires auth)
- `PUT /api/auth/profile` - Update profile (requires auth)
- `POST /api/auth/avatar` - Upload avatar (requires auth)

### Service Requests
- `POST /api/service-requests` - Create service request

### Admin (requires admin role)
- `GET /api/admin/users` - List users
- `DELETE /api/admin/users/:id` - Delete user
- `PUT /api/admin/users/:id/role` - Update user role
- `GET /api/admin/contacts` - List contacts
- `PUT /api/admin/contacts/:id` - Update contact
- `DELETE /api/admin/contacts/:id` - Delete contact
- `GET /api/admin/service-requests` - List service requests
- `PUT /api/admin/service-requests/:id` - Update service request
- `DELETE /api/admin/service-requests/:id` - Delete service request

## Directory Structure
```
backend/
├── config/
│   └── database.php
├── public/
│   ├── api/
│   │   ├── auth/
│   │   ├── admin/
│   │   ├── service-requests/
│   │   ├── helpers.php
│   │   └── index.php
│   ├── uploads/
│   └── .htaccess
├── .env
└── schema.sql
```

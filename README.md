# FiberNet Project

<img width="1268" alt="{FFB278AE-A1A1-4F1E-A9D3-F5989D170AC6}" src="https://github.com/user-attachments/assets/84532c5c-771a-4271-84d1-53df177e8057" />

A modern fiber optic network management system built with CodeIgniter 4. This application provides comprehensive tools for managing fiber optic infrastructure, monitoring network performance, and handling customer installations.

## 🚀 Features

- **Network Infrastructure Management** - Track fiber optic cables, nodes, and connection points
- **Customer Management** - Handle customer installations and service requests
- **Performance Monitoring** - Real-time network performance tracking and analytics
- **Installation Scheduling** - Manage technician schedules and installation appointments
- **Reporting Dashboard** - Comprehensive reports and data visualization
- **API Integration** - RESTful API for third-party integrations

## 📋 Requirements

- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Composer
- Web server (Apache/Nginx)
- XDebug (for development and testing)

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url> fibernet-project
   cd fibernet-project
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp env .env
   ```
   
   Edit `.env` file with your database and application settings:
   ```
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080'
   
   database.default.hostname = localhost
   database.default.database = fibernet_db
   database.default.username = your_username
   database.default.password = your_password
   ```

4. **Database setup**
   ```bash
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

5. **Start development server**
   ```bash
   php spark serve
   ```

Visit `http://localhost:8080` in your browser.

## 🧪 Testing

Comprehensive test suite is available to ensure code quality and functionality.

```bash
# Run all tests
vendor\bin\phpunit

# Run specific test directory
vendor\bin\phpunit app/Models

# Generate coverage report
vendor\bin\phpunit --coverage-html=tests/coverage/
```

For detailed testing instructions, see [tests/README.md](tests/README.md).

## 📁 Project Structure

```
fibernet-project/
├── app/
│   ├── Controllers/        # Application controllers
│   ├── Models/            # Database models
│   ├── Views/             # View templates
│   ├── Config/            # Configuration files
│   └── Helpers/           # Custom helper functions
├── public/                # Public assets (CSS, JS, images)
├── tests/                 # Test files and documentation
├── writable/              # Cache, logs, session files
└── vendor/                # Composer dependencies
```

## 🔧 Configuration

### Database Configuration
Configure your database settings in `app/Config/Database.php` or use environment variables in `.env`.

### API Configuration
API endpoints are available at `/api/v1/`. Authentication is required for most endpoints.

### Performance Optimization
- Enable caching in production environment
- Configure appropriate session storage
- Optimize database queries with indexes

## 📖 API Documentation

The API provides endpoints for:
- Network infrastructure management
- Customer data operations
- Installation scheduling
- Performance metrics retrieval

API documentation is available at `/api/docs` when running in development mode.

## 🚀 Deployment

### Production Deployment

1. **Server Requirements**
   - PHP 8.1+ with required extensions
   - MySQL/MariaDB database server
   - Web server with URL rewriting enabled

2. **Environment Setup**
   ```bash
   # Set production environment
   CI_ENVIRONMENT = production
   
   # Configure database
   database.default.hostname = your_production_host
   database.default.database = your_production_db
   ```

3. **Security Configuration**
   - Set strong encryption key
   - Configure HTTPS
   - Set appropriate file permissions
   - Enable security headers

### Docker Deployment
Docker configuration files are available for containerized deployment.

```bash
docker-compose up -d
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Run tests (`vendor\bin\phpunit`)
5. Commit your changes (`git commit -m 'Add amazing feature'`)
6. Push to the branch (`git push origin feature/amazing-feature`)
7. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write comprehensive tests for new features
- Update documentation for API changes
- Use meaningful commit messages

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🆘 Support

- **Documentation**: Check the `/docs` directory for detailed documentation
- **Issues**: Report bugs and feature requests via GitHub Issues
- **Testing**: Refer to [tests/README.md](tests/README.md) for testing guidelines

## 📊 Monitoring & Performance

- Application logs are stored in `writable/logs/`
- Performance metrics available through built-in profiler
- Database query optimization tools included

---

**Built with ❤️ using CodeIgniter 4**

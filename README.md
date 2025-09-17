# 🌐 Aastera Laravel Template

This is Aastera's official Laravel template — a production-ready base designed after years of real-world API development using Laravel.

The template adds several powerful features on top of a standard Laravel installation, aiming to streamline the development of RESTful backends and enforce clean architectural practices.

---

## ✅ Key Features

### 1. Request/Response Logging

All incoming HTTP requests and outgoing responses are automatically logged. This is useful for debugging, monitoring, and auditing.

---

### 2. Custom Artisan Command: `make:rest-api-resource`

Easily scaffold a complete RESTful resource with a single command:

```bash
php artisan make:rest-api-resource Product
```

This command automatically generates:

* Controller with full REST methods (`index`, `show`, `store`, `update`, `destroy`)
* Model
* Resource (for transforming models to JSON)
* Migration
* Seeder
* Form Request classes for validation (`StoreProductRequest`, `UpdateProductRequest`)
* REST route registration

All code is generated following best practices — ready to use, extend, and deploy.

---

### 3. Built-in Authentication Controller

The template comes with an `AuthController` preconfigured for:

* User registration
* Login
* Logout
* Password reset

The system is built with both web and mobile integrations in mind.

---

### 4. Integrated Bugsnag and Media Library Support

Already pre-installed and partially configured:

* [Bugsnag](https://www.bugsnag.com/) for error monitoring — just set your API key in `.env`.
* [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary) — with a ready-to-use `AttachmentController` for file uploads.

---

### 5. API Client Interface Contracts

A standard interface (`App\Contracts\ApiClient`) is provided to help structure API clients for external services, improving testability and consistency across your codebase.

---

### 6. Global Helpers

Define global helper functions in the `app/Helpers` directory. All files here are auto-loaded and available application-wide.

---

### 7. Aastera Folder Structure

A clean and scalable folder organization aligned with Aastera's internal architecture:

```
app/
├── Controllers/
├── Models/
├── Services/
├── Contracts/
├── Helpers/
```

This promotes a clear separation of concerns and simplifies onboarding and long-term maintenance.

---

## 🚀 Getting Started

To create a new Laravel project using this template:

```bash
dart run aastera_cli init -t laravel -n my-project-name
```

---

## ✅ Post-Install Checklist

After the project is created, follow these steps:

* Update your `.env` file (database, mail, Bugsnag API key, etc.)

* Run the database migrations:

  ```bash
  php artisan migrate
  ```

* Install other dependencies if needed

* Start building your project!

---

## 🧱 Built With

* [Laravel](https://laravel.com/)
* Years of hands-on API development by the Aastera team

---

## 🏢 About Aastera

Aastera Tecnologia is a software company building scalable and efficient solutions for web, mobile, and cloud — specializing in Flutter, Laravel, and custom AI integrations.

---

## 📫 Contact

Have questions or suggestions? Reach out to us at [contact@aastera.com](mailto:contact@aastera.com) or [jm.borges7312@gmail.com](mailto:jm.borges7312@gmail.com)

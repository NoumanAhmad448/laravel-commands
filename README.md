# Laravel Commands Package

This Laravel package provides custom Artisan commands to simplify common tasks, such as creating symbolic links, deleting files, and generating Contracts and Responses with service provider bindings.

---

## Installation

1. Install the package via Composer:
   ```bash
   composer require eren/laravel-commands
   ```

2. (Optional) Publish the package configuration file:
   ```bash
   php artisan vendor:publish --provider="Eren\LaravelCommands\Providers\LCServiceProvider"
   ```

---

## Available Commands

### 1. `storage:link-custom`

Create a symbolic link from `public/storage` to `storage/app/public`. If the link already exists, it will be skipped. Additionally, it creates an `uploads` folder if it doesn’t exist.

#### Usage
```bash
php artisan storage:link-custom
```

#### Behavior
- Creates a symbolic link: `public/storage` → `storage/app/public`.
- Creates an `uploads` folder in `storage/app` if it doesn’t exist.

---

### 2. `files:delete-all`

Delete all files from a specified directory. If no path is provided, it defaults to `storage/app/uploads`.

#### Usage
```bash
php artisan files:delete-all {path?}
```

#### Examples
- Delete files from the default `uploads` folder:
  ```bash
  php artisan files:delete-all
  ```
- Delete files from a custom path:
  ```bash
  php artisan files:delete-all /path/to/folder
  ```

#### Behavior
- Deletes all files in the specified directory.
- If no path is provided, it defaults to `storage/app/uploads`.

---

### 3. `make:contract-response`

Generate a Contract and Response class, and bind them in a service provider.

#### Usage
```bash
php artisan make:contract-response {name} {--provider=HomeController1Provider}
```

#### Examples
- Generate `AuthContract` and `AuthResponse`:
  ```bash
  php artisan make:contract-response Auth
  ```
- Specify a custom service provider:
  ```bash
  php artisan make:contract-response Auth --provider=CustomServiceProvider
  ```

#### Behavior
- Creates a Contract class in `app/Http/Contracts/{Name}Contract.php`.
- Creates a Response class in `app/Http/Responses/{Name}Response.php`.
- Binds the Contract and Response in the specified service provider (default: `HomeController1Provider`).
- If the service provider doesn’t exist, it will be created automatically.

---

## Configuration

You can customize the behavior of the package by publishing the configuration file:

1. Publish the configuration file:
   ```bash
   php artisan vendor:publish --provider="Eren\LaravelCommands\Providers\LCServiceProvider"
   ```

2. Update the configuration file located at `config/laravel-commands.php`.

---

## Testing

To run the package’s tests, use the following command:
```bash
./vendor/bin/phpunit
```
or
```bash
php artisan test
```

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Submit a pull request.

---

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Support

If you encounter any issues or have questions, please open an issue on the [GitHub repository](https://github.com/noumanahmad448/laravel-commands).


# Employee - Rejestr pracowników

Aplikacja webowa do zarządzania rejestrem pracowników, czasem pracy i powiązanymi danymi, stworzona w ramach projektu studenckiego przy użyciu frameworka Laravel.

## Stos Technologiczny (Technology Stack)

* **Framework:** Laravel 
* **Język:** PHP 
* **Baza Danych:** MariaDB
* **Frontend:**
    * Laravel Blade (System szablonów)
    * Tailwind CSS 
* **System Autentykacji:** Laravel Breeze
* **Serwer WWW:** Apache
* **Zarządzanie Zależnościami:** Composer (PHP), NPM (JavaScript)

## Instalacja i Uruchomienie (Installation & Setup)

Aby uruchomić projekt lokalnie, wykonaj następujące kroki:

1.  **Klonuj repozytorium:**
    ```bash
    git clone https://github.com/MasterFileq/employee.git
    ```
2.  **Przejdź do katalogu projektu:**
    ```bash
    cd employee
    ```
3.  **Zainstaluj zależności PHP:**
    ```bash
    composer install
    ```
4.  **Zainstaluj zależności Node.js:**
    ```bash
    npm install
    ```
5.  **Skompiluj zasoby frontendowe:**
    * Dla rozwoju (z automatycznym przeładowaniem):
        ```bash
        npm run dev
        ```
    * Dla wersji produkcyjnej:
        ```bash
        npm run build
        ```
6.  **Skopiuj plik konfiguracyjny środowiska:**
    ```bash
    cp .env.example .env
    ```
7.  **Wygeneruj klucz aplikacji:**
    ```bash
    php artisan key:generate
    ```
8.  **Skonfiguruj połączenie z bazą danych:**
    * Otwórz plik `.env` i ustaw prawidłowe wartości dla `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` i `DB_PASSWORD`.
9.  **Utwórz bazę danych:** Upewnij się, że baza danych podana w `DB_DATABASE` istnieje na Twoim serwerze bazodanowym (np. użyj phpMyAdmin, DBeaver lub komendy `CREATE DATABASE nazwa_bazy;`).
10. **Uruchom migracje:** Ta komenda utworzy strukturę tabel w bazie danych.
    ```bash
    php artisan migrate
    ```
11. **Uruchom serwer deweloperski Laravel:**
    ```bash
    php artisan serve
    ```
12. **Otwórz aplikację:** Otwórz przeglądarkę i przejdź pod adres wskazany przez komendę `serve` (domyślnie `http://127.0.0.1:8000`).


## O Frameworku Laravel (About Laravel Used in this Project)

Ten projekt został zbudowany przy użyciu Laravel - frameworka aplikacji webowych o wyrazistej, eleganckiej składni. Laravel ułatwia tworzenie aplikacji webowych, upraszczając powszechne zadania, takie jak routing, zarządzanie bazą danych (ORM Eloquent), migracje schematu, obsługa sesji, walidacja i wiele innych. Jest to framework dostępny, potężny i dostarczający narzędzi potrzebnych do budowy solidnych aplikacji.

* [Dokumentacja Laravel](https://laravel.com/docs)

## Licencja (License)

Framework Laravel jest oprogramowaniem open-source licencjonowanym na warunkach [licencji MIT](https://opensource.org/licenses/MIT).

Projekt "Employee" (kod źródłowy stworzony w ramach tego projektu) jest również udostępniany na warunkach [licencji MIT](https://opensource.org/licenses/MIT).

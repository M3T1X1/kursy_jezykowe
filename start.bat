@echo off

echo [1/5] Sprawdzanie wymagan...

echo Sprawdzanie PHP...
php --version 2>nul | findstr "PHP" && echo  PHP dostepny || (
    echo PHP niedostepny
    pause
    exit /b 1
)

echo.
echo Sprawdzanie Composer...
composer --version 2>nul | findstr "Composer" && echo  Composer dostepny || (
    echo Composer niedostepny  
    pause
    exit /b 1
)

echo.
echo Wszystkie wymagania sa spelnione!
echo.



echo Przygotowanie środowiska i instalacja zależności...

echo.
echo Sprawdzanie pliku .env...
if not exist .env (
    if exist .env.example (
        copy .env.example .env
        echo Plik .env został utworzony z .env.example
    ) else (
        echo BŁĄD: Brak pliku .env.example
        pause
        exit /b 1
    )
) else (
    echo Plik .env już istnieje
)


echo.
echo Sprawdzanie pliku .env...
if not exist .env (
    if exist .env.example (
        copy .env.example .env
        echo Plik .env został utworzony z .env.example
    ) else (
        echo BŁĄD: Brak pliku .env.example
        pause
        exit /b 1
    )
) else (
    echo Plik .env już istnieje
)

echo.
echo Generowanie klucza aplikacji...
php artisan key:generate
echo Klucz aplikacji został wygenerowany


echo.
echo Instalowanie zależności Composer...
composer install --optimize-autoloader --no-dev
if %errorlevel% neq 0 (
    echo BŁĄD: Nie można zainstalować zależności Composer
    pause
    exit /b 1
)
echo Zależności Composer zostały zainstalowane

echo.
echo Czyszczenie cache aplikacji...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo Cache został wyczyszczony

echo.
echo Generowanie cache konfiguracji...
php artisan config:cache
echo Cache konfiguracji został wygenerowany

echo.

echo.
echo Konfigurowanie bazy danych PostgreSQL...

set /p db_name="Podaj nazwę bazy danych [language_courses]: "
if "%db_name%"=="" set db_name=language_courses

set /p db_user="Podaj użytkownika bazy [postgres]: "
if "%db_user%"=="" set db_user=postgres

set /p db_password="Podaj hasło do bazy danych: "

echo.
echo Aktualizowanie pliku .env...

powershell -Command "(Get-Content .env) -replace '^DB_CONNECTION=.*', 'DB_CONNECTION=pgsql' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_HOST=.*', 'DB_HOST=127.0.0.1' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_PORT=.*', 'DB_PORT=5432' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_DATABASE=.*', 'DB_DATABASE=%db_name%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_USERNAME=.*', 'DB_USERNAME=%db_user%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_PASSWORD=.*', 'DB_PASSWORD=%db_password%' | Set-Content .env"

echo Plik .env został zaktualizowany

echo.
echo Sprawdzanie połączenia z bazą danych...
php artisan migrate:status >nul 2>&1
if %errorlevel% neq 0 (
    echo UWAGA: Nie można połączyć się z bazą danych
    echo Sprawdź czy PostgreSQL jest uruchomiony i baza '%db_name%' istnieje
    echo.
    echo Aktualne ustawienia:
    echo - Baza: %db_name%
    echo - Host: 127.0.0.1:5432
    echo - Użytkownik: %db_user%
    echo.
    echo Możesz utworzyć bazę danych komendą:
    echo createdb -U %db_user% %db_name%
    echo.
    pause
) else (
    echo Połączenie z bazą danych działa
)




echo [4/5] Automatyzacja migracji i seedowania danych...
echo - Uruchomienie migracji bazy danych
echo - Seedowanie przykladowych danych
echo - Tworzenie uzytkownikow testowych
echo.

echo [5/5] Implementacja klas Initializer...
echo - Tworzenie klas inicjalizujacych
echo - Automatyczne ladowanie danych startowych
echo - Konfiguracja systemu
echo.

echo ================================
echo   SZKIELET GOTOWY
echo ================================
echo Wszystkie kroki zostaly zaplanowane.
echo W kolejnych commitach beda implementowane.
echo.
pause

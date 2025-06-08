echo [1/5] Sprawdzanie wymagan systemowych...

echo.
echo Sprawdzanie PHP...
php --version 2>nul | findstr "PHP" && echo PHP dostepny || (
    echo BLAD: PHP nie jest zainstalowane
    pause
    exit /b 1
)

echo.
echo Sprawdzanie Composer...
composer --version 2>nul | findstr "Composer" && echo Composer dostepny || (
    echo BLAD: Composer nie jest zainstalowany
    pause
    exit /b 1
)

echo.
echo Sprawdzanie PowerShell...
powershell -Command "Write-Host 'PowerShell dziala'" 2>nul && echo PowerShell dostepny || (
    echo BLAD: PowerShell nie jest dostepny
    pause
    exit /b 1
)

echo.
echo Wszystkie wymagania sa spelnione!
echo.

echo [2/5] Przygotowanie srodowiska...

echo.
echo Sprawdzanie pliku .env...
if not exist .env (
    if exist .env.example (
        copy .env.example .env
        echo Plik .env zostal utworzony z .env.example
    ) else (
        echo BLAD: Brak pliku .env.example
        pause
        exit /b 1
    )
) else (
    echo Plik .env juz istnieje
)

echo.
echo Sprawdzanie uprawnien plikow...
if exist .env (
    attrib -r .env 2>nul
    icacls .env /grant %USERNAME%:F >nul 2>&1
)
echo Uprawnienia zostaly skonfigurowane

echo.
echo Generowanie klucza aplikacji...
php artisan key:generate
echo Klucz aplikacji zostal wygenerowany

echo.
echo.
echo [3/5] Instalacja zaleznosci...

echo.
echo Instalowanie zaleznosci Composer...
call composer install --optimize-autoloader 
if %errorlevel% neq 0 (
    echo BLAD: Nie mozna zainstalowac zaleznosci Composer
    pause
    exit /b 1
)
echo Zaleznosci Composer zostaly zainstalowane

echo.
echo Czyszczenie cache aplikacji...
call php artisan config:clear
call php artisan cache:clear  
call php artisan route:clear
call php artisan view:clear
echo Cache wyczyszczony

echo.
echo Generowanie cache konfiguracji...
call php artisan config:cache
echo Cache konfiguracji zostal wygenerowany

echo.
echo [4/5] Konfiguracja bazy danych...

echo.
echo Konfigurowanie PostgreSQL...
echo Domyslne ustawienia:
echo - Baza danych: language_courses
echo - Host: 127.0.0.1:5432
echo - Uzytkownik: postgres

set /p db_password="Podaj haslo do bazy danych (lub Enter dla pustego): "

echo.
echo Aktualizowanie pliku .env...

powershell -Command "(Get-Content .env) -replace '^DB_CONNECTION=.*', 'DB_CONNECTION=pgsql' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_HOST=.*', 'DB_HOST=127.0.0.1' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_PORT=.*', 'DB_PORT=5432' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_DATABASE=.*', 'DB_DATABASE=language_courses' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_USERNAME=.*', 'DB_USERNAME=postgres' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace '^DB_PASSWORD=.*', 'DB_PASSWORD=%db_password%' | Set-Content .env"

echo Plik .env zostal zaktualizowany z haslem

echo.
echo Czyszczenie cache po konfiguracji bazy...
call php artisan config:clear
call php artisan cache:clear

echo.
echo [5/5] Automatyzacja migracji i seedowania danych...

echo.
echo UWAGA: Upewnij sie, ze PostgreSQL jest uruchomiony
echo i baza danych 'language_courses' istnieje
echo.
pause

echo.
echo Uruchamianie migracji bazy danych...
php artisan migrate:fresh --force
if %errorlevel% neq 0 (
    echo BLAD: Nie mozna wykonac migracji
    echo Sprawdz polaczenie z baza danych
    pause
    exit /b 1
)
echo Migracje zostaly wykonane

echo.
echo Seedowanie danych...
php artisan db:seed --force
if %errorlevel% neq 0 (
    echo BLAD: Nie mozna wykonac seedowania
    pause
    exit /b 1
)
echo Dane zostaly zaladowane
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



echo [2/5] Konfiguracja bazy danych...
echo - Sprawdzenie polaczenia z PostgreSQL
echo - Tworzenie bazy danych jesli nie istnieje
echo - Konfiguracja pliku .env
echo.

echo [3/5] Instalacja zaleznosci i przygotowanie srodowiska...
echo - Instalacja pakietow Composer
echo - Kopiowanie .env.example do .env
echo - Generowanie klucza aplikacji
echo.

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

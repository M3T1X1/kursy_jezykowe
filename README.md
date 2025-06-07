# 🌐 Projekt strony internetowej — Laravel + Blade

Prosta strona internetowa stworzona przy użyciu frameworka **Laravel** i silnika szablonów **Blade**.  
Projekt realizowany wspólnie przez nasz zespół w celach edukacyjnych i praktycznych. 🚀

---

## 📋 Spis treści

- [Opis projektu](#opis-projektu)
- [Wymagania](#wymagania)
- [Instalacja](#instalacja)
- [Struktura projektu](#struktura-projektu)
- [Uruchamianie](#uruchamianie)
- [Przydatne komendy](#przydatne-komendy)
- [Autorzy](#autorzy)

---

## 📝 Opis projektu

Projekt strony internetowej dla szkoły językowej, umożliwiającej klientom:

- rejestrację konta,
- logowanie,
- przeglądanie dostępnych kursów językowych,
- rezerwację kursów online.

Strona posiada także panel administracyjny, w którym administrator może:

- dodawać, edytować i usuwać kursy,
- zarządzać instruktorami,
- zarządzać klientami,
- tworzyć i usuwać zniżki na kursy.

Projekt został stworzony w oparciu o framework Laravel oraz system szablonów Blade.  
Strona jest w pełni responsywna i dostosowana do obsługi zarówno na komputerach, jak i urządzeniach mobilnych.

---

## Wymagania

- PHP >= 8.x
- Composer
- Laravel >= 10.x
- Serwer WWW (opcjonalnie, np. Apache / Nginx)

---

## Instalacja

1. Sklonuj repozytorium:

    W terminalu:

    git clone https:/https://github.com/M3T1X1/kursy_jezykowe/.git
    

2. Zainstaluj zależności:

    W terminalu: 

    composer install

3. Skopiuj plik środowiska:

    W terminalu: 

    cp .env.example .env

4. Wygeneruj klucz aplikacji:

    W terminalu:

    php artisan key:generate

5. Uruchom migrację bazy danych:

    W terminalu:

    php artisan migrate

## Uruchamianie

    W terminalu: 

    php artisan serve

    Domyślny adres: http://127.0.0.1:8000
---

## Struktura projektu

    /app -> logika aplikacji (kontrolery, modele)
    /bootstrap -> konfiguracja startowa
    /config -> pliki konfiguracyjne
    /database -> migracje i seedy
    /public -> katalog publiczny (index.php)
    /resources/views -> szablony Blade (.blade.php)
    /routes -> definicje routingu (web.php, api.php)
    /storage -> cache, logi, uploady
    /tests -> testy
    /vendor -> zależności Composer

## Autorzy

    Radosław Cebula
    Kacper Dusza
    Dawid Czeszek
    Karol Brudniak

## Licencja

    Projekt edukacyjny - do dowolnego użytku wewnętrznego

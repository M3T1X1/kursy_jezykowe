# Projekt Szkoła Językowa

[Repozytorium projektu](https://github.com/M3T1X1/kursy_jezykowe)

[Tablica projektowa](https://github.com/users/M3T1X1/projects/5)

---

### Temat projektu

System zarządzania szkołą językową - platforma umożliwiająca zarządzanie kursami językowymi, instruktorami, klientami oraz rezerwacjami.

---

### Zespół

| Imię i Nazwisko | Rola |
| ------ | ------ |
| Kacper Dusza | lider zespołu |
| Radosław Cebula | członek zespołu |
| Dawid Czeszek | członek zespołu |
| Karol Brudniak | członek zespołu |

---

## Opis projektu

Aplikacja służy do kompleksowego zarządzania szkołą językową. System obejmuje zarządzanie kursami różnych języków, instruktorami, klientami oraz procesem rezerwacji. Użytkownicy mogą przeglądać dostępne kursy i zapisywać się na nie. Administratorzy mają dostęp do pełnego panelu zarządzania wszystkimi aspektami szkoły.

Dostępne funkcjonalności:
* Przeglądanie dostępnych kursów językowych z podziałem na poziomy,
* System rejestracji i logowania użytkowników,
* Rezerwacja miejsc na wybrane kursy,
* Panel administracyjny do zarządzania kursami,
* Zarządzanie instruktorami,
* Zarządzanie klientami i ich danymi,
* System transakcji.
* System zniżek i promocji,
* Dashboard z podsumowaniem statystyk,
* Responsive design dostosowany do urządzeń mobilnych

### Narzędzia i technologie
* PHP 8.2
* Laravel Framework 11.x
* MySQL 8.0
* HTML5, CSS3, JavaScript
* Bootstrap 5.3.0
* Composer
* Node.js & NPM
* Git

### Uruchomienie aplikacji

Wymagania:
- PHP 8.2 lub wyższy
- Composer
- MySQL 8.0
- Node.js & NPM

```bash
# Klonowanie repozytorium
git clone [URL_REPOZYTORIUM]
cd projekt-szkola-jezykowa

# Instalacja zależności PHP
composer install

# Instalacja zależności JavaScript
npm install

# Kopiowanie i konfiguracja pliku środowiskowego
cp .env.example .env

# Wygenerowanie klucza aplikacji
php artisan key:generate

# Konfiguracja bazy danych w pliku .env
# DB_DATABASE=nazwa_bazy
# DB_USERNAME=uzytkownik
# DB_PASSWORD=haslo

# Utworzenie linku symbolicznego dla storage
php artisan storage:link

# Uruchomienie migracji i seederów
php artisan migrate:fresh --seed

# Uruchomienie serwera deweloperskiego
php artisan serve
```

Przykładowi użytkownicy aplikacji:
* administrator: anna.nowak@example.com / hasło456
* administrator: jan.kowalski@example.com / hasło123
* klient: piotr.zielinski@example.com / hasło789

### Baza danych

![Diagram ERD](./dokumentacja/erd.png)

**Główne tabele i relacje:**

**Tabela `kursy` (Kursy językowe):**
- `id_kursu` (PK) - unikalny identyfikator kursu
- `cena`, `jezyk`, `poziom` - podstawowe dane kursu  
- `data_rozpoczecia`, `data_zakonczenia` - harmonogram
- `liczba_miejsc` - limit uczestników
- `id_instruktora` (FK) - powiązanie z instruktorem
- `zdjecie` - ścieżka do obrazu kursu
- Denormalizowane dane instruktora (zachowane po soft-delete)

**Tabela `klienci` (Klienci szkoły):**
- `id_klienta` (PK) - unikalny identyfikator
- `email`, `imie`, `nazwisko` - dane osobowe
- `haslo`, `adres`, `nr_telefonu` - dodatkowe informacje
- `adres_zdjecia`, `role` - profil użytkownika

**Tabela `transakcje` (Historia płatności):**
- `id_transakcji` (PK) - unikalny identyfikator
- `id_kursu` (FK) - powiązanie z kursem
- `id_klienta` (FK) - powiązanie z klientem  
- `kurs_jezyk`, `kurs_poziom` - denormalizowane dane kursu
- `klient_imie`, `klient_nazwisko`, `klient_email` - denormalizowane dane klienta
- `cena_ostateczna`, `status`, `data` - szczegóły transakcji
- `reservation_id` (FK) - powiązanie z rezerwacją

**Tabela `reservations` (Rezerwacje):**
- `id` (PK) - unikalny identyfikator
- `imie`, `nazwisko`, `email`, `nr_telefonu` - dane rezerwującego
- `course_id` (FK) - powiązanie z kursem
- `base_price` - cena bazowa

**Tabela `znizki` (System promocji):**
- `id_znizki` (PK) - unikalny identyfikator  
- `nazwa_znizki` - nazwa promocji
- `wartosc` - wartość zniżki
- `opis` - szczegóły promocji
- `active` - status aktywności

**Tabela `klienci_znizki` (Powiązania klient-zniżka):**
- Tabela łącząca klientów ze zniżkami (many-to-many)
- `id_klienta` (FK), `id_znizki` (FK)

**Kluczowe relacje:**
- Jeden instruktor może prowadzić wiele kursów (1:N)
- Jeden kurs może mieć wiele transakcji (1:N) 
- Jeden klient może mieć wiele transakcji (1:N)
- Jeden kurs może mieć wiele rezerwacji (1:N)
- Klienci i zniżki w relacji many-to-many

## Widoki aplikacji 

<img src="./dokumentacja/Strona-Glowna.png" alt="Strona główna" width="600">
*Strona główna z losowymi kursami i instruktorami*

<img src="./dokumentacja/Login.png" alt="Strona główna" width="600">
*Strona logowania*

<img src="./dokumentacja/Register.png" alt="Strona główna" width="600">
*Strona rejestracji*

<img src="./dokumentacja/Dashboard.png" alt="Dashboard" width="600">
*Strona Dashboard*

<img src="./dokumentacja/Kursy.png" alt="Kursy" width="600">
*Strona kursów w dashboard*

<img src="./dokumentacja/Dodaj-Kurs.png" alt="KursAdd" width="600">
*Strona dodania kursu*

<img src="./dokumentacja/Edytuj-Kurs.png" alt="KursEdit" width="600">
*Strona edycji kursu*

<img src="./dokumentacja/Instruktorzy.png" alt="Instruktorzy" width="600">
*Strona instruktorów w dashboard*

<img src="./dokumentacja/Dodaj-Instruktora.png" alt="InstruktorzyAdd" width="600">
*Strona dodania instruktora*

<img src="./dokumentacja/Edytuj-Instruktora.png" alt="EdytujInstruktor" width="600">
*Strona edycji instruktora*

<img src="./dokumentacja/Klienci.png" alt="Klienci" width="600">
*Strona z klientami w dashboard*

<img src="./dokumentacja/Edytuj-Klient.png" alt="EdytujKlient" width="600">
*Strona z edycją klienta*

<img src="./dokumentacja/Register.png" alt="DodajKlient" width="600">
*Strona z dodaniem klienta*

<img src="./dokumentacja/Transakcje.png" alt="Transakcje" width="600">
*Strona z transakcjami*

<img src="./dokumentacja/Znizki.png" alt="Strona główna" width="600">
*Strona z zniżkami*

<img src="./dokumentacja/Dodaj-Znizke.png" alt="Strona główna" width="600">
*Strona z dodaniem zniżki*

<img src="./dokumentacja/Edytuj-Znizke.png" alt="Strona główna" width="600">
*Strona z edycja znizki*

## Funkcjonalności szczegółowe

### System użytkowników
- Rejestracja i logowanie
- Role: administrator, klient
- Zabezpieczenia sesji i autoryzacji

### Zarządzanie instruktorami
- CRUD z systemem soft-delete
- Upload zdjęć z automatycznym nazewnictwem
- Relacje z kursami zachowane po "usunięciu"

### System kursów
- Różne języki i poziomy zaawansowania
- Upload zdjęć kursów
- Ograniczenia miejsc
- Daty rozpoczęcia i zakończenia

### Rezerwacje i płatności
- System rezerwacji z walidacją miejsc
- Historia transakcji
- Integracja z systemem zniżek

### Panel administracyjny
- Dashboard z kluczowymi statystykami
- Filtry i wyszukiwanie w tabelach
- Responsywny interfejs
- Eksport danych

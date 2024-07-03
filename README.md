# Symfony Blog Project

To jest instrukcja instalacji, konfiguracji i uruchomienia projektu bloga opartego na Symfony 7, z naciskiem na wykorzystanie Dockera.

## Wymagania wstępne

- Docker
- Docker Compose
- Git

## Instalacja i uruchomienie

### 1. Klonowanie repozytorium

```bash
git clone <adres-repozytorium>
cd <katalog-projektu>
```

### 2. Odapalanie środowiska

1.W katalogu głównym projektu, zbuduj i uruchom kontenery w terminalu
```
docker-compose up --pull always -d --wait
```
2. Po zbudowaniu się kontenerów wpisz w terminalu
```
docker ps
```
   powinieneś zobaczyć coś takiego
   
![image](https://github.com/LiptonAkaSaga/symfony-docker/assets/137857453/65869220-b4da-4591-a780-dddaa0302745)

3. Wejdź do basha następującą komendą 
```
docker exec -it symfony-docker-php-1 bash
```
4. zrób upgrade composera
```
composer upgrade
```
5. Wykonaj migracje bazy danych
```
bin/console doctrine:migrations:migrate  
```
6. Załaduj Fixtury
```
bin/console doctrine:fixtures:load 
```
## Dostęp do aplikacji

Po wykonaniu powyższych kroków, aplikacja powinna być dostępna pod adresem `http://localhost`.


## Konfiguracja Gmail SMTP

1. W pliku `.env.local` dodaj lub zmodyfikuj następującą zmienną:
   ```
   MAILER_DSN=gmail://TWÓJ_EMAIL:TWOJE_HASŁO_APLIKACJI@default
   ```

2. Zastąp `TWÓJ_EMAIL` swoim adresem Gmail, a `TWOJE_HASŁO_APLIKACJI` hasłem aplikacji wygenerowanym w ustawieniach bezpieczeństwa konta Google.

3. Aby wygenerować hasło aplikacji:
   - Przejdź do ustawień konta Google
   - Wybierz "Bezpieczeństwo"
   - Włącz weryfikację dwuetapową (jeśli nie jest włączona)
   - W sekcji "Hasła do aplikacji" wygeneruj nowe hasło dla swojej aplikacji
     
## Tworzenie użytkownika

Aby utworzyć nowego użytkownika w bashu, użyj poniższej komendy: 

```bash
bin/console app:create-user email@example.com hasło
```

## Uruchamianie testów

Aby uruchomić testy w środowisku Docker:

```bash
./vendor/bin/phpunit
```

## Zatrzymywanie i czyszczenie

Aby zatrzymać kontenery:

```bash
docker compose down --remove-orphan
```

## Dodatkowe informacje

- Projekt używa PostgreSQL jako bazy danych.
- JWT jest używane do uwierzytelniania API.
- Formularz kontaktowy wysyła e-maile za pomocą SMTP Gmail.

W razie dalszych pytań lub problemów, proszę o kontakt lub utworzenie nowego issue w repozytorium projektu.

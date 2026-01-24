# Laravel JSON API – gyakorlóprojekt

Ez a projekt egy **Laravel-alapú, tisztán JSON API**, amelynek célja a modern backend API-gondolkodás, validáció és egységes hibakezelés gyakorlása.

A Laravel itt **nem weboldalként**, hanem **API-ként** működik.

---

## Célok

- Laravel használata mint JSON API
- Egységes response contract (success / error)
- FormRequest alapú validáció
- Globális error kezelés (422 / 404 / 500)
- Vékony controller logika
- Portfólióbarát projektstruktúra

---

## Indítás

1. Függőségek telepítése  
composer install

2. Környezeti fájl létrehozása  
.env.example másolása .env néven

3. Alkalmazáskulcs generálása  
php artisan key:generate

4. Fejlesztői szerver indítása  
php artisan serve

Az API alapértelmezetten a http://localhost:8000 címen érhető el.

---

## API Response Contract

### Sikeres válasz

Minden sikeres válasz ugyanebben a struktúrában érkezik:

```
{
  "ok": true,
  "data": ...,
  "meta": {
    "timestamp": "ISO-8601 dátum"
  }
}
```

---

### Hiba válasz

Minden hiba egységes formátumban tér vissza:

```
{
  "ok": false,
  "error": {
    "code": "ERROR_CODE",
    "message": "Human readable message",
    "details": { ... }   // opcionális
  },
  "meta": {
    "timestamp": "ISO-8601 dátum"
  }
}
```

---

## Endpointok

### GET /api/ping

Egyszerű healthcheck endpoint.

Válasz példa:

```
{
  "ok": true,
  "data": "pong",
  "meta": {
    "timestamp": "..."
  }
}
```

---

### POST /api/echo

Visszaadja a validált request body-t.

Elvárt request JSON:

```
{
  "message": "string",
  "tags": ["string", "string"]
}
```

Sikeres válasz példa:

```
{
  "ok": true,
  "data": {
    "message": "hello",
    "tags": ["a", "b"]
  },
  "meta": {
    "timestamp": "..."
  }
}
```

---

## Validáció

A POST /api/echo endpoint FormRequestet használ.

Szabályok:
- message: kötelező string (1–255 karakter)
- tags: opcionális array
- tags.*: string

---

## Hibakezelés

### 422 – Validációs hiba

Ha a validáció elbukik:

```
{
  "ok": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Invalid request data",
    "details": {
      "message": ["The message field is required."]
    }
  },
  "meta": {
    "timestamp": "..."
  }
}
```

---

### 404 – Nem létező útvonal

```
{
  "ok": false,
  "error": {
    "code": "NOT_FOUND",
    "message": "Route not found"
  },
  "meta": {
    "timestamp": "..."
  }
}
```

---

### 500 – Nem várt hiba

```
{
  "ok": false,
  "error": {
    "code": "INTERNAL_ERROR",
    "message": "Internal server error"
  },
  "meta": {
    "timestamp": "..."
  }
}
```

---

## Technikai megjegyzések

- Validáció: FormRequest (EchoRequest)
- Response: központi ApiResponse helper
- Exception mapping: globálisan, bootstrap/app.php-ban
- Controller logika minimális
- API-first szemlélet
PHPersSilesia17
===============

Oprogramowanie potrzebne do uruchomienia przykładów
------------
- Docker
- Docker Compose

Uruchomienie przykładów:
```bash
    docker-compose up -d
```

Po wystartowaniu dockera możemy już korzystać z większości przykładów w pliku `requests.http`

Plik `requests.http` można otworzyć w PhpStorm lub w VS Code z zainstalowanym rozszerzeniem REST Client: https://marketplace.visualstudio.com/items?itemName=humao.rest-client

Aby przetestować przykłady w postaci plików PHP należy wykonać następujące kroki:

```bash
    docker-compose exec php bash
    composer install
    php prepare_index.php
    php -S 0.0.0.0:8000 index.php
```

##### Ważna uwaga

W Linuxie jeśli chcemy uruchomić przykłady w PHP przed wystartowaniem dockera musimy w pliku `docker-compose.yml` zmodyfikować dwie linijki:

```bash
USER_ID: 1000
GROUP_ID: 1000
```

Jako wartość `USER_ID` podajemy wartość którą zwróci komenda `id -u`
Jako wartość `GROUP_ID` podajemy wartość którą zwróci komenda `id -g`
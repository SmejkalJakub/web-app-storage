# Druhý WAP Projekt - Zásilkárna

Tento dokument slouží pro popis spuštění projektu.
Pro popis projektu čtěte dokumentace.pdf.

## Prerekvizity
- php
- databáze na adrese 127.0.0.1:3306 s databází Storage a uživatelem storage s heslem admin, který má práva do databáze Storage
- composer
- laravel
 
## Instalace
### Windows
Pro instalaci composer na windows je možné využít instalační soubor a následující návod https://www.geeksforgeeks.org/how-to-install-php-composer-on-windows/.

Pro instalaci Laravel lze využít příkaz `composer global require "laravel/installer=~1.1"`. Následně by mělo být možné provést migrace a spustit projekt viz sekce **Spuštění**.

### Linux
Podle návodu dostupného zde: https://linuxize.com/post/how-to-install-and-use-composer-on-ubuntu-18-04/ probíhá instalace pomocí následujících příkazů:

```
sudo apt update
sudo apt install wget php-cli php-zip unzip
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
HASH="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer global require "laravel/installer=~1.1"
```

Následně by mělo být možné provést migrace a spustit projekt viz sekce **Spuštění**.

## Spuštění
Při prvním spuštění je nutné provést vytvoření tabulek pomocí příkazu `php artisan migrate`. Následně při spuštění příkazu `php artisan serve` bude aplikace spuštěna na adrese `127.0.0.1:8000`.


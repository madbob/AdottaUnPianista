## Adotta un Pianista

**Adotta un Pianista** è una piattaforma per la pubblicazione di eventi e la
raccolta delle relative prenotazioni.

Implementa un workflow molto specifico:

 * chiunque può candidare la propria abitazione ad ospitare un concerto, per
mezzo dell'apposito form pubblico
 * gli ammnistratori approvano le sedi candidate, e creano un calendario eventi
(costituito, di default, da più concerti che si svolgono in una serie di giorni
consecutivi, solitamente un sabato ed una domenica)
 * chiunque, previa registrazione ed autenticazione, può prenotarsi per
partecipare ad uno o più concerti tra quelli pubblicati

# Requisiti

* PHP >= 5.6.4
* composer ( https://getcomposer.org/ )
* un webserver ed un database

# Installazione

```
git clone https://github.com/madbob/AdottaUnPianista.git
cd AdottaUnPianista
composer install
cp .env.example .env
(editare .env con i propri parametri di accesso al database)
php artisan migrate
php artisan db:seed
php artisan key:generate
```

Le credenziali di default sono username: info@example.it, password: cippalippa

# Storia

**Adotta un Pianista** è parte dell'omonimo progetto ideato e realizzato
dall'Agenzia per lo Sviluppo Locale di San Salvario.

# Licenza

**Adotta un Pianista** è distribuito in licenza AGPLv3.

Copyright (C) 2016 Roberto Guido <info@madbob.org>.

La traduzione in italiano dei messaggi di sistema è distribuita in licenza MIT.

Copyright (C) 2016 Caouecs caouecs@caouecs.net

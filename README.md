# REDAXO eRecht24 Rechtstexte

Dieses Addon ermöglicht die einfache Integration von Rechtstexten (Impressum, Datenschutzerklärung) aus dem eRecht24 Projekt Manager in REDAXO.

>Dieses Addon wurde nicht von eRecht24 entwickelt

## Über eRecht24 
eRecht24 ist ein deutscher Anbieter bekannt für sein Angebot für rechtssichere Texte, insbesondere für Impressum und Datenschutzerklärungen, die speziell für Webseitenbetreiber, Online-Shops und Unternehmen erstellt werden. Die Plattform bietet einen Projekt-Manager, mit dem Nutzer individuelle Rechtstexte generieren und automatisch aktualisieren lassen können. Weitere Dienste und Tutorials komplettieren das Angebot auch abseits des Webs. 
Mehr Informationen unter: [https://www.e-recht24.de](https://www.e-recht24.de)


## Features

- Aktualisierung der Texte via Push API von eRecht24
- Unterstützung mehrerer Domains
- Mehrsprachige Texte (DE/EN)
- Einfache Integration via PHP-Methoden
- Nutzung der eRecht24 SDK

## Installation

1. Im REDAXO Installer das Addon "erecht24" herunterladen.
2. Addon installieren und aktivieren.

## Einrichtung

1. Im [eRecht24 Projekt Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/) ein neues Projekt anlegen.
2. Texte für Impressum und Datenschutzerklärung über eRecht24 erstellen.
3. API-Schlüssel über das Zahnradsymbol des Projekts generieren.
4. In REDAXO unter eRecht24 Rechtstexte > Einstellungen:
   - Domain eintragen
   - API-Schlüssel einfügen
   - Speichern

## Verwendung

Die Rechtstexte werden über eine einheitliche PHP-Schnittstelle eingebunden. Jede Domain erhält eine eigene ID, die für den Abruf der Texte verwendet wird.

### Text-Typen prüfen und ausgeben

```php
// Prüfen, ob Text vorhanden ist
if (rex_erecht24::hasText($id, 'imprint')) {
    // Text ausgeben
    echo rex_erecht24::getText($id, 'imprint');
}
```

### Verfügbare Text-Typen

- `imprint` - Impressum
- `privacy_policy` - Datenschutzerklärung
- `privacy_policy_social_media` - Datenschutzerklärung Social Media

### Sprache wählen

```php
// Deutsche Version (Standard)
echo rex_erecht24::getText($id, 'imprint', 'de');

// Englische Version
echo rex_erecht24::getText($id, 'imprint', 'en');

// Prüfen, ob englische Version existiert
if (rex_erecht24::hasText($id, 'imprint', 'en')) {
    echo rex_erecht24::getText($id, 'imprint', 'en');
}
```

## Texte aktualisieren

Die Texte werden automatisch via Push-API von eRecht24 aktualisiert, sobald sie im eRecht24 Projekt Manager geändert werden.

## Mehrere Domains

Das Addon unterstützt mehrere Domains. Jede Domain benötigt:
1. Ein eigenes Projekt im eRecht24 Projekt Manager.
2. Einen eigenen API-Schlüssel.


## Rechtliche Hinweise
Die API und das SDK von eRecht24 unterliegen den API-Nutzungsbedingungen von eRecht24 GmbH & Co. KG. Weitere Informationen zur API-Nutzung finden sich im Vendor-Ordner.
REDAXO-Code-Bestadntreile fallen unter MIT-Lizenz. Api-spezifischer Code fältt unter der eRecht24 Lizenz.

## Autor

**Friends Of REDAXO**

* http://www.redaxo.org
* https://github.com/FriendsOfREDAXO

**Projektleitung**

[Thomas Skerbis](https://github.com/skerbis)

Sponsors: 

- [KLXM Crossmedia GmbH](https://klxm.de)
- [Marco Hanke](https://github.com/marcohanke)

Dank an: 

[https://www.e-recht24.de](https://www.e-recht24.de)






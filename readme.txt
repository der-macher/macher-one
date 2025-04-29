=== MACHER.one ===
Contributors: dermacher
Donate link: https://macher.one/
Tags: login, admin, dashboard, backend, customize
Requires at least: 5.6
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.2.1
Text Domain: macher-one
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

MACHER.one ist ein leichtgewichtiges WordPress-Plugin zur zentralen Verwaltung von Backend-Modulen.

== Description ==
Deutsch:  
MACHER.one ist ein leichtgewichtiges Core-Plugin zur zentralen Verwaltung von Backend-Modulen.

Das Plugin bietet ein eigenes Dashboard im WordPress-Backend, über das sich einzelne Module aktivieren, konfigurieren und verwalten lassen.  
In der aktuellen Version ist das Modul **„Backend Login“** enthalten, mit dem sich das Login-Formular visuell anpassen lässt (Logo, Farben, Box-Layout, Willkommensnachricht, Login-Verhalten).

Weitere Funktionen:
* Tab-basiertes Einstellungsmenü
* Global oder Plugin-intern ladbare Font Awesome Icons
* DSGVO-konform – keine externen Ressourcen
* Mehrsprachige Eingabefelder (DE, EN)
* Valide Ausgabe, escaping & sanitizing WordPress-konform

MACHER.one ist vollständig mehrsprachig vorbereitet und modular erweiterbar.

---

English:  
MACHER.one is a lightweight core plugin for centrally managing backend modules.

It provides a dedicated dashboard in the WordPress admin area to activate, configure, and manage individual modules.  
The current version includes the **“Backend Login”** module, allowing you to visually customize the WordPress login screen (logo, colors, layout, welcome message, login behavior).

Additional features:
* Tab-based settings panel
* Font Awesome icons optionally loaded globally or plugin-only
* GDPR-compliant – no external resources
* Multilingual support for settings (DE, EN)
* Secure and standards-compliant: proper escaping and sanitization

MACHER.one is fully translation-ready and designed to scale modularly.

== Installation ==
1. Lade den Plugin-Ordner `macher-one` in das Verzeichnis `/wp-content/plugins/` hoch.  
   Upload the plugin folder `macher-one` to the `/wp-content/plugins/` directory.

2. Aktiviere das Plugin über das Menü "Plugins" in WordPress.  
   Activate the plugin through the “Plugins” menu in WordPress.

3. Ein neuer Menüpunkt "MACHER.one" erscheint im Admin-Bereich.  
   A new "MACHER.one" menu item will appear in the admin panel.

== Frequently Asked Questions ==

= DE: Was kann das Plugin aktuell? =
Aktuell enthält das Plugin das Modul **„Backend Login“**, mit dem sich das WordPress-Login individuell gestalten lässt – mit Farben, Logo, Layout-Styling und mehrsprachiger Willkommensnachricht. Zusätzlich gibt es einen globalen Einstellungsbereich für KI-bezogene Medienoptionen.

= EN: What does the plugin currently do? =
Currently, the plugin includes the **“Backend Login”** module to customize the WordPress login screen with logo, colors, styling, and multilingual welcome messages. Additionally, it offers a global settings area for AI media display options.

= DE: Ist das Plugin modular erweiterbar? =
Ja. Neue Module können sich automatisch in das Dashboard einhängen und zentral gesteuert werden.

= EN: Is the plugin modular? =
Yes. Additional modules can hook into the dashboard and be managed centrally.

= DE: Wird WooCommerce unterstützt? =
Noch nicht – geplante Erweiterungen sind bereits in Vorbereitung. Das Plugin ist aber WooCommerce-kompatibel.

= EN: Is WooCommerce supported? =
Not yet – integration is planned. The plugin is WooCommerce-compatible.

== Changelog ==

= 1.2.1 =
* Verbesserte Zustandsverwaltung für Modul-Aktivierung  
  Improved module activation logic and state handling

= 1.2.0 =
* NEU: Font Awesome kann global oder nur für das Plugin geladen werden  
  NEW: Font Awesome can be loaded globally or plugin-only  
* NEU: Tab-System im Admin zur besseren Bedienung  
  NEW: Tab layout for intuitive admin settings  
* Login-Verhalten einstellbar (Benutzername, E-Mail oder beides)  
  Configurable login behavior (username, email, or both)  
* Mehrsprachige Willkommensnachrichten (DE, EN)  
  Multilingual welcome messages (DE, EN)  
* Dynamisches Styling & Validierung des Login-Feldes  
  Dynamic login validation and label updates  
* Verbesserte Sicherheit (Nonce, escaping, sanitizing)  
  Improved security (nonce, escaping, sanitizing)  
* Kompatibilität mit WordPress Plugin Check verbessert  
  Improved compliance with WordPress Plugin Check

= 1.1.1 =
* Mehrsprachigkeit über Textdomain `macher-one` integriert  
  Translation-ready with textdomain `macher-one`  
* Backend Login vollständig modular umgesetzt  
  Fully modular backend login module added  
* Übersetzbare Optionen und dynamisches Styling  
  Translatable options and dynamic login styling

= 1.0.0 =
* Erste Version mit Modul-System und Dashboard  
  Initial version with module system and dashboard

== Upgrade Notice ==
= 1.2.1 =
DE: Neues Einstellungsmodul für KI Medien – positioniere Hinweise global und unabhängig vom Plugin  
EN: New global “AI Media” configuration – centralized handling for future integrations

== License ==
Dieses Plugin ist unter der GPLv2 oder einer späteren Version lizenziert.  
This plugin is licensed under the GPLv2 or any later version.

<?php
/**
 * Grundeinstellungen für WordPress
 *
 * Diese Datei wird zur Erstellung der wp-config.php verwendet.
 * Du musst aber dafür nicht das Installationsskript verwenden.
 * Stattdessen kannst du auch diese Datei als „wp-config.php“ mit
 * deinen Zugangsdaten für die Datenbank abspeichern.
 *
 * Diese Datei beinhaltet diese Einstellungen:
 *
 * * Datenbank-Zugangsdaten,
 * * Tabellenpräfix,
 * * Sicherheitsschlüssel
 * * und ABSPATH.
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Datenbank-Einstellungen - Diese Zugangsdaten bekommst du von deinem Webhoster. ** //
/**
 * Ersetze datenbankname_hier_einfuegen
 * mit dem Namen der Datenbank, die du verwenden möchtest.
 */
define( 'DB_NAME', 'd03aa1d5' );

/**
 * Ersetze benutzername_hier_einfuegen
 * mit deinem Datenbank-Benutzernamen.
 */
define( 'DB_USER', 'd03aa1d5' );

/**
 * Ersetze passwort_hier_einfuegen mit deinem Datenbank-Passwort.
 */
define( 'DB_PASSWORD', 'A9ARLPBY7TK2tuzo' );

/**
 * Ersetze localhost mit der Datenbank-Serveradresse.
 */
define( 'DB_HOST', 'localhost' );

/**
 * Der Datenbankzeichensatz, der beim Erstellen der
 * Datenbanktabellen verwendet werden soll
 */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Der Collate-Type sollte nicht geändert werden.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden untenstehenden Platzhaltertext in eine beliebige,
 * möglichst einmalig genutzte Zeichenkette.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle Schlüssel generieren lassen.
 *
 * Du kannst die Schlüssel jederzeit wieder ändern, alle angemeldeten
 * Benutzer müssen sich danach erneut anmelden.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Y}|gU3<x.#fJ&j1leKB:Li-u/gI6RVz4.[Mep ^o_^IRVk@mn*/XIUA]vf6Y`[zW' );
define( 'SECURE_AUTH_KEY',  '$#L)78q.N<|9iIxjQcDTqA4vB.?vXy,JC}!15!MucYj56-8vy/.]yqnBH6)krASL' );
define( 'LOGGED_IN_KEY',    '}<A;20vcOh ~GC9JfR@?BwRH-~l;3caI-*)bvDQV1=x:Yd1KuzM{4Ya#1O.4<CW~' );
define( 'NONCE_KEY',        'tp`p}g0`u0skuk*6fDafohbTa9E=*+G]3A-W%)o,a{H*Rn } a>ulIL`zQV$i?5b' );
define( 'AUTH_SALT',        ']FTfLGj>kmc3k.:mEOA}cN_otFK:L>g(4[yv*$y,,XzE@xDDO5E O`K8j:0b.?`(' );
define( 'SECURE_AUTH_SALT', 'W!;2g8ZKZ&e{D}ob[{2NZ0o0O+1ZuNgwZeaS7`$Aw{0TT4RX{Ut_W$y-JSOxLz_W' );
define( 'LOGGED_IN_SALT',   'Bd)LE906jv5mkwe!Qnu,tMy2c`g5/Tq@{-^roL3Ib gn-T!+.Zl@27SAi;{BBJ2}' );
define( 'NONCE_SALT',       '-RV/!Y%7voZl]1fFf;w<D@<0is5`|<mGizU~tv,/u~S=lX,EX3lDvjWGdrc>R92,' );

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 * Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 * verschiedene WordPress-Installationen betreiben.
 * Bitte verwende nur Zahlen, Buchstaben und Unterstriche!
 */
$table_prefix = 'g2a_';

/**
 * Für Entwickler: Der WordPress-Debug-Modus.
 *
 * Setze den Wert auf „true“, um bei der Entwicklung Warnungen und Fehler-Meldungen angezeigt zu bekommen.
 * Plugin- und Theme-Entwicklern wird nachdrücklich empfohlen, WP_DEBUG
 * in ihrer Entwicklungsumgebung zu verwenden.
 *
 * Besuche den Codex, um mehr Informationen über andere Konstanten zu finden,
 * die zum Debuggen genutzt werden können.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Füge individuelle Werte zwischen dieser Zeile und der „Schluss mit dem Bearbeiten“ Zeile ein. */



/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß. */
/* That's all, stop editing! Happy publishing. */

/** Der absolute Pfad zum WordPress-Verzeichnis. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Definiert WordPress-Variablen und fügt Dateien ein.  */
require_once ABSPATH . 'wp-settings.php';

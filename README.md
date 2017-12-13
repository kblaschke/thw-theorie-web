# THW - Die Theorie - Website-Projekt

Dieses Repository enthält den Sourcecode der Website, die unter https://thw-theorie.de zu finden ist. Die Quellen können für den OFfline-Betrieb genutzt werden, z. B. auf Messen als Wissens-Test oder bei der THW-Grundausbildung, wenn die Desktop-Version unerwünscht ist.

### Installation

Um die Website zu betreiben, wird ein Webserver sowie mindestens PHP 5.5 mit der Erweiterung "PDO MySQL" benötigt. Mit kleineren Anpassungen kann der Code auch mit SQLite verwendet werden. Zusätzlich wird der [Datenbank-Inhalt](https://gitlab.kb-dev.net/kblaschke/thw-theorie-database) benötigt, der in einem getrennten Repository gepflegt wird.

Für den Betrieb mit Apache 2.4 liegt eine .htaccess-Datei bei, bei anderen Webservern wie z. B. nginx müssen die Rewrite-Regeln entsprechend der Server-Dokumentation angepasst werden.

### Lizenz

Der Quellcode der Website unterliegt der GNU General Public License 2. Eine Kopie der Lizenz liegt dem Repository als Markdown-Datei unter dem Namen LICENSE.md bei.
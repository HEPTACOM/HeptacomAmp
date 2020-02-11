# Release-Notes für AMP 2.0

## Großes Update auf Version 2.0
Nach einer erfolgreichen ersten Phase gehen wir nun den nächsten Schritt. Unser stark nachgefragtes Plugin `AMP` bekommt sein bisher größtes Update.

## Komplettes Refactoring
Wir haben den Code-Aufbau von Grund auf überarbeitet und jeden Teil daran verbessert, der noch nicht perfekt war. Unter anderem haben wir uns zukunftssicher nach der `neuen Pluginstruktur für Shopware 5.2+` gerichtet, um mit den neusten Features zu arbeiten.

## Das Template ist so nah am Standard wie noch nie
Wer nicht ganz genau weiß, worauf er zu achten hat, der wird mit dieser Version echte Schwierigkeiten haben, festzustellen ob er sich auf einer AMP-Seite befindet oder nicht. Durch unser vollständiges Template-Overhaul ist das Design der AMP-Seiten vom Standard kaum noch zu unterscheiden.

## Viele JS-Funktionen durch AMP-Komponenten ersetzt
AMP untersagt es, eigenes Javascript auf eine Seite zu bringen. Die Idee ist, dass man seine komplette Seite aus fertigen `AMP-Komponenten` zusammenbaut. Mithilfe dieser Komponenten war es uns möglich nahezu jedes wichtige Javascript-Feature in Shopware nachzustellen, sodass man in der Bedienung der Seite fast keinen Unterschied bemerken wird.

## Automatische Fehlerkorrektur
In der Vergangenheit kam es immer wieder vor, dass unsere Kunden Probleme mit AMP-Fehlern hatten. Grund dafür war nicht unser Plugin, sondern immer die Inhalte dieser Kunden. Wenn z.B. ein Textbaustein einen Inline-Style mit sich bringt, ist die ganze Seite nicht mehr `AMP-valide`. Wir wollten es mit unserem Plugin so einfach wie möglich machen, `AMP-valide` zu werden und darum haben wir die `automatische Fehlerkorrektur` entwickelt. Dadurch werden mögliche Fehler bereits während der Seitenaufbau stattfindet behoben.

## Automatische CSS-Komprimierung und Korrektur
AMP erlaubt zwar eigenes CSS, aber es hält sehr strenge Regeln dafür vor. Die wichtigste ist wahrscheinlich ein Dateilimit von 50.000 Bytes. Das normale Shopware-CSS ist etwa zehn mal so groß. Unsere `automatische Komprimierung` verringert rigoros die benötigte Dateigröße und prüft jede Regel darauf, ob sie für die Seite wirklich gebraucht wird. Alles was zu viel ist, wird entfernt.

## Beliebig anpassbar
Wenn Ihnen das Design nicht ausreicht oder Sie es erweitern wollen, brauchen Sie nichts weiter tun als ein neues Theme mit dem Namen `HeptacomAmp` anzulegen und dort wie gewohnt unser Template zu erweitern. Alle anderen Themes (sowie auch andere Plugins) werden von uns nicht berücksichtigt und nicht in die Erzeugung einer AMP-Seite mit einbezogen.

## Analyse-Tool: Validitäts-Check
Wenn Sie sicher gehen wollen, dass Ihre AMP-Seiten korrekt erzeugt werden, haben Sie jetzt die Möglichkeit über unser `neues Backend-Modul` einen Validitäts-Check durchzuführen. Damit können Sie alle Ihre AMP-Seiten prüfen lassen und sich eine Übersicht erzeugen lassen, wo es noch Probleme gibt. Falls Probleme gefunden werden, können Sie einen automatisch dazu generierten Report an uns schicken. Wir prüfen Ihr Problem und melden uns daraufhin mit einer Lösung.

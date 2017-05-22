create or replace view detail_rechnungen 
as
select 
	bezeichnung,
	preis,
	anzahl,
	(preis * anzahl) as 'brutto',
	datum,
	bid,
	pid,
	zid,
	gid
from bestellungen join produkt on  bestellungen.produktid = produkt.produktid;

create or replace view detail_rechnungen_ext
as
select 
		anrede,
		vorname,
		nachname,
		strasse,
		plz,
		ort,
		zahlungsart,
		sum(brutto) as 'total',
		datum,
		bid,
		gid,
		detail_rechnungen.pid as 'pid'
		from detail_rechnungen
	   join person on detail_rechnungen.pid = person.pid
	   join adresse on person.aid = adresse.aid
	   join zahlungsinfo using(zid)
	   group by
	   anrede,
		vorname,
		nachname,
		strasse,
		plz,
		ort,
		zahlungsart,
		datum,
		bid,
		pid
	   ;
				   
create view gesamt_rechnungen 
as
select 
	anrede,
	vorname,
	nachname,
	strasse,
	plz,
	ort,
	zahlungsart,
	total,
	(total - wert) as 'netto',
	datum,
	bid,
	detail_rechnungen_ext.pid as 'pid'
from detail_rechnungen_ext join gutschein using (gid);



				   
				   
;
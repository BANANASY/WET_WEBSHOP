CREATE table wi15b189_Ort (
	PLZ 		Integer,
	Ort 		varchar(32),
	primary key (PLZ)
	);

ALTER table wi15b189_Ort MODIFY Ort varchar(32) NOT NULL


CREATE table wi15b189_Adresse (
	AD_ID 		Integer 	primary key,
	Strasse 	varchar(32),
	PLZ 		Integer 	REFERENCES wi15b189_Ort (PLZ),
	Hausnummer 	Integer
	);
	
ALTER table wi15b189_Adresse MODIFY PLZ Integer NOT NULL

CREATE table wi15b189_Person (
	P_ID 		Integer,
	Vorname 	varchar(32)	NOT NULL,
	Nachname	varchar(32)	NOT NULL,
	Geschlecht 	char(1) 	NOT NULL,
	AD_ID 		Integer 	NOT NULL,
	primary key (P_ID),
	foreign key (AD_ID) REFERENCES wi15b189_Adresse(AD_ID)
	);
	
CREATE table wi15b189_Kunde (
	K_ID 		Integer,
	P_ID 		Integer 	NOT NULL UNIQUE,
	primary key (K_ID),
	foreign key (P_ID) REFERENCES wi15b189_Person(P_ID)
	);
	
/* 
	ALTER TABLE WI15B189_Mitarbeiter 
	ADD CONSTRAINT P_ID UNIQUE (P_ID);
*/
   
CREATE table wi15b189_Mitarbeiter (
	M_ID 		Integer,
	P_ID 		Integer 	NOT NULL UNIQUE,
	primary key (M_ID),
	foreign key (P_ID) REFERENCES wi15b189_Person(P_ID)
	);
	
CREATE table wi15b189_Filiale (
	"UID" 		Integer,
	Name 		varchar(32) 	NOT NULL,
	Telefon		varchar(32) 	NOT NULL,
	Fax			varchar(32) 	NOT NULL,
	AD_ID 		Integer 		NOT NULL,
	primary key ("UID"),
	foreign key (AD_ID) REFERENCES wi15b189_Adresse(AD_ID)
	);
	
CREATE table wi15b189_Produkt (
	Produkt_ID	Integer,
	Name 		varchar(32) 	NOT NULL,
	Preis		DECIMAL(*,2) 	NOT NULL,
	Mwst		DECIMAL(*,2) 	NOT NULL,
	primary key (Produkt_ID)
	);
	
CREATE table wi15b189_Rechnung (
	N_NR 		Integer,
	Zeit 		Date 			NOT NULL,
	K_ID		Integer,
	M_ID		Integer 		NOT NULL,
	"UID"		Integer 		NOT NULL,
	primary key (N_NR),
	foreign key (K_ID) 	REFERENCES wi15b189_Kunde(K_ID),
	foreign key (M_ID) 	REFERENCES wi15b189_Mitarbeiter(M_ID),
	foreign key ("UID") REFERENCES wi15b189_Filiale("UID")
	);
	
CREATE table wi15b189_Enthaelt (
	N_NR 		Integer,
	Produkt_ID 	Integer,
	Preis		DECIMAL(*,2)	NOT NULL,
	Mwst		DECIMAL(*,2)	NOT NULL,
	primary key (N_NR, Produkt_ID),
	foreign key (N_NR) 			REFERENCES wi15b189_Rechnung(N_NR),
	foreign key (Produkt_ID) 	REFERENCES wi15b189_Produkt(Produkt_ID)
	);
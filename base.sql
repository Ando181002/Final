create table Admin(
    idAdmin serial primary key,
    email varchar(255) not null unique,
    mdp varchar(255) not null
);

create table TypeTournoi(
    idTypeTournoi serial primary key,
    nomTypeTournoi varchar(255) not null unique,
    dureeMinute int not null
);

create table PeriodeProno(
    idPeriode serial primary key,
    nomPeriode varchar(255) not null,
    dateLimite int not null
);

create table Equipe(
    idEquipe serial primary key,
    nomEquipe varchar(255) not null unique,
    imageEquipe text not null
);

create table EquipeTypeTournoi(
    idEquipe int not null references Equipe(idEquipe),
    idTypeTournoi int not null references TypeTournoi(idTypeTournoi)
);

create table Tournoi(
    idTournoi serial primary key,
    nomTournoi varchar(255) not null unique,
    idTypeTournoi int not null references TypeTournoi(idTypeTournoi),
    debutTournoi date not null,
    finTournoi date,
    frais decimal(10,2) not null,
    Question text not null,
    imageTournoi text not null,
    description text not null
);

create or replace view v_tounoi as
select nomtypetournoi,t.* from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi;

create table RepartitionCagnote(
    idRepartition serial primary key,
    idTournoi int not null references Tournoi(idTournoi),
    rang1 decimal(10,2) not null,
    rang2 decimal(10,2) not null,
    rang3 decimal(10,2) not null,
    rang4 decimal(10,2) not null,
    rang5 decimal(10,2) not null
);

create table TypeMatch(
    idTypeMatch serial primary key,
    nomTypeMatch varchar(255) not null unique
);

create table Matchs(
    idMatch serial primary key,
    idTypeMatch int not null references TypeMatch(idTypeMatch),
    idTournoi int not null references Tournoi(idTournoi),
    dateMatch timestamp not null,
    finMatch timestamp not null,
    stade varchar(255) not null,
    idEquipe1 int not null references Equipe(idEquipe),
    idEquipe2 int not null references Equipe(idEquipe),
    ptResultat int not null,
    ptScore int not null,
    statut int not null
);

create table ResultatMatch(
    idResultat serial primary key,
    idMatch int not null references Matchs(idMatch),
    dateResultat timestamp not null,
    score1 int not null,
    score2 int not null
);

create table Genre(
    idgenre serial primary key,
    nomgenre varchar(100) not null unique
); 
create table Personnel(
    trigramme char(3) primary key,
    nom varchar(255) not null,
    emailPerso varchar(255) not null unique,
    mdpPerso varchar(255) not null,
    telephone char(10) not null,
    idGenre int not null references Genre(idgenre),
    dateNaissance date not null
);

create table Compte(
    idcompte serial primary key,
    trigramme char(3) not null unique,
    nom varchar(255) not null,
    email varchar(255) not null unique,
    mdp varchar(255) not null,
    telephone char(10) not null
);

create table Participant(
    idParticipant serial primary key,
    idcompte int not null references Compte(idcompte),
    idTournoi int not null references Tournoi(idTournoi),
    idEquipe1g int not null references Equipe(idEquipe),
    idEquipe2g int not null references Equipe(idEquipe),
    reponseQuestion text not null
);
ALTER TABLE participant RENAME TO participant1;

create table Participant(
    idParticipant serial primary key,
    trigramme char(3) not null references Personnel(trigramme),
    idTournoi int not null references Tournoi(idTournoi),
    idEquipe1g int not null references Equipe(idEquipe),
    idEquipe2g int not null references Equipe(idEquipe),
    reponseQuestion text not null
);

create or replace view v_tournoi_participant as
select idparticipant,t.*from participant p join tournoi t on p.idtournoi=t.idtournoi;

create table Pronostic(
    idPronostic serial primary key,
    idParticipant int not null references Participant(idParticipant),
    idMatch int not null references Matchs(idMatch),
    datePronostic timestamp not null,
    prono1 int not null,
    prono2 int not null
);

create or replace view v_idequipe_partournoi as
    SELECT idtournoi,idequipe1 AS idequipe FROM matchs
    UNION distinct
    SELECT idtournoi,idequipe2 AS idequipe FROM matchs;

create or replace view v_equipe_parTournoi as
    select v.*,nomequipe from v_idequipe_partournoi v join equipe e on v.idequipe=e.idequipe;

create or replace view V_Resultat as
    select m.idmatch,greatest(score1,score2) as score,
        CASE
            WHEN score1 > score2 THEN idequipe1
            WHEN score2 > score1 THEN idequipe2
            ELSE NULL
        END AS resultat
    from matchs m join resultatmatch r on m.idmatch=r.idmatch;

create or replace view V_Pronostic as
    select m.idmatch,ptscore,ptresultat,idparticipant,greatest(prono1,prono2) as scoreProno,
        CASE
            WHEN prono1 > prono2 THEN idequipe1
            WHEN prono2 > prono1 THEN idequipe2
            ELSE NULL
        END AS resultatProno
    from matchs m join pronostic r on m.idmatch=r.idmatch;

create or replace view v_point_parMatch as
select p.idmatch,idparticipant,
    CASE
        WHEN resultat=resultatprono THEN ptresultat
        ELSE 0
    END AS pointresultat,
	CASE
        WHEN score=scoreprono THEN ptscore
        ELSE 0
    END AS pointscore 
    from v_resultat r join v_pronostic p on r.idmatch=p.idmatch;

create or replace view v_match as
select 
	m.idmatch,m.idtournoi,m.datematch,m.finmatch,m.stade,m.statut,m.ptscore,m.ptresultat,
	CASE 
        WHEN EXTRACT(DOW FROM datematch) IN (0, 6) THEN datematch - INTERVAL '48 hours'
        ELSE datematch - INTERVAL '24 hours'
    END AS datelimite,
	e1.nomequipe AS nomequipe1, m.idequipe2,e2.nomequipe AS nomequipe2,
	p.idparticipant,
	pr.idpronostic,pr.prono1,pr.prono2,
	CASE
		WHEN idpronostic is not null THEN 1
		else 0
    END AS etat,
    rm.score1,rm.score2,
	CASE 
        WHEN pointresultat is null THEN coalesce(0,pointresultat)
        ELSE pointresultat
    END AS pointresultat,
	CASE 
        WHEN pointscore is null THEN coalesce(0,pointscore)
        ELSE pointscore
    END AS pointscore,
	e1.imageequipe AS imageequipe1,e2.imageequipe AS imageequipe2
    from matchs m
    JOIN equipe e1 ON m.idequipe1 = e1.idequipe
    JOIN equipe e2 ON m.idequipe2 = e2.idequipe
    left join participant p on m.idtournoi=p.idtournoi
    LEFT JOIN pronostic pr ON m.idmatch=pr.idmatch and pr.idparticipant=p.idparticipant
    LEFT JOIN resultatmatch rm ON m.idmatch=rm.idmatch
    LEFT JOIN v_point_parMatch vp ON m.idmatch=vp.idmatch and p.idparticipant=vp.idparticipant;

create or replace view classement as
select vp.idmatch,vp.idparticipant,(pointresultat+pointscore) as total,
	p.prono1,p.prono2
from v_point_parMatch vp
join pronostic p on vp.idmatch=p.idmatch and vp.idparticipant=p.idparticipant;

create or replace view v_matchFinal as
    select idmatch,idtournoi,idequipe1,idequipe2 from matchs m join typematch tm on m.idtypematch=tm.idtypematch where nomtypematch='finale';

create or replace view v_pointSupp as
select idparticipant,p.idtournoi,
    CASE
        WHEN idequipe1=idequipe1G and idequipe2=idequipe2G THEN 50
        ELSE 0
    END AS pointSupp
from participant p join v_matchFinal mf on p.idtournoi=mf.idtournoi;

create or replace view v_point_parTournoi as
    select idtournoi,idparticipant,sum(pointresultat) as pointresultat,sum(pointscore) as pointscore,(sum(pointresultat)+sum(pointscore)) as total 
    from v_point_parMatch v join matchs m on v.idmatch=m.idmatch 
    group by idtournoi,idparticipant;

create or replace view v_pointFinal as 
    select pt.*,pointsupp,
        CASE
            WHEN pointSupp is not null THEN total+pointsupp
            ELSE total
        END AS finale
    from v_point_parTournoi pt 
    left join v_pointSupp ps on pt.idtournoi=ps.idtournoi and pt.idparticipant=ps.idparticipant;

create or replace view v_Cagnote_ParTournoi as
    select p.idtournoi,count(idparticipant)*frais as cagnote 
    from tournoi t join participant p on t.idtournoi=p.idtournoi 
    group by p.idtournoi,frais;

create or replace view v_repartitionCagnote as
    select rc.*,cagnote,(cagnote*rang1) as montant1,(cagnote*rang2) as montant2,(cagnote*rang3) as montant3,(cagnote*rang4) as montant4,(cagnote*rang5) as montant5 from repartitionCagnote rc 
    join v_Cagnote_ParTournoi c on rc.idtournoi=c.idtournoi;

create or replace view v_recompense as
SELECT idtournoi,1 as rang,montant1 AS montant FROM v_repartitioncagnote
UNION ALL
SELECT idtournoi,2 as rang,montant2 AS montant FROM v_repartitioncagnote
UNION ALL
SELECT idtournoi,3 as rang,montant3 AS montant FROM v_repartitioncagnote
UNION ALL
SELECT idtournoi,4 as rang,montant4 AS montant FROM v_repartitioncagnote
UNION ALL
SELECT idtournoi,5 as rang,montant5 AS montant FROM v_repartitioncagnote
    --------------------------------------------------------------
create or replace view v_detail_match as
select 
	m.idtournoi,m.idmatch,m.datematch,m.finmatch,m.stade,m.statut,m.ptscore,m.ptresultat,
	CASE 
        WHEN EXTRACT(DOW FROM datematch) IN (0, 6) THEN datematch - INTERVAL '48 hours'
        ELSE datematch - INTERVAL '24 hours'
    END AS datelimite,
	m.idequipe1,e1.nomequipe AS nomequipe1, m.idequipe2,e2.nomequipe AS nomequipe2,
    rm.score1,rm.score2
	e1.imageequipe AS imageequipe1,e2.imageequipe AS imageequipe2
from matchs m
join equipe e1 on m.idequipe1=e1.idequipe
join equipe e2 on m.idequipe2=e2.idequipe
left join resultatmatch rm on m.idmatch=rm.idmatch;


create or replace view v_detail_prono as
select 
	p.idcompte,p.idparticipant,p.idtournoi,m.idmatch,
	pr.idpronostic,pr.prono1,pr.prono2,
	CASE
		WHEN pr.idpronostic is not null THEN 1
		else 0
    END AS etat
from participant p
left join matchs m on p.idtournoi=m.idtournoi
left join pronostic pr on pr.idmatch=m.idmatch

---BD evenement
create table Genre(
    idgenre serial primary key,
    nomgenre varchar(100) not null unique
);

create table Personnel(
    trigramme char(3) primary key,
    nom varchar(255) not null,
    datenaissance date not null,
    idgenre int not null references Genre(idgenre),
    emailperso varchar(255) not null unique,
    mdpPerso varchar(100) not null,
    telephone varchar(10) not null

);

create table TypeParticipant(
    idTypeParticipant serial primary key,
    nomTypeParticipant varchar not null unique
);

create table Famille(
    idFamille serial primary key,
    trigramme char(3) not null references Personnel(trigramme),
    nomfamille varchar(255) not null,
    dateNaissance date not null,
    idgenre int not null references Genre(idgenre),
    idTypeParticipant int not null references TypeParticipant(idTypeParticipant)
);

create table TypeActivite(
    idTypeActivite serial primary key,
    nomTypeActivite varchar not null unique
);

create table Activite(
    idActivite serial primary key,
    nomActivite varchar not null unique,
    idTypeActivite int not null references TypeActivite(idTypeActivite)
);

create table Lieu(
    idLieu serial primary key,
    nomLieu varchar(255) not null unique,
    imageLieu text not null,
    longitude double precision not null,
    latitude double precision not null
);

create table CategorieJoueur(
    idCategorie serial primary key,
    nomCategorie varchar(100) not null unique,
    ageMin int not null,
    ageMax int
);

create table evenement(
    idEvenement serial primary key,
    titre varchar not null unique,
    descri text,
    dateevent date not null,
    finInscription timestamp not null,
    idLieu int not null references Lieu(idLieu)
);

create table ActiviteEvent(
    idActiviteEvent serial primary key,
    idEvenement int not null references evenement(idEvenement),
    idActivite int not null references Activite(idActivite),
    nbJoueurParActivite int not null
);

create table inscription(
    idInscription serial primary key,
    idActiviteEvent int not null references ActiviteEvent(idActiviteEvent),
    dateInscription timestamp not null,
    trigramme char(3) not null references Personnel(trigramme),
    idfamille int references Famille(idfamille)
);

create or replace view inscriptionActivite as
SELECT i.idinscription,i.idactiviteevent,i.trigramme,
	   CASE
           WHEN i.idfamille IS NULL THEN 'personnel'
           ELSE 'famille'
       END AS etat,
       CASE
           WHEN i.idfamille IS NULL THEN p.nom
           ELSE f.nomfamille
       END AS nom,
	   CASE
           WHEN i.idfamille IS NULL THEN extract(year from now())-extract(year from p.datenaissance)
           ELSE extract(year from now())-extract(year from f.datenaissance)
       END AS age,
	   CASE
           WHEN i.idfamille IS NULL THEN p.idgenre
           ELSE f.idgenre
       END AS idgenre
FROM inscription i
LEFT JOIN personnel p ON i.idfamille IS NULL AND p.trigramme = i.trigramme
LEFT JOIN famille f ON i.idfamille IS NOT NULL AND f.idfamille = i.idfamille;


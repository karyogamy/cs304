CREATE TABLE Player	(
	id 			INTEGER,
	name 			CHAR(20),
	password 		CHAR(20),
	joindate 		DATE,  
	email 			VARCHAR(30),
	balance 		INTEGER,
	bday 			DATE, 
	gamept 		INTEGER,
	PRIMARY KEY	(id),
	unique			(name),
	unique			(email));
                                                        	 
CREATE TABLE Company (
	id 			INTEGER,
	name 			CHAR(20),
	password 		CHAR(20),
	joindate		DATE,  
	email 			CHAR(40),
	PRIMARY KEY	(id),
	unique			(name),
	unique			(email));

CREATE TABLE Game	(
    Hours_played 	INTEGER,
    Price 			INTEGER,
	Name 			VARCHAR(50),
   	gid 			INTEGER,
   	id 				INTEGER,
    genre 			CHAR(20),
   	ignscore 		INTEGER,
   	PRIMARY KEY		(gid),
	FOREIGN KEY 	(id) REFERENCES Company);

CREATE TABLE Giftcard 	(
	buyer_id		INTEGER,
	rid			INTEGER,
	cid 			INTEGER,
	amount 		NUMBER(*,1),
	expiry 			DATE,
	redeem_date		DATE,
	PRIMARY KEY 	(cid),
	FOREIGN KEY (buyer_id)     REFERENCES Player (id),
	FOREIGN KEY (rid)		REFERENCES Player (id));
	
CREATE TABLE Has_Achievement 	(
	aid 			INTEGER,
	points 			INTEGER,
	name 			VARCHAR(20),
	gid 			INTEGER,
	PRIMARY KEY	(aid),
	FOREIGN KEY	(gid) REFERENCES Game ON DELETE cascade);

CREATE TABLE Earns 	(
	id			INTEGER,
	aid			INTEGER,
	date_earned		DATE,
	PRIMARY KEY 	(id, aid),
	FOREIGN KEY	(id) REFERENCES Player ON DELETE cascade,
	FOREIGN KEY	(aid) REFERENCES Has_Achievement);

CREATE TABLE Redeem 	(
	cid			INTEGER,
	id			INTEGER,
	PRIMARY KEY 	(cid, id),
	FOREIGN KEY	(id) REFERENCES Player,
	FOREIGN KEY	(cid) REFERENCES GiftCard);

CREATE TABLE Buys_Game (
	id			INTEGER,
	gid			INTEGER,
	PRIMARY KEY	(gid, id),
	FOREIGN KEY	(id)   REFERENCES Player ON DELETE cascade,
	FOREIGN KEY	(gid) REFERENCES Game);

CREATE TABLE Save_Store	 (
	id			INTEGER,
	gid			INTEGER,
	sid			INTEGER,
	state			VARCHAR(100),
	PRIMARY KEY	(id, gid, sid),
	FOREIGN KEY	(id)   REFERENCES Player ON DELETE cascade,
	FOREIGN KEY	(gid) REFERENCES Game ON DELETE cascade);

CREATE TABLE Friends 	(
	id1 			INTEGER,
	id2 			INTEGER,
	PRIMARY KEY	(id1, id2),
	FOREIGN KEY	(id1) REFERENCES Player (id) ON DELETE cascade,
	FOREIGN KEY (id2) REFERENCES Player (id) ON DELETE cascade);

CREATE TABLE Wants 	(
	id 			INTEGER,
	gid 			INTEGER,
	PRIMARY KEY 	(id, gid),
	FOREIGN KEY	(id) REFERENCES Player,
	FOREIGN KEY	(gid) REFERENCES Game);

CREATE TABLE Ranks	(
	id			INTEGER,
	gid 			INTEGER,
	prank 			INTEGER,
	PRIMARY KEY	(id, gid),
	FOREIGN KEY 	(id) REFERENCES Player,
	FOREIGN KEY 	(gid) REFERENCES Game);	

CREATE TABLE Favorite 	(
	id 			INTEGER,
	gid 			INTEGER,
	PRIMARY KEY 	(id, gid),
	FOREIGN KEY 	(id) REFERENCES Player (id),
	FOREIGN KEY 	(gid) REFERENCES Game);

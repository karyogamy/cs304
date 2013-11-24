-- Database Table Creation
-- This fill will create the tables for our 
-- steam-like game management system

-- Author: Steamly Steamy Steamers


-- reset the state by dropping all tables
-- errors are ignored.
-- the following code generate code to drop all tables:
-- select 'drop table ' || table_name || ';' from user_table;  *
-- * http://stackoverflow.com/questions/18030140/drop-all-tables-sql-developer

drop table FRIENDS;
drop table FAVORITE;
drop table SAVE_STORE;
drop table WANTS;
drop table RANKS;
drop table REDEEM;
drop table GIFTCARD;
drop table BUYS_GAME;
drop table EARNS;
drop table HAS_ACHIEVEMENT;
drop table GAME;
drop table PLAYER;
drop table COMPANY;

-- Simplified schema
-- Player(ID,name,password,joindate,email,balance,bday,gamept)
-- Company(ID,name,password,joindate,email)
-- Game(price,name,GID,id,genre,ignscore)
-- Giftcard(buyer_id, rid, CID, amount, expiry, redeem_date)
-- Has_Achievement(AID,points,name,gid)
-- Earns(ID,AID,date_earned)
-- Redeem(CID,ID)
-- Buys_Game(ID,GID)
-- Save_Store(ID,GID,SID,state)
-- Friends(ID1,ID2)
-- Wants(ID,GID)
-- Ranks(ID,GID,prank)
-- Favorites(ID,GID)

-- create all the tables

CREATE TABLE Player (
    id              INTEGER,
    name            CHAR(20) NOT NULL,
    password        CHAR(20) NOT NULL,
    joindate        DATE     NOT NULL,  
    email           VARCHAR(30) NOT NULL,
    balance         INTEGER NOT NULL,
    bday            DATE NOT NULL, 
    gamept          INTEGER NOT NULL,
    PRIMARY KEY (id),
    CHECK (balance >= 0),
    unique          (name),
    unique          (email));
                                                             
CREATE TABLE Company (
    id              INTEGER,
    name            CHAR(20) NOT NULL,
    password        CHAR(20) NOT NULL,
    joindate        DATE NOT NULL,  
    email           CHAR(40) NOT NULL,
    PRIMARY KEY (id),
    unique          (name),
    unique          (email));

CREATE TABLE Game (
    Price           INTEGER,
    Name            VARCHAR(50) NOT NULL,
    gid             INTEGER,
    id              INTEGER NOT NULL,
    genre           CHAR(20),
    ignscore        INTEGER,
    PRIMARY KEY     (gid),
    FOREIGN KEY     (id) REFERENCES Company);

CREATE TABLE Giftcard (
    buyer_id        INTEGER,
    rid             INTEGER,
    cid             INTEGER,
    amount          NUMBER(*,1),
    expiry          DATE,
    redeem_date     DATE,
    PRIMARY KEY (cid),
    FOREIGN KEY (buyer_id)     REFERENCES Player (id),
    FOREIGN KEY (rid)          REFERENCES Player (id));

CREATE TABLE Has_Achievement (
    aid             INTEGER,
    points          INTEGER,
    name            VARCHAR(20) NOT NULL,
    gid             INTEGER NOT NULL,
    PRIMARY KEY (aid),
    FOREIGN KEY (gid) REFERENCES Game ON DELETE cascade);

CREATE TABLE Earns (
    id          INTEGER,
    aid         INTEGER,
    date_earned     DATE,
    PRIMARY KEY     (id, aid),
    FOREIGN KEY (id) REFERENCES Player ON DELETE cascade,
    FOREIGN KEY (aid) REFERENCES Has_Achievement);

CREATE TABLE Redeem (
    cid         INTEGER,
    id          INTEGER,
    PRIMARY KEY (cid, id),
    FOREIGN KEY (id) REFERENCES Player,
    FOREIGN KEY (cid) REFERENCES GiftCard);

CREATE TABLE Buys_Game (
    id          INTEGER,
    gid         INTEGER,
    PRIMARY KEY (gid, id),
    FOREIGN KEY (id)   REFERENCES Player ON DELETE cascade,
    FOREIGN KEY (gid) REFERENCES Game);

CREATE TABLE Save_Store  (
    id          INTEGER,
    gid         INTEGER,
    sid         INTEGER,
    state       VARCHAR(100),
    PRIMARY KEY (id, gid, sid),
    FOREIGN KEY (id)   REFERENCES Player ON DELETE cascade,
    FOREIGN KEY (gid) REFERENCES Game ON DELETE cascade);

CREATE TABLE Friends    (
    id1         INTEGER,
    id2         INTEGER,
    PRIMARY KEY (id1, id2),
    FOREIGN KEY (id1) REFERENCES Player (id) ON DELETE cascade,
    FOREIGN KEY (id2) REFERENCES Player (id) ON DELETE cascade);

CREATE TABLE Wants  (
    id          INTEGER,
    gid         INTEGER,
    PRIMARY KEY     (id, gid),
    FOREIGN KEY (id) REFERENCES Player,
    FOREIGN KEY (gid) REFERENCES Game);

CREATE TABLE Ranks  (
    id          INTEGER,
    gid         INTEGER,
    prank       INTEGER,
    PRIMARY KEY (id, gid),
    FOREIGN KEY     (id) REFERENCES Player,
    FOREIGN KEY     (gid) REFERENCES Game); 

CREATE TABLE Favorite   (
    id          INTEGER,
    gid         INTEGER,
    PRIMARY KEY     (id, gid),
    FOREIGN KEY     (id) REFERENCES Player,
    FOREIGN KEY     (gid) REFERENCES Game);

-- insert sample values (preset some data)

-- Player(ID,name,password,joindate,email,balance,bday,gamept)
insert into player values (0, 'gm',       '111111',       '13-10-20', 'game@master.com',   100000, '00-01-01', 999999);
insert into player values (1, 'bilibili', 'billy',        '10-01-01', 'b@b.tv',            0,      '71-01-01', 0);
insert into player values (2, 'wierdo',   '111111',       '13-10-20', 'wierdo@master.com', 100000, '00-01-01', 999999);
insert into player values (4, '4chan',    '2chan',        '02-02-20', 'rick@rolled.com',   90909,  '09-01-03', 1000);
insert into player values (100, 'Peanut', 'Butter',       '00-01-01', 'jelly@time',        0,      '10-01-02', 9191);
insert into player values (6, 'Brenda',   'Ilovech33s3',  '09-04-11', 'brenda@bred.ca',    100,    '90-04-18', 2222);
insert into player values (7, 'smartie',  '123456',       '07-04-11', 'smertie@abc.ca',    20,     '99-03-22', 1);
insert into player values (8, 'asdf',     'qwerty',       '04-01-13', 'asdf@lll.ca',       30,     '75-08-23', 0);

-- Company(ID,name,password,joindate,email)
insert into company values (0, 'Bethesda', '1', '91-01-01', 'email@email.com');
insert into company values (1, 'EA', '0@a1><~!', '00-01-01', 'whatever');
insert into company values (10, 'eafeaf', 'aaaaa', '00-01-01', 'dodododo');
insert into company values (1000, 'Black Mesa', 'pwned', '00-01-31', 'aliens@dot.com');
insert into company values (63, 'Aperture', 'Science', '14-01-01', 'Enrichment@Center.portal');

-- Game(price,name,GID,id,genre,ignscore)
insert into game values (10, 'SuperMaria', 2, 0,    'Adv',         3);
insert into game values (15, 'LaL',        4, 1,    'Strategy',    4);
insert into game values (12, 'Just Dive',  3, 10,   'Sport',       3);
insert into game values (19, 'Dinopoly',   6, 1000, 'Strategy',    3);
insert into game values (30, 'Scribble',   5, 63,   'Puz',         8);
insert into game values (39, 'MineCreep',  1, 10,   'Adv',        10);
insert into game values (1,  'CandyClush', 7, 0,    'Puz',         7);
insert into game values (3,  'Go',         8, 0,    'Puz',         1);
insert into game values (3,  'Checker',    9, 1,    'Puz',         2);
insert into game values (1,  'Jenga',     10, 0,    'Puz',         6);
insert into game values (3,  'Crossword', 11, 0,    'Puz',         8);
insert into game values (3,  'Sudoku',    12, 1,    'Puz',         7);

-- Giftcard(buyer_id, rid, CID, amount, expiry, redeem_date)
insert into giftcard values (0, 0, 0, 10000, '00-01-01', null);
insert into giftcard values (0, 1, 1, 10, '03-01-11', null);
insert into giftcard values (1,100, 2, 0, '11-11-11', null);
insert into giftcard values (2, 4, 5, 999999, '12-12-21', null);
insert into giftcard values (100, 0, 122, 53143151, '30-12-31', null);

-- Has_Achievement(AID,points,name,gid)
insert into has_achievement values (0, 10000, 'take your money', 5);
insert into has_achievement values (100, 9, 'shroom stomper', 2);
insert into has_achievement values (9999, 9999999, 'm-m-m-m-monster kill', 4);
insert into has_achievement values (5, 1, 'jailed', 6);
insert into has_achievement values (10, 10, 'dead', 3);

-- Earns(ID,AID,date_earned)
insert into Earns values (0, 0, '1970-01-01');
insert into Earns values (0, 9999, '1990-09-01');
insert into Earns values (1, 9999, '2014-1-1');
insert into Earns values (100, 100, '11-11-11');
insert into Earns values (1, 100, '11-11-11');

-- Redeem(CID,ID)
insert into redeem values (0, 0);
insert into redeem values (1, 0);
insert into redeem values (2, 0);
insert into redeem values (5, 4);
insert into redeem values (1, 1);

-- Buys_Game(ID,GID)
insert into buys_game values (0, 6);
insert into buys_game values (1, 2);
insert into buys_game values (2, 3);
insert into buys_game values (2, 4);
insert into buys_game values (2, 11);
insert into buys_game values (4, 3);
insert into buys_game values (4, 6);
insert into buys_game values (100, 5);
insert into buys_game values (1, 3);
insert into buys_game values (1, 10);
insert into buys_game values (0, 7);

-- Save_Store(ID,GID,SID,state)
insert into save_store values (0, 3, 1000, '1eaf32cba31acd');
insert into save_store values (4, 6, 0, 'hash');
insert into save_store values (4, 2, 2, 'new game');
insert into save_store values (100, 5, 124, 'save corrupted');
insert into save_store values (100, 4, 124, 'different game');

-- Friends(ID1,ID2)
insert into friends values (0, 1);
insert into friends values (0, 100);
insert into friends values (1, 100);
insert into friends values (2, 4);
insert into friends values (4, 1);

-- Wants(ID,GID)
insert into wants values (0, 6);
insert into wants values (0, 2);
insert into wants values (1, 5);
insert into wants values (2, 4);
insert into wants values (4, 5);

-- Ranks(ID,GID,prank)
insert into ranks values (0, 6, 5);
insert into ranks values (1, 2, 10);
insert into ranks values (2, 3, 7);
insert into ranks values (2, 4, 5);    
insert into ranks values (2, 11, 4);
insert into ranks values (4, 3, 9);
insert into ranks values (4, 6, 10);
insert into ranks values (100, 5, 3);
insert into ranks values (1, 3, 4); 
insert into ranks values (1, 10, 7);   
insert into ranks values (0, 7, 3)

-- Favorites(ID,GID)
insert into favorite values (0, 3);
insert into favorite values (1, 4);
insert into favorite values (2, 6);
insert into favorite values (100, 2);
insert into favorite values (100, 4);



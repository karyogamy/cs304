-- List Of queries
-- Author: Steamly Steamy Steamers

-- basic select

select * from player;
select * from company;
select * from friends;  
select * from giftcard;    
select * from redeem;
select * from games;
select * from wants;
select * from favorite;
select * from ranks;
select * from buy_game;
select * from has_achievement;
select * from earns;
select * from save_store;

--Queries regarding player

-- List games
-- require SINGLE PLAYER id, SINGLE CRITERIA STRING, SINGLE AGGREGATE SIGN
--, SINGLE CATEGORY STRING or RATING NUM or PRICE NUM
-- return LISTOF GAME id and name

--SELECT DISTINCT g.gid, g.name
--FROM		game g
--WHERE		g.'?' '?' '?';

-- Search Games
-- require SINGLE STRING, SINGLE PLAYER id
-- return LISTOF GAME id and name
-- PLACEHOLDER '%' = '%''?''%'
SELECT DISTINCT g.gid, g.name
FROM		game g
WHERE		g.name LIKE '%';


-- Order Games,
-- return LISTOF GAME id and name
-- VIEW ALREADY CREATED

--CREATE VIEW	game_avg AS
--SELECT	gid, AVG(prank) AS arank
--FROM 		Ranks r
--GROUP BY	gid;

SELECT DISTINCT	g.gid, g.name, ga.arank
FROM		game g, game_avg ga
WHERE		g.gid = ga.gid
ORDER BY	ga.arank DESC;

-- View Achievements,
-- require SINGLE PLAYER id
-- return LISTOF ACHIEVEMENT aid and a.name and a.point and game name

SELECT DISTINCT	e.aid, h.name, h.points, g.name
FROM		Has_Achievement h, Earns e, Game g
WHERE		e.id = 0 AND e.aid = h.aid AND h.gid = g.gid;

-- View Transaction Records,
-- require SINGLE PLAYER id
-- return UNIONED LISTOF id(gift_card.cid, buys_game.gid), price(gift_card.amount, game.price)

SELECT DISTINCT	'Game Card Received' AS Type, gc1.cid AS ID, gc1.amount AS Price
FROM		giftcard gc1
WHERE		gc1.rid = 0
UNION
SELECT DISTINCT	'Game Card Bought', gc2.cid, gc2.amount
FROM		giftcard gc2
WHERE		gc2.buyer_id = 0
UNION
SELECT DISTINCT	'Game Bought', g.gid, g.price
FROM		game g, buys_game b
WHERE		b.id = 0 AND g.gid = b.gid;

-- View Friends, 
-- require SINGLE PLAYER id
-- return LISTOF PLAYER id and username

SELECT DISTINCT f.id2 AS PID, p.name
FROM		friends f, player p
WHERE		f.id1 = 0 AND f.id2 <> 0 and p.id = f.id2;

-- View Friends' friends,
-- require SINGLE PLAYER id
-- return LISTOF PLAYER id and username, except self

SELECT DISTINCT f.id2 AS PID, p.name
FROM		friends f, player p
WHERE		f.id1 IN (	SELECT DISTINCT f.id2 AS id
				FROM		friends f
				WHERE		f.id1 = 0 AND f.id2 <> 0)
		AND f.id2 <> 0 AND p.id = f.id2; 

-- View Friends' games,
-- require SINGLE PLAYER id
-- return LISTOF PLAYER id and username and GAME id and name

SELECT DISTINCT p.id AS playerid, p.name as playername, g.id as hasgameid, g.name as hasgamename
FROM		friends f, player p, game g, buys_game b
WHERE		f.id1 = 0 AND f.id2 <> 0 AND p.id = f.id2 AND b.id = p.id AND g.gid = b.gid;

-- View Friends' wants,
-- reqire SINGLE PLAYER id
-- return LISTOF PLAYER id and username and GAME id and name

SELECT DISTINCT p.id AS playerid, p.name as playername, g.id as wantgameid, g.name as wantgamename
FROM		friends f, player p, game g, wants w
WHERE		f.id1 = 0 AND f.id2 <> 0 AND p.id = f.id2 AND w.id = p.id AND g.gid = w.gid;

-- View Wants,
-- require SINGLE PLAYER id
-- return LISTOF GAME id and name

SELECT DISTINCT g.gid AS gid, g.name AS name
FROM		wants w, game g
WHERE		w.id = 0 AND g.gid = w.gid;

-- FOR NESTED QUERY
-- Rating of the most popular game
-- require SINGLE AGGREGATE OPERATOR
-- return SINGLE NUMBER

SELECT 		MAX (ranking) AS maxratedgame
FROM 		(	SELECT 	AVG(prank) AS ranking
			FROM	ranks r
			GROUP BY gid);

-- Rating of the least popular game
-- require SINGLE AGGREGATE OPERATOR
-- return SINGLE NUMBER

SELECT 		MIN (ranking) AS minratedgame
FROM 		(	SELECT 	AVG(prank) AS ranking
			FROM	ranks r
			GROUP BY gid);

-- FOR JOIN QUERY
-- All saves in all games
-- return LISTOF PLAYER id name, SAVE_STORE id and state, GAME name and genre

SELECT		p.id, p.name as playername, s.sid as saveid, s.state, g.name as gamename, g.genre
FROM 		player p
INNER JOIN	save_store s ON s.id = p.id
INNER JOIN	game g ON g.gid = s.gid;

-- FOR DIVISION QUERY
-- All players that has more games than self
-- require SINGLE PLAYER id
-- returns LISTOF PLAYER id and names

SELECT		p.id, p.name
FROM		player p
WHERE		p.id IN (	SELECT 		b.id
				FROM		buys_game b
				GROUP BY	b.id
				HAVING		count(*) >	(SELECT	count(*)
				 		FROM	buys_game b1
				 		WHERE	b1.id = 0));


-- querry for company

-- view all players in games they own given company id
select b.id
from Buys_Game b, Game g
where g.gid = b.gid and g.id = COMPANY_ID

-- view ranking of all games

-- view how its players rank a game given the game id
select avg(prank)
from Ranks r
where r.gid = GAME_ID 

-- find out how many people favorite a game 
select count(id)
from Favorite f
where f.gid = GAME_ID

-- find out how many people wants a game
select count(id)
from Wants w
where w.gid = GAME_ID

-- view attributes their game
select *
from Game g
where g.id = COMPANY_ID 
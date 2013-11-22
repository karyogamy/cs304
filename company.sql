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
insert into giftcard values (0, 0, 0, 10000, '00-01-01', null);
insert into giftcard values (0, 1, 1, 10, '03-01-11', null);
insert into giftcard values (1,100, 2, 0, '11-11-11', null);
insert into giftcard values (2, 4, 5, 999999, '12-12-21', null);
insert into giftcard values (100, 3, 122, 53143151, '30-12-31', null);

insert into has_achievement values (0, 10000, 'take your money', 5);
insert into has_achievement values (100, 9, 'shroom stomper', 2);
insert into has_achievement values (9999, 9999999, 'm-m-m-m-monster kill', 4);
insert into has_achievement values (5, 1, 'jailed', 1);
insert into has_achievement values (10, 10, 'no idea what you are referring to', 3);

insert into Earns values (0, 0, '1970-01-01');
insert into Earns values (0, 9999, '1990-09-01');
insert into Earns values (1, 9999, '2014-1-1');
insert into Earns values (100, 100, '11-11-11');
insert into Earns values (1, 100, '11-11-11');

insert into redeem values (0, 0);
insert into redeem values (1, 0);
insert into redeem values (2, 0);
insert into redeem values (5, 4);
insert into redeem values (1, 1);

insert into buys_game values (0, 1);
insert into buys_game values (1, 2);
insert into buys_game values (2, 3);
insert into buys_game values (4, 4);
insert into buys_game values (100, 5);

insert into save_store values (0, 3, 1000, '1eaf32cba31acd');
insert into save_store values (4, 500, 0, 'hash');
insert into save_store values (4, 500, 2, 'new game');
insert into save_store values (100, 5, 124, 'save corrupted');
insert into save_store values (100, 50, 124, 'different game');

insert into player values (0, 'gm', '111111', '13-10-20', 'game@master.com', 100000, '00-01-01', 999999);
insert into player values (1, 'bilibili', 'billy', '10-01-01', 'b@b.tv', 0, '71-01-01', 0);
insert into player values (2, 'gm', '111111', '13-10-20', 'game@master.com', 100000, '00-01-01', 999999);
insert into player values (4, '4chan', '2chan', '02-02-20', 'rick@rolled.com', 90909, '09-01-03', 1000);
insert into player values (100, 'Peanut', 'Butter', '00-01-01', 'jelly@time', 0, '10-01-02', 9191);

insert into company values (0, 'Bethesda', '1', '91-01-01', 'email@email.com');
insert into company values (1, 'EA', '0@a1><~!', '00-01-01', 'whatever');
insert into company values (10, 'eafeaf', 'aaaaa', '00-01-01', 'dodododo');
insert into company values (1000, 'Black Mesa', 'pwned', '00-01-31', 'aliens@dot.com');
insert into company values (63, 'Aperture', 'Science', '14-01-01', 'Enrichment@Center.portal');

insert into friends values (0, 1);
insert into friends values (0, 100);
insert into friends values (1, 100);
insert into friends values (2, 4);
insert into friends values (4, 1);

insert into wants values (0, 1);
insert into wants values (0, 2);
insert into wants values (1, 5);
insert into wants values (2, 4);
insert into wants values (4, 5);

insert into ranks values (1, 2, 10);
insert into ranks values (1, 3, 4);
insert into ranks values (2, 4, 5);
insert into ranks values (2, 3, 7);
insert into ranks values (4, 1, 10);

insert into favorite values (0, 3);
insert into favorite values (1, 4);
insert into favorite values (2, 1);
insert into favorite values (100, 1);
insert into favorite values (100, 4);

insert into games values (5, 10, 'SuperMaria', 2, 'Adv', 3);
insert into games values (500, 15, 'LaL', 4, 'Strategy', 4);
insert into games values (50, 12, 'Just Dive', 3, 'sport', 3);
insert into games values (3, 19, 'Dinopoly', 1, 'Strategy', 3);
insert into games values (8, 30, 'Scribble', 5, 'Puz', 8);

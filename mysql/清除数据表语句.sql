start TRANSACTION;
set foreign_key_checks = 0;
#delete from suppliers where id<>1 ;
truncate table user_bonus_points;
select * from user_bonus_points;
commit;

set user_bonus_points = 1;

ALTER TABLE `orders`
AUTO_INCREMENT=1;

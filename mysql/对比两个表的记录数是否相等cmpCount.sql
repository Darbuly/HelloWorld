DROP PROCEDURE if EXISTS `cmpCount`;
CREATE PROCEDURE cmpCount(in `i_ltable` text ,in `i_rtable` text,out o_res int(8)) 
BEGIN
		--
		set @main_sql = CONCAT(
						'select (select count(id) from ',
						i_ltable,' ) = (select count(id) from ',
						i_rtable,' ) into @res');
		PREPARE prep_sql from @main_sql;
		execute prep_sql;
		select @res into o_res;
end;

call `cmpCount`('target.vw_users','jieyi_order_local.vw_users',@o_res);
select @o_res;
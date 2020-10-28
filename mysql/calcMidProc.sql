# 计算一个表中 某个字段的 中位数 存储过程，
# 结束之后，使用 select @mid_res 查看结果；
DROP PROCEDURE  IF EXISTS `calcMidProc`;
create PROCEDURE `calcMidProc`(`tbl_name_i` VARCHAR(20),`field_i` VARCHAR(20))
begin
	DECLARE res DOUBLE DEFAUlt 0;
SET @field = field_i;
SET @table_name = tbl_name_i;
SET @data_sql = CONCAT('SELECT avg(',@field,') into @mid_res FROM (select id, ',@field,' from (select id, @index:=@index+1 as myindex, ',@field,' from ',@table_name,', (select @index:=0) AS initvar order by ',@field,' ) as t where floor(@index/2+1)=myindex or ceil(@index/2)=myindex ) as x
');
PREPARE stmt FROM @data_sql;
EXECUTE stmt; 
select @mid_res;
end;
#call `calcMidProc`(表名,字段);
#e.g. 	call `calcMidProc`('student','valuee');
#		select @mid_res
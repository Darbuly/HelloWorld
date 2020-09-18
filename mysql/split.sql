CREATE PROCEDURE `splitString` 
(IN f_string varchar(1000),IN f_delimiter varchar(5)) 
 
BEGIN 
declare cnt int default 0; 
declare i int default 0; 
set cnt = func_get_splitStringTotal(f_string,f_delimiter); 
DROP TABLE IF EXISTS `tmp_split`; 
create temporary table `tmp_split` (`val_` varchar(128) not null) DEFAULT CHARSET=utf8;
 
while i < cnt 
do 
set i = i + 1; 
insert into tmp_split(`val_`) values (func_splitString(f_string,f_delimiter,i)); 
end while; 
END



CREATE FUNCTION `func_get_splitStringTotal`(fstring varchar(10000),fdelimiter varchar(50)) RETURNS int(11) 
BEGIN 
 return 1+( length(fstring) - length(replace(fstring,fdelimiter,'')) );
END

CREATE FUNCTION `func_splitString` 
( f_string varchar(1000),f_delimiter varchar(5),f_order int) 
RETURNS varchar(255) CHARSET utf8 
BEGIN 
 
declare result varchar(255) default ''; 
set result = reverse(substring_index(reverse(substring_index(f_string,f_delimiter,f_order)),f_delimiter,1));
return result; 
END


call `splitString`('a,s,d,f,g,h,j',','); 
SELECT * from tmp_split; 

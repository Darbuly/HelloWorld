create FUNCTION String(`str` VARCHAR(255)) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
		DETERMINISTIC
BEGIN
	DECLARE res VARCHAR(255) DEFAULT '';
	set res=concat('"',IFNULL(str,''),'"');
	RETURN res;
END ;
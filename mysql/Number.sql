create FUNCTION Number(`number` DOUBLE) RETURNS DOUBLE
		DETERMINISTIC
BEGIN
	DECLARE res DOUBLE DEFAULT 0;
	set res=IFNULL(number,0);
	RETURN res;
END ;
CREATE FUNCTION `GetObjInJArrayByIndex`(`JsonArray` TEXT, `idx` INT) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci
    DETERMINISTIC
BEGIN
        DECLARE propValStr TEXT;
        DECLARE propEndPos INT DEFAULT 0;
        DECLARE strValue VARCHAR(255);
        DECLARE propStartPos INT DEFAULT -1;
				DECLARE num INT DEFAULT 0;  
       
        SELECT INSTR(JsonArray,'[') INTO propStartPos;
        IF propStartPos <= 0 THEN
					SELECT '' INTO strValue;
        ELSE
					SELECT SUBSTRING(JsonArray,propStartPos+1) INTO propValStr;
					REPEAT
						SET num := num + 1;
						SELECT INSTR(propValStr,'{') INTO propStartPos;
						IF propStartPos <= 0 THEN
							SELECT '' INTO strValue;
							RETURN strValue;
						ELSE
							SELECT SUBSTRING(propValStr,propStartPos+1) INTO propValStr;
						END IF;
					UNTIL num > idx END REPEAT;

					SELECT INSTR(propValStr,'}') INTO propEndPos;
					IF propEndPos <= 0 THEN
						SELECT '' INTO strValue;
						RETURN strValue;
					ELSE
						SELECT SUBSTRING(propValStr, 1, propEndPos) INTO propValStr;			 
						SELECT CAST(propValStr AS CHAR) INTO strValue;
          END IF;
        END IF;

        RETURN strValue;
END
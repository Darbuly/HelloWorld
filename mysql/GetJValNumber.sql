CREATE  FUNCTION `GetJValNumber`(`JsonObject` TEXT, `propName` VARCHAR(255)) RETURNS INT
    DETERMINISTIC
BEGIN
        DECLARE propValStr TEXT;
        DECLARE propEndPos INT DEFAULT 0;
        DECLARE strValue INT DEFAULT 0;
        DECLARE propStartPos INT DEFAULT -1;
       
       
        SELECT INSTR(JsonObject,propName) INTO propStartPos;
        IF propStartPos <= 0 THEN
        SELECT 0 INTO strValue;
        ELSE
       
					SELECT propStartPos+LENGTH(propName) INTO propEndPos;
				 
					SELECT SUBSTRING(JsonObject,propEndPos) INTO propValStr;

					SELECT SUBSTRING_INDEX(propValStr,'"',1) INTO propValStr;

					if propValStr=':' then 
						SELECT SUBSTRING(JsonObject,propEndPos) INTO propValStr;
						SELECT SUBSTRING_INDEX(propValStr,'"',2) INTO propValStr;
						SELECT SUBSTRING_INDEX(propValStr,'"',-1) INTO propValStr;
					ELSE
						SELECT SUBSTRING(propValStr,2,LENGTH(propValStr)-2) INTO propValStr;
					end if;
					
				
				 
					SELECT CAST(propValStr AS SIGNED) INTO strValue;
        END IF;

        RETURN strValue;
END


select `GetJValNumber`('{"id":"668","fl":96000}','"fl"')  /** 96000

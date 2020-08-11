BEGIN
        DECLARE propValStr TEXT;
        DECLARE propEndPos INT DEFAULT 0;
        DECLARE strValue VARCHAR(255);
        DECLARE propStartPos INT DEFAULT -1;
       
       
        SELECT INSTR(JsonObject,propName) INTO propStartPos;
        IF propStartPos <= 0 THEN
        SELECT '' INTO strValue;
        ELSE
       
        SELECT propStartPos+LENGTH(propName) INTO propEndPos;

        SELECT SUBSTRING(JsonObject,propEndPos) INTO propValStr;
       
        SELECT SUBSTRING_INDEX(propValStr,'"',2) INTO propValStr;
       
        SELECT SUBSTRING_INDEX(propValStr,'"',-1) INTO propValStr;
       
        SELECT CAST(propValStr AS CHAR) INTO strValue;
        END IF;

        RETURN strValue;
END
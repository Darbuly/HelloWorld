DROP PROCEDURE IF EXISTS  `log.proc.e`;
CREATE PROCEDURE `log.proc.e`(source_i VARCHAR(255),msg_i text)
    BEGIN
    DECLARE t_error INTEGER DEFAULT 0;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;

        START TRANSACTION;
            INSERT INTO proc_logs (type,source,message)  VALUES(0,source_i,msg_i);
        IF t_error = 1 THEN
            ROLLBACK;
        ELSE
            COMMIT;
        END IF;
   select t_error;  
END;
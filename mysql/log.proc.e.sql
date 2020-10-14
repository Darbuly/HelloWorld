DROP PROCEDURE IF EXISTS  `log.proc`;
CREATE PROCEDURE `log.proc`(source_i VARCHAR(255),msg_i text)
begin
     INSERT INTO proc_logs (type,source,message)  VALUES(0,source_i,msg_i);
END;

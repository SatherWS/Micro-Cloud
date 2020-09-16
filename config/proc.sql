CREATE PROCEDURE yourinsert (vseri VARCHAR(8), vklasor INT)
BEGIN
 DECLARE i INT;
 SELECT COUNT(*) INTO i FROM yourtable WHERE seri=vseri AND klasor=vklasor;

 IF i=0 THEN
  INSERT INTO yourtable (seri,klasor) VALUES (vseri, vklasor);
 END IF;
END;
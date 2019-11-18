CREATE TABLE IF NOT EXISTS `maxidom_map` (
        `ID` INT(11) NOT NULL AUTO_INCREMENT,
        `DATA` MEDIUMTEXT,
        `CENTER` varchar(256) DEFAULT NULL,
  		`ZOOM` int(11) DEFAULT NULL,
        PRIMARY KEY(ID)
    );
    
INSERT INTO `maxidom_map`
		(`CENTER`, `ZOOM`) VALUES
		('[60.0028676450789,30.38387187724971]', 12);
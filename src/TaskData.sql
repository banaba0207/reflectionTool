CREATE TABLE TaskData (
taskDataId unsigned int(11) NOT NULL AUTO_INCREMENT,
task VARCHAR(100),
isClosed unsigned int(1) DEFAULT 0,
startTime timestamp DEFAULT CURRENT_TIMESTAMP,
endTime timestamp ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (taskDataId)
);

CREATE TABLE TaskData (taskDataId INT(11) NOT NULL AUTO_INCREMENT, task VARCHAR(100),isClosed INT(1) DEFAULT 0, startTime timestamp DEFAULT CURRENT_TIMESTAMP,endTime timestamp ON UPDATE CURRENT_TIMESTAMP,PRIMARY KEY (taskDataId));

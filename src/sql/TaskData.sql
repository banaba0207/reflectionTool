CREATE TABLE TaskData (
taskDataId  unsigned int(11) NOT NULL AUTO_INCREMENT,
task        VARCHAR(100),
isClosed    unsigned int(1) DEFAULT 0,
isCutInTask unsigned int(1) DEFAULT 0,
startTime   timestamp DEFAULT CURRENT_TIMESTAMP,
endTime     timestamp ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (taskDataId)
);

CREATE TABLE euler_test.TaskData (
taskDataId  int(11) unsigned NOT NULL AUTO_INCREMENT,
task        VARCHAR(100),
isClosed    int(1) unsigned DEFAULT 0,
isCutInTask int(1) unsigned DEFAULT 0,
startTime   timestamp DEFAULT CURRENT_TIMESTAMP,
endTime     timestamp ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (taskDataId)
);

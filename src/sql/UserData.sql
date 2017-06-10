CREATE TABLE euler_test.UserData (
`userId`      int(11) unsigned NOT NULL AUTO_INCREMENT,
`name`        VARCHAR(50),
`password`    VARCHAR(255),
`createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
`updatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
PRIMARY KEY (userId)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='ユーザーデータ';

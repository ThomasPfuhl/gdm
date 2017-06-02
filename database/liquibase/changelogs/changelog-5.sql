--liquibase formatted sql

--changeset id:5 author:thomas.pfuhl dbms:mysql

--preconditions onFail:HALT onError:HALT

CREATE TABLE IF NOT EXISTS foobar (
	`id`    BIGINT	UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`title` VARCHAR(100)    COMMENT 'title'
) COMMENT 'foobar';
--rollback drop table foobar;


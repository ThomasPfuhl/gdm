--liquibase formatted sql

--changeset id:4 author:thomas.pfuhl dbms:mysql

--preconditions onFail:HALT onError:HALT

CREATE TABLE IF NOT EXISTS dummy (
	`id`    BIGINT	UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`title` VARCHAR(100)    COMMENT 'title'
) COMMENT 'dummy';
--rollback drop table dummy;


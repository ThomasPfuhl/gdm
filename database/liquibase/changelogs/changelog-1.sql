--liquibase formatted sql

--changeset id:1 author:falko.gloeckler dbms:mysql

--preconditions onFail:HALT onError:HALT
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS projects (
	`id`                 BIGINT	UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	`title`              VARCHAR(200)	COMMENT 'Title of the project',
	`description`        TEXT	COMMENT 'Abstract of the project',
	`startDate`          DATE	COMMENT 'Date of project start',
	`endDate`            DATE	COMMENT 'Date of project end',
	`remarks`            TEXT	COMMENT 'Remarks related to the project',
	`officialProjectID`  VARCHAR(200)	COMMENT 'The project''s identifier or reference that is assigned by official instances (e.g. the funding agency,  GEPRIS ID, other funding ID)',
	`sapID`              VARCHAR(100)	COMMENT 'Foreign key to the SAP system. No joins possible, but manual reference to SAP'
) COMMENT 'main table';
--rollback drop table projects;

CREATE TABLE IF NOT EXISTS proposals (
	`id`            BIGINT	UNSIGNED COMMENT 'Primary key of the proposals table' PRIMARY KEY AUTO_INCREMENT,
	`projectID`	BIGINT	UNSIGNED COMMENT 'Foreign key to the projects table' DEFAULT	1,
	`fundingAgencyID`	BIGINT	UNSIGNED COMMENT 'Foreign key to the agencies table as funding agency',
	`submissonDate`	DATE	COMMENT 'Date of submission',
	`acceptionDate`	DATE	COMMENT 'Date of proposal acception',
	`rejectionDate`	DATE	COMMENT 'Date of proposal rejection',
	`principalInvestigatorID`	BIGINT	UNSIGNED COMMENT 'foreign key to the agents table',
	`status`          VARCHAR(100)	COMMENT 'Status of the proposal: submitted, accepted, rejected. Has controlled vocabulary: (submitted|accepted|rejected)',
	`call`            VARCHAR(500)	COMMENT 'Reference to the call for proposals',
	`proposedFunding`	FLOAT	COMMENT 'Proposed amount of money',
	`grantedFunding`	FLOAT	COMMENT 'Amount of money that has been granted',
	`proposedFundingCurrency`   VARCHAR(3)	COMMENT 'Currency of the proposed amount of money, expressed in	3letter-ISO-Standard' DEFAULT 'EUR',
	`startDate`     DATE	COMMENT 'Date of proposed project start',
	`endDate`       DATE	COMMENT 'Date of proposed project end',
	`remarks`       TEXT	COMMENT 'Remarks related to the proposal',
        FOREIGN KEY (projectID) REFERENCES projects(id),
        FOREIGN KEY (fundingAgencyID) REFERENCES agencies(id),
        FOREIGN KEY (principalInvestigatorID) REFERENCES agents(id)
) COMMENT 'Table of proposals, regardless of the status of proposal or derived project';
--rollback drop table proposals;

CREATE TABLE IF NOT EXISTS agents (
	`id`	BIGINT	UNSIGNED COMMENT 'Primary key of the agents table' PRIMARY KEY AUTO_INCREMENT,
	`orcid`	VARCHAR(100)	COMMENT 'ORCID of the person',
	`title`	VARCHAR(100)	COMMENT 'Academic degree of the person',
	`givenName`	VARCHAR(100)	COMMENT 'Given name of the person',
	`familyName`	VARCHAR(100)	COMMENT 'Family name of the person',
	`institutionID`	BIGINT UNSIGNED	COMMENT 'Foreign key to the institutions table as affiliation of the agent',
	`role`	VARCHAR(500)	COMMENT 'Role or Position of the person',
	`email`	VARCHAR(100)	COMMENT 'Email address of the person',
	`phone`	VARCHAR(100)	COMMENT 'Telephone number of the person including country code',
	`fax`	VARCHAR(100)	COMMENT 'Fax number of the person including country code',
	`website`  VARCHAR(500)	COMMENT 'URL of the personal website of the person. Syntax: valid URL',
        FOREIGN KEY (institutionID) REFERENCES institutions(id)
) COMMENT 'Table of agents. This can be natural persons or bodies / committees.';
--rollback drop table agents;

CREATE TABLE IF NOT EXISTS agencies	(
	`id`	BIGINT	UNSIGNED        COMMENT 'Primary key of the agencies table' PRIMARY KEY AUTO_INCREMENT,
	`name`	VARCHAR(500)            COMMENT 'Name of the funding agency or funder',
	`abbrev`	VARCHAR(100)	COMMENT 'Abbreviation of the funding agency or funder',
	`address`	TEXT            COMMENT 'Address of the agency',
	`type`	VARCHAR(100)	COMMENT 'Type of the agency. Has controlled vocabulary: (local|regional|national|European|other)'
) COMMENT 'Table of agencies e.g. for funding, support, permissions, etc.';
--rollback drop table agencies;

CREATE TABLE IF NOT EXISTS institutions	(
	`id`	BIGINT	UNSIGNED        COMMENT 'Primary key of the institutions table' PRIMARY KEY AUTO_INCREMENT,
	`name`	VARCHAR(500)            COMMENT 'Name of the institution',
	`abbrev`	VARCHAR(100)	COMMENT 'Abbreviation of the institution',
	`address`	TEXT            COMMENT 'Address of the institution',
	`countryISO2`	VARCHAR(100)	COMMENT 'ISO 3166 ALPHA2 country code of the institution'
) COMMENT 'Table of institutions. This can be institutes s.str., organizations or bodies / committees';
--rollback drop table institutions;

CREATE TABLE IF NOT EXISTS networkPartners(
	`projectID`	BIGINT	UNSIGNED    COMMENT 'Foreign key to the projects table',
	`proposalID`	BIGINT	UNSIGNED    COMMENT 'Foreign key to the proposals table',
	`institutionID`	BIGINT	UNSIGNED    COMMENT 'Foreign key to the institutions table as indication of the partner institution'	DEFAULT 1,
	`networkTypeID`	BIGINT	UNSIGNED    COMMENT 'Foreign key to the networksType table'	DEFAULT 1
) COMMENT' Table of network partners.	A look-up table for many-to-many relations between partners';
--rollback drop table networkPartners;


CREATE TABLE IF NOT EXISTS networks	(
	`id`    BIGINT	UNSIGNED    COMMENT 'Primary key of the networks table' PRIMARY KEY AUTO_INCREMENT,
	`type`	VARCHAR(500)    COMMENT 'Category or type of the Network. Has controlled vocabulary: (consortium|association|other)'
) COMMENT 'Table of networks. As the network partners table this is a look-up reference';
--rollback drop table networks;

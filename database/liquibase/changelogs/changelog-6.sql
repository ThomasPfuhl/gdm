-- liquibase formatted sql

-- changeset id:6 author:thomas.pfuhl dbms:mysql

-- preconditions onFail:HALT onError:HALT
INSERT INTO `proposals` (`fundingAgencyID`,`submissonDate`,`acceptionDate`,`rejectionDate`,`principalInvestigatorID`,`status`,`call`,`proposedFunding`,`grantedFunding`,`proposedFundingCurrency`,`startDate`,`endDate`,`remarks`) 
VALUES (1,'2020-01-01','2020-06-30',NULL,1,'accepted','Call 6',1000000,800000,'EUR','2020-01-01','2020-12-31','Lorem ipsum dolor sit amet, consetetur sadipscing elitr');






ALTER TABLE  `members` ADD
FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`);

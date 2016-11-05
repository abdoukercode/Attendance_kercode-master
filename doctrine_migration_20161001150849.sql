# Doctrine Migration File Generated on 2016-10-01 15:08:49

# Version 20161001144603
ALTER TABLE student ADD email VARCHAR(255) NOT NULL;
CREATE UNIQUE INDEX UNIQ_B723AF33E7927C74 ON student (email);
INSERT INTO migration_versions (version) VALUES ('20161001144603');

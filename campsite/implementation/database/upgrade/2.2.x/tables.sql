BEGIN;

ALTER TABLE `UserPerm` ADD COLUMN `ManageReaders` ENUM('N', 'Y') NOT NULL DEFAULT 'N';
ALTER TABLE `UserTypes` ADD COLUMN `ManageReaders` ENUM('N', 'Y') NOT NULL DEFAULT 'N';

COMMIT;

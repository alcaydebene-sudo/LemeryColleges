-- Add COR file column to students table
-- Run this SQL command in your database to add the cor_file column

ALTER TABLE `students` 
ADD COLUMN `cor_file` VARCHAR(255) DEFAULT NULL AFTER `profile_image`;


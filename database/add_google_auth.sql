-- Add Google Authentication Support to Users Table
-- Run this in PHPMyAdmin or MySQL to enable Google Login

-- Check if google_id column exists, if not add it
ALTER TABLE users ADD COLUMN google_id VARCHAR(255) DEFAULT NULL;

-- Make password nullable for social login users
ALTER TABLE users MODIFY COLUMN password VARCHAR(255) NULL;

-- Add index for faster Google ID lookups
-- Note: If this fails, the index already exists
ALTER TABLE users ADD INDEX idx_google_id (google_id);

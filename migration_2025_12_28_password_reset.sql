-- Migration: Add password reset fields to users table
-- Date: 2025-12-28

USE autoscuola_liana;

-- Add reset_token and reset_expiry columns to users table
ALTER TABLE users
ADD COLUMN reset_token VARCHAR(64) NULL,
ADD COLUMN reset_expiry DATETIME NULL;

-- Add index on reset_token for faster lookups
CREATE INDEX idx_reset_token ON users(reset_token);

-- Add comment to document the new fields
ALTER TABLE users
ADD COMMENT 'Password reset token and expiry for forgot password functionality';
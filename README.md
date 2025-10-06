# BAUET Student Information Portal

This project provides a three-step student information form for the Bangladesh Army University of Engineering and Technology (BAUET), Department of Law and Justice, Batch 7th.

## Getting Started

1. Import the SQL schema:
   ```sql
   SOURCE students_bauet.sql;
   ```
   This creates the `bauet_students` database with the `students_bauet` table.
2. Update `db_config.php` with your MySQL credentials.
3. Serve the project from a PHP-enabled web server (e.g., Apache, Nginx, or PHP's built-in server).
4. Open `index.php` to access the multi-step submission form, and visit `admin.php` to review submissions.

Uploaded profile images are stored in the `uploads/` directory.

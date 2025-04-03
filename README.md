# Gourmet Destination
Group 3's project for INFO 3135

# Setup (MySQL)
1. Run the entire `init_db.sql` file to create all required tables and populate necessary tables
    - Schema name should be `gourmet_destination`

# Setup (XAMPP)
**NOTE: WINDOWS DEFENDER CURRENTLY FALSELY IDENTIFIES `public\actions\experience-info-form-action.php` AS MALWARE AND WILL AUTOMATICALLY DELETE/QUARENTINE THE FILE. YOU MAY HAVE TO CREATE AN EXCLUSION IN WINDOWS DEFENDER FOR THIS PROJECT TO WORK.**
1. Install [Git](https://git-scm.com/) and [Composer](https://getcomposer.org/) if you haven't yet
2. Open your terminal and navigate to your `htdocs` folder
    - Should be something like `cd C:\xampp\htdocs`
3. Run the command `git clone https://github.com/haminpants/gourmet-destination.git GourmetDestination`
    - This should create a folder called `GourmetDestination` in your `htdocs` folder with files from the project
4. In the same terminal, navigate to the `GourmetDestination` folder
    - Should be something like `cd GourmetDestination`
5. In the same terminal, run the command `composer install`
    - When complete, there should be a `vendor` folder with the following contents:
        - `composer`
        - `stripe`
        - `autoload.php`
6. Go to the `config` folder and create copy of the `db_info_example.ini` named `db_info.ini`, enter info as needed
7. Still in the `config` folder, create a copy of the `api_keys_example.ini` named `api_keys.ini`, enter info as needed
8. Open XAMPP and **stop the Apache service, if running**
9. Open the Apache service's "php.ini"
    - Should be the fourth option from the Apache service's config button
10. Search for `extension=gd`, which should have one match
11. Remove the `;` in front of the `extensnion=gd` to uncomment the line and enable the `gd` extension, save changes
12. Open the Apache service's `httpd.conf`
    - Should be the first option from the Apache service's config button
13. Search for `htdocs` (CTRL+F), which should have two matches
    - First match should be `DocumentRoot "C:/xampp/htdocs"`
    - Second match should be `<Directory "C:/xampp/htdocs">`
14. Add `/GourmetDestination/public` to the end of both file paths
    - First match should look like `DocumentRoot "C:/xampp/htdocs/GourmetDestination/public"`
    - Second match should look like `<Directory "C:/xampp/htdocs/GourmetDestination/public">`
15. Save the changes and start the Apache service (Or restart it if you forgot to stop it before making the changes)
16. Navigating to `localhost` should now display the `index.php` in `/public`

**Note:** You can undo the `DocumentRoot` change at anytime by repeating steps 12-15, but instead of adding `/GourmetDestination/public`, remove it!
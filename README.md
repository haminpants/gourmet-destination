# Gourmet Destination
Group 3's project for INFO 3135

# Setup (XAMPP)
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
6. Go to the `config` folder and create copy of the `example-db-config.ini` named `db_info.ini`, enter info as needed
7. Open XAMPP and **stop the Apache service, if running**
8. Open the Apache service's "php.ini"
    - Should be the fourth option from the Apache service's config button
9. Search for `extension=gd`, which should have one match
10. Remove the `;` in front of the `extensnion=gd` to uncomment the line and enable the `gd` extension
11. Save the change and start the Apache service (Or restart it if you forgot to stop it before making the changes)
### Optional (But Recommended) Setup
1. Open XAMPP and **stop the Apache service, if running**
2. Open the Apache service's `httpd.conf`
    - Should be the first option from the Apache service's config button
3. Search for `htdocs` (CTRL+F), which should have two matches
    - First match should be `DocumentRoot "C:/xampp/htdocs"`
    - Second match should be `<Directory "C:/xampp/htdocs">`
4. Add `/GourmetDestination/public` to the end of both file paths
    - First match should look like `DocumentRoot "C:/xampp/htdocs/GourmetDestination/public"`
    - Second match should look like `<Directory "C:/xampp/htdocs/GourmetDestination/public">`
5. Save the changes and start the Apache service (Or restart it if you forgot to stop it before making the changes)
6. Navigating to `localhost` should now display the `index.php` in `/public`

**Note:** You can undo this change at anytime by repeating the steps above, but instead of adding `/GourmetDestination/public`, remove it!
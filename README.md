## ✨ Inventory Management System

## 😎 Features

-   POS
-   Orders
    -   Pending Orders
    -   Complete Orders
    -   Pending Due
-   Purchases
    -   All Purchases
    -   Approval Purchases
    -   Purchase Report
-   Products
-   Customers
-   Suppliers

## 🚀 How to Use

2. **Setup**

    ```bash
    # Go into the repository
    cd WEB-APP-ADMIN

    # Install dependencies
    composer install

    # Open with your text editor
    code .
    ```

3. **.ENV**
   Rename or copy the `.env.example` file to `.env`
    ```bash
    # Generate app key
    php artisan key:generate
    ```
4. **Custom Faker Locale**
   To set Faker Locale, add this line of code to the end `.env` file.

    ```bash
    # In this case, the locale is set to Indonesian

    FAKER_LOCALE="id_ID"
    ```

5. **Setup Database**
   Setup your database credentials in your `.env` file.

6. **Seed Database**

    ```bash
    php artisan migrate:fresh --seed
    ```

    _Note: If showing an error, please try to rerun this command._

7. **Create Storage Link**

    ```bash
    php artisan storage:link
    ```

8. **Run Server**

    ```bash
    php artisan serve
    ```

9. **Login**
   Try login with username: `admin` and password: `password`

# Create .env file
    APP_NAME="Patel Consultancy"
    APP_URL=
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=patel_consultancy_staging
    DB_USERNAME=root
    DB_PASSWORD=
    MAIL_DRIVER=smtp
    MAIL_HOST=mail.patelconsultancy2005.com
    MAIL_PORT=587
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    MAIL_FROM_ADDRESS=noreplay@patelconsultancy2005.com
    MAIL_FROM_NAME="Patel Consultancy"


http://patelconsultancy2005.com/staging/public/login

    . > php composer.phar install

    . > php artisan key:gen

    . > php artisan migrate:fresh --seed

    . > superadmin@gmail.com
        123456


Cron Jobs:
    {{host}}/notification
        - daily - send email to user before 15 days of premium due date

# Insurance > fields module
    - hide, insurance field module


# Mutual Fund
- Inflow SIP
    - If all the installments are paid regularly SIP is Inflow
- Outflow SIP
    - If any installment of sip is not paid then that sip is consider in outflow

# Insurance

- Life Traditional Insurance
    ```
    Surrender policy only after 3 year of issue date
    All premium must be paid up to surrender date.
    Surrender date must not after the Last date of Policy Term
    ```
# Goal plan
    - If insurance status is open then only display in goal plan

# Invested amount
    - invested amount will not decrease when, user withdraw amount from Ulip plan or Mutual fund sip
# F-K-SAVINGS
This backend project uses PHP to achieve the following 
1. register and login users 
2. allow users to fund wallet using the paystack API
3. allow users to transfer fund into other users wallets

The following are achieved using different PHP classes to handle registration, login, authenication, verification of payment and funding wallet
The database is managed on mysql xampp Server 

The JWT handler was used to handle encoder and decoder of the classes 

The API were tested on postman to attest they work. 

For the testing, 

The login and registration are in json format 
The funding wallet and transfer fund are in form-data format 

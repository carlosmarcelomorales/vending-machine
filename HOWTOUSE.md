# How to Use

## Installation

For installing the project correctly use this command from the root of the project:

> make init


Now, the  docker of the project is already running and ready to use. You can use the next command to validate that everything
is running:

> docker compose ps

This should have the containers running and also should have created a database named vending_machine with 2 tables: 
Items(item_id, name, stock, price) and Wallets(wallet_id, balance).

Thanks to the Makefile we can use a sort of commands in an easy way. To start and stop the docker we will use

> make start

> make stop

When we want to enter inside the php-fpm container we can use:

> make interactive

And for running all the tests we will use

> make test

## Comments

For this project I took the next statement. Every user who wants to use it has a wallet. So when the user is adding money, 
it doesn't save "into the machine", it will save on its wallet.

I took this decision because for me it made more sense to save it here instead of keeping it in the machine. Because if
the user wants to refund money, it makes more sense that it refunds the amount that he introduced, not from all the 
coins that the machine has inside.

## Usage

For a correct usage of the program, i prepared a POSTMAN collection, that you can find on the root of the project.

It has 4 different endpoints. Let's start with the order that you should use.

### 1. Add Money
This will add money to the current wallet of the user. If the user doesn't have a wallet then it will be created.
So basically, if you use this request sending the parameter walletId, it will take your wallet and add the money there.

If you don't send it, your new wallet will be created and it will be returned on the response so that you can use it
in further operations.

You can specify the amount that you want to add by changing the amount parameter. Notice that the machine only accepts
0.05, 0.10, 0.25, and 1.

### 2. Sell Item
This operation will make you buy a product that you choose. It can be Water, Juice or Soda. Here I decided to use the 
name of the product instead of sending an Id, because of the requirements of the product. If you add a product that
doesn't exist, the machine should not work.

Also, I decided to call it SellItem instead of BuyItem, because I'm looking from the perspective of the machine. 
The machine sells the item, the user buy it. In my case, I'm focusing on how the machine works, so for me it's Selling.

Once doing this request, the machine is selling an item. This means that the stock of this item is reduced in 1 and also,
the price of the item is discounted from the total amount of my wallet.

So, if I continue doing the same request, at some moment I should get a message saying that either the product has not 
available stock anymore, or that my wallet doesn't have enough money to validate the purchase.

### 3. Refund Money
Now, let's imagine that the user doesn't want anything else to drink and wants to refund the money. By calling to this 
endpoint, the machine should return all the money in different coins and set the total balance of the wallet at 0.
It will return an array with the different values (0.05, 0.10, 0.25, and 1) and how many of each coins it returns.

So after this, if the user wants to buy something, it will show the message saying that there is not enough money.

### 4. Add stock
Now, imagine that the previous user was so thirsty and took all the drinks. We will use the name and the amount of units
that we want to add to the stock. So every time we call to this endpoint, we will be updating the total. We don't set the
stock value, we add what we introduce to the current amount.

## Testing

All the test from the project are in the folder tests. There are all Unit tests, where I tried to test the complex and 
important business logic for the product.

Once again, you can run all the test using:

> make test

## What if I had more time...

If I had more time, I would have liked to add some acceptance test or e2e tests. I would have liked to test how it 
functions since the user makes the request until it gets the response.

I also would have used Doctrine, as it's the main ORM of symfony. I started doing it but I was having some problems 
because of the value objects that I created, so it started being a bit tricky. In order not to spend much time doing this,
I decided to find another way.

Maybe I should have used migrations also, instead of creating the database from init with Docker, but for me it was easier
because in this case, it's a really small project with a small database. So it was simple.
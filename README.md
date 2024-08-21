## Installation
The app has its own docker compose setup and a make file with frequently used command. In order to run the app simply run ``` make up-detached ```. This will create and start two docker cotainers (nginx and php).

## Running the app
In order to run you can use any http client available. Make a POST request to ```http://localhost/discount/apply``` with the body from one of the three ```json``` example files provided in the folder ```example-orders```. Please note that these aren't the files from the requirement because the values were all strings, although they represented a different data type. When you build apps that communicate with eachother, it is importat the correct type of data in the payload.

In order to do a static analysis of the code and to run the PHP Sniffer I integrated grumPHP ```make grumphp```

## Notes about the architecture
The app flow is quite simple: The request goes to the ```App\Discount\Controller\ApplyDiscountController``` it is validated, processed by ```App\Discount\Processor\OrderDiscountProcessor``` and then sent as json to the client. The processor does the most complex part. It loops through all the classes that implement the ```App\Discount\Applicator\DiscountApplicatorInterface``` and alter the output if possible.

The output is similar to the input, the only difference is that the ```item``` has a extra field called ```totalWithDiscount```. The value will change if an item has a discount applied to it.
The ```order``` object has two more fields: ```totalWithDiscount``` and ```discounts```. The first is self explanatory, similar to the item's field. The other one is a list of objects with a ```type``` and a ```value``` to have a clear picture of the discounts applied to the order.

I built this app starting from the fact that will show only how I "translate" the requirements into code. I made some shortcuts, for example the ```CustomerRepository``` is not linked to a database because it would have required more effort that I didn't find necessary at this point.

The discounts would have another structure in real life. The classes that implement ```App\Discount\Applicator\DiscountApplicatorInterface``` would have a configuration saved in the database for discount value or item count threshold. I would create a list of rules (config of the ```supports``` method) and a set of actions (config of the ```apply``` method).